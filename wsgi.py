import hashlib
import os
import mariadb
from flask import Flask, render_template, redirect, url_for, request, session, jsonify, abort
import boto3

app = Flask(__name__)

app.secret_key = b'B\xc8v\x08>\x0f\xdc\xce\xfe\xc8\x07\x84\xaeg\xb7`\xbb\x05q\xa0b\xc8U\xd3\x91\x95\xc0F\xfb\r\xfca'

app.loggedin = False

@app.route('/')
def home():
    if not user_logged_in():
        return redirect(url_for('login'))
    new_user_welcome = 'just registered' in session
    login_welcome = not new_user_welcome and 'just logged in' in session
    if 'just logged in' in session:
        del session['just logged in']
    if new_user_welcome:
        del session['just registered']
    name = session['name']
    return render_template('home.html', name=name, new_user_welcome=new_user_welcome, login_welcome=login_welcome)

@app.route('/verbs')
def verbs():
    return 'TBI'

# Vocab pages
@app.route('/vocab/categories')
def vocab_categories():
    if not user_logged_in():
        return redirect(url_for('login'))
    is_admin = session['authorization'] == 2
    return render_template('vocabcategories.html', categories=get_categories(), is_admin=is_admin)

@app.route('/vocab/<int:category_id>')
def vocab_category(category_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    is_admin = session['authorization'] == 2
    name = get_category_name(category_id)
    if not name:
        return 'INVALID REQUEST'
    return render_template('vocab.html', category=name, category_id=category_id, is_admin=is_admin)

@app.route('/vocab/<int:category_id>/learn')
def vocab_learn(category_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    name = get_category_name(category_id)
    if not name:
        return 'INVALID REQUEST'
    return render_template('vocablearn.html', category=name, category_id=category_id)

@app.route('/vocab/<int:category_id>/practice')
def vocab_practice(category_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    name = get_category_name(category_id)
    if not name:
        return 'INVALID REQUEST'
    return render_template('vocabpractice.html', category=name, category_id=category_id)

@app.route('/vocab/<int:category_id>/fetch', methods=['POST'])
def vocab_fetch(category_id):
    if not user_logged_in():
        return 'INVALID REQUEST'
    args = request.get_json()
    if 'learned' not in args:
        return 'INVALID REQUEST'
    if args['learned']:
        return jsonify(terms=get_known_terms_in_category(category_id))
    return jsonify(terms=get_unlearned_terms_in_category(category_id))

# Vocab admin pages

@app.route('/vocab/categories/new', methods=['GET', 'POST'])
def vocab_new_category():
    if not user_logged_in():
        return redirect(url_for('login'))
    if session['authorization'] < 2:
        abort(404)
    if request.method == 'GET':
        return render_template('newcategory.html', categories=get_categories())
    else:
        form = request.form
        if 'name' not in form:
            return 'INVALID REQUEST'
        name = form['name']
        id = create_category(name)
        return redirect(url_for('vocab_edit_category', category_id=id))


@app.route('/vocab/<int:category_id>/edit', methods=['GET','POST'])
def vocab_edit_category(category_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    if session['authorization'] < 2:
        abort(404)
    if request.method == 'GET':
        name = get_category_name(category_id)
        if not name:
            return 'INVALID REQUEST'
        terms = get_all_terms_in_category(category_id)
        return render_template('vocabeditcategory.html', category_id=category_id, category=name, terms=terms)
    else:
        form = request.form
        if 'name' not in form or 'id' not in form:
            abort(400)
        category_name = form['name']
        # category_id = form['id']
        if rename_category(category_id, category_name):
            return redirect(url_for('vocab_category', category_id=category_id))
        else:
            abort(500)

@app.route('/vocab/<int:category_id>/add', methods=['POST', 'GET'])
def vocab_add_term(category_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    if session['authorization'] < 2:
        abort(404)
    name = get_category_name(category_id)
    if not name:
        abort(400)
    if request.method == 'GET':
        return render_template('newterm.html', category_id=category_id, category=name)
    else:
        form = request.form
        if 'french' not in form or 'english' not in form or 'french-alts' not in form or 'english-alts' not in form or 'gender' not in form:
            abort(400)
        french = form['french']
        english = form['english']
        french_alts = form['french-alts']
        english_alts = form['english-alts']
        if not french_alts:
            french_alts = None
        if not english_alts:
            english_alts = None
        gender = form['gender']
        gender_map = { 'n': 0, 'm': 1, 'f': 2}
        genderi = gender_map[gender]
        id = create_term_in_category(category_id, french, english, french_alts, english_alts, genderi)
        if id > 0:
            return render_template('newterm.html', category_id=category_id, prev_french=french, prev_english=english, prev_gender=gender, prev_id=id)
        else:
            return 'similar term already exists' # make this prettier
    
@app.route('/vocab/term/<int:term_id>/edit', methods=['POST', 'GET'])
def vocab_edit_term(term_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    if session['authorization'] < 2:
        abort(404)
    if request.method == 'GET':
        term = get_term_by_id(term_id)
        if not term:
            abort(400)
        # make alt answers form-friendly
        args = request.args
        if 'categoryID' in args:
            try:
                category_id = int(args['categoryID'])
            except:
                abort(400)
        else:
            category_id = -1
        if term['frenchAlts']:
            term['frenchAlts'] = '/'.join(term['frenchAlts'])
        else:
            term['frenchAlts'] = ''

        if term['englishAlts']:
            term['englishAlts'] = '/'.join(term['englishAlts'])
        else:
            term['englishAlts'] = ''
        return render_template('editterm.html', term=term, category_id=category_id)
    else:
        form = request.form
        if 'french' not in form or 'english' not in form or 'french-alts' not in form or 'english-alts' not in form or 'gender' not in form:
            abort(400)
        french = form['french']
        english = form['english']
        french_alts = form['french-alts']
        english_alts = form['english-alts']
        if not french_alts:
            french_alts = None
        if not english_alts:
            english_alts = None
        gender = form['gender']
        gender_map = { 'n': 0, 'm': 1, 'f': 2}
        gender = gender_map[gender]
        if 'category-id' in form:
            try:
                category_id = int(form['category-id'])
            except:
                abort(400)
        else:
            category_id = -1

        success = update_term_by_id(term_id, french, english, french_alts, english_alts, gender)            
        if success:
            if category_id > 0:
                return redirect(url_for('vocab_edit_category', category_id=category_id))
            else:
                # return to terms list here
                pass
        else:
            # handle case where term cannot be updated due to key constraint
            pass

@app.route('/vocab/term/<int:term_id>/speech')
def fetch_audio(term_id):
    if not user_logged_in():
        return redirect(url_for('login'))
    term = get_term_by_id(term_id)
    if not term:
        abort(404)
    id = query_speech(term['french'])
    return redirect(f'/static/sounds/speech/{id}.mp3')

@app.route('/vocab/update', methods=['POST'])
def vocab_update():
    if not user_logged_in():
        return 'INVALID REQUEST'

    args = request.get_json()
    if 'term' not in args or 'type' not in args:
        return 'INVALID REQUEST'
    
    term_id = args['term']
    update_type = args['type']
    if update_type not in { 'learned', 'learn all', 'attempt' }:
        return 'INVALID REQUEST'

    if update_type == 'learned':
        mark_term_as_learned(term_id)
    elif update_type == 'learn all':
        pass
    else:
        if 'correct' not in args:
            return 'INVALID REQUEST'
        record_term_attempt(term_id, args['correct'])
    return jsonify(success=True)

# Numbers pages
@app.route('/numbers')
def numbers():
    if not user_logged_in():
        return redirect(url_for('login'))
    return render_template('numbers.html')

@app.route('/numbers/learn')
def numbers_learn():
    if not user_logged_in():
        return redirect(url_for('login'))
    return render_template('numberslearn.html')

@app.route('/numbers/practice')
def numbers_practice():
    if not user_logged_in():
        return redirect(url_for('login'))
    return render_template('numberspractice.html')

@app.route('/numbers/fetch', methods=['POST'])
def numbers_fetch():
    if not user_logged_in():
        return 'INVALID REQUEST'
    data = request.get_json()
    if 'learned' not in data:
        return 'INVALID REQUEST'
    if data['learned']:
        return jsonify(numbers=get_user_known_numbers())
    return jsonify(numbers=get_user_unlearned_numbers())

@app.route('/numbers/update', methods=['POST'])
def numbers_update():
    if not user_logged_in():
        return "INVALID REQUEST"
    data = request.get_json()
    if 'type' not in data:
        return 'INVALID REQUEST'

    update_type = data['type']
    if update_type == 'learn all':
        mark_all_numbers_as_learned()
        return jsonify(sucess=True)
    
    if 'number' not in data:
        return 'INVALID REQUEST'
    number = data['number']
    if update_type == 'learned':
        mark_number_as_learned(number)
    elif update_type == 'attempt':
        if 'correct' not in data:
            return 'INVALID REQUEST'
        correct = data['correct']
        record_number_attempt(number, correct)
    else:
        return 'INVALID REQUEST'
    return jsonify(sucess=True)

# User account- and login-related routes
@app.route('/login', methods=['GET', 'POST'])
def login():
    if user_logged_in():
        return redirect(url_for('home'))
    
    if request.method == 'POST':
        form = request.form
        if 'email' not in form or 'password' not in form:
            return 'INVALID REQUEST'
        email = form['email'].lower()
        password = form['password']
        if not email or not password or len(email) > 254 or len(password) < 8 or len(password) > 1024:
            return 'INVALID REQUEST'
        result = authenticate_user(email, password)
        if result == 0:
            session['just logged in'] = 1
            return redirect(url_for('home'))
        else:
            return render_template('login.html', error=True)
    creation_success = 'creationSuccess' in request.args
    return render_template("login.html", creation_success=creation_success)

@app.route('/register', methods=['GET', 'POST'])
def register():
    if user_logged_in():
        return redirect(url_for('home'))
    if request.method == 'POST':
        form = request.form
        if 'email' not in form or 'password' not in form or 'name' not in form:
            return 'INVALID REQUEST'
        email = form['email'].lower()
        password = form['password']
        name = form['name']
        # to-do: add email validation here
        if not name or not email or not password or len(name) > 64 or len(email) > 254 or len(password) < 8 or len(password) > 1024:
            return 'INVALID REQUEST'
        success = create_user(email, password, name)
        if success:
            session['just registered'] = 1
            return redirect(url_for('login', creationSuccess=1))
        else:
            return render_template('register.html', creation_error=1)
    return render_template('register.html')

@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))   

@app.route('/account')
def account():
    if not user_logged_in():
        return redirect(url_for('login'))
    return "TBI"

# User creation, authentication, password hashing & salting utility
def create_user(email, password, name):
    salt = generate_password_salt()
    hash = hash_password(password, salt)

    salt_hex = salt.hex()
    hash_hex = hash.hex()

    authorization = 0
    if email == 'lknight2@mail.umw.edu':
        authorization = 2
    return insert_user(email, name, hash_hex, salt_hex, authorization)

def insert_user(email, name, hash_hex, salt_hex, authorization):
    connection = get_database()
    cursor = connection.cursor()
    try:
        cursor.execute('insert into user (email, name, passwordHash, salt, authorization) values (?, ?, ?, ?, ?)', (email, name, hash_hex, salt_hex, authorization))
        connection.commit()
    except mariadb.Error as e:
        print(e)
        return False
    finally:
        connection.close()
    return True

def authenticate_user(email, password):
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select passwordHash, salt from user where email=?', (email,))
    user_entry = cursor.fetchone()
    if not user_entry:
        connection.close()
        return 2

    stored_hash, salt_hex = user_entry
    salt = bytearray.fromhex(salt_hex)
    given_hash = hashlib.pbkdf2_hmac('sha256', password.encode(), salt, 10000).hex()
    if given_hash != stored_hash:
        connection.close()
        return 1
    
    cursor.execute('select name, id, authorization, email from user where email=?', (email,))
    name, id, authorization, email = cursor.fetchone()
    connection.close()
    session['userid'] = id
    session['name'] = name
    session['authorization'] = authorization
    session['email'] = email
    return 0

def hash_password(password, salt):
    # using password-based key derivation with salt
    return hashlib.pbkdf2_hmac('sha256', password.encode(), salt, 10000)

def is_invalid_email(email):
    pass

def user_logged_in():
    return 'userid' in session

def generate_password_salt():
    return os.urandom(32)

# MariaDB utility
def get_database():
    return mariadb.connect(user='undertoe', password='vXXtbewgyyWHMXuqc5nmKN29zk9yaxiM5zJy4CfPf4x85j138hzvEpw9d42HpIp1', host='localhost', port=3306, database='etudamie')

# Vocab related SQL functions
def create_category(name):
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('insert into category (sortindex, name, ischapter) values (default, ?, ?)', (name, False))
    resulting_id = cursor.lastrowid
    connection.commit()
    connection.close()
    return resulting_id

def create_term_in_category(category_id, french, english, french_alts, english_alts, gender):
    connection = get_database()
    cursor = connection.cursor()
    try:
        cursor.execute('insert into term (english, french, englishAlt, frenchAlt, gender) values (?, ?, ?, ?, ?)', (english, french, english_alts, french_alts, gender))
        term_id = cursor.lastrowid
        cursor.execute('insert into termInCategory (termid, categoryid) values (?, ?)', (term_id, category_id))
        connection.commit()
        return term_id
    except mariadb.Error as e:
        print(e)
        return -1
    finally:
        connection.close()

def rename_category(id, new_name):
    connection = get_database()
    cursor = connection.cursor()
    try:
        cursor.execute('update category set name=? where id=?', (new_name, id))
        connection.commit()
    except mariadb.Error as e:
        print(e)
        return False
    finally:
        connection.close()
    return True

def get_categories():
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select id, name from category where ischapter=0')
    categories = []
    for id, name in cursor.fetchall():
        category = {}
        category['id'] = id
        category['name'] = name
        categories.append(category)
    connection.close()
    return categories

def get_all_terms_in_category(category_id):
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select french, english, englishAlt, frenchAlt, id, gender from term where id in (select termid from termInCategory where categoryid=?)', (category_id,))
    terms = []
    for french, english, englishAlt, frenchAlt, id, gender in cursor.fetchall():
        if gender == 1:
            genderstr = 'm'
        elif gender == 2:
            genderstr = 'f'
        else:
            genderstr = 'n'

        term = {
            'french': french,
            'english': english,
            'englishAlts': englishAlt,
            'frenchAlts': frenchAlt,
            'id': id,
            'gender': genderstr
        }
        terms.append(term)
    connection.close()
    return terms

def get_known_terms_in_category(category_id):
    user_id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select id, english, french, englishAlt, frenchAlt, gender, difficulty from term, userKnowsTerm where id = termid and userid = ? and id in (select termid from termInCategory where categoryid=?) and id in (select termid from userKnowsTerm where userid=?)', (user_id, category_id, user_id))
    terms = []
    for id, english, french, englishAlt, frenchAlt, gender, difficulty in cursor.fetchall():
        if gender == 1:
            genderstr = 'm'
        elif gender == 2:
            genderstr = 'f'
        else:
            genderstr = 'n'
        if englishAlt:
            englishAlt = [alt.strip() for alt in englishAlt.split('/')]
        if frenchAlt:
            frenchAlt = [alt.strip() for alt in frenchAlt.split('/')]

        term = {
            'french': french,
            'english': english,
            'englishAlts': englishAlt,
            'frenchAlts': frenchAlt,
            'id': id,
            'gender': genderstr,
            'difficulty': difficulty
        }
        terms.append(term)
    connection.close()
    return terms

def get_unlearned_terms_in_category(category_id):
    user_id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select * from term where id in (select termid from termInCategory where categoryid=?) and id not in (select termid from userKnowsTerm where userid=?)', (category_id, user_id))
    terms = []
    for id, english, french, englishAlt, frenchAlt, gender in cursor.fetchall():
        if gender == 1:
            genderstr = 'm'
        elif gender == 2:
            genderstr = 'f'
        else:
            genderstr = 'n'

        term = {
            'french': french,
            'english': english,
            'englishAlts': englishAlt,
            'frenchAlts': frenchAlt,
            'id': id,
            'gender': genderstr
        }
        terms.append(term)
    connection.close()
    return terms

def get_category_name(category_id):
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select name from category where id=?', (category_id,))
    result = cursor.fetchone()
    if result == None:
        return None
    name, = result
    connection.close()
    return name

def mark_term_as_learned(term_id):
    user_id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('replace into userKnowsTerm values (?, ?, default)', (user_id, term_id))
    connection.commit()
    connection.close()

def record_term_attempt(term_id, correct):
    user_id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    if correct:
        cursor.execute('update userKnowsTerm set difficulty = (case when difficulty > 0 then difficulty - 1 else 0 end) where userid=? and termid=?', (user_id, term_id))
    else:
        cursor.execute('update userKnowsTerm set difficulty = (case when difficulty < 6 then difficulty + 2 else 7 end) where userid=? and termid=?', (user_id, term_id))
    connection.commit()
    connection.close()

def get_term_by_id(id):
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select id, english, french, englishAlt, frenchAlt, gender from term where id=?', (id,))
    result = cursor.fetchone()
    if not result:
        return None
    id, english, french, englishAlt, frenchAlt, gender = result
    if gender == 1:
        genderstr = 'm'
    elif gender == 2:
        genderstr = 'f'
    else:
        genderstr = 'n'
    if englishAlt:
        englishAlt = [alt.strip() for alt in englishAlt.split('/')]
    if frenchAlt:
        frenchAlt = [alt.strip() for alt in frenchAlt.split('/')]

    term = {
        'french': french,
        'english': english,
        'englishAlts': englishAlt,
        'frenchAlts': frenchAlt,
        'id': id,
        'gender': genderstr
    }
    return term

def update_term_by_id(id, french, english, french_alts, english_alts, gender):
    connection = get_database()
    cursor = connection.cursor()
    try:
        cursor.execute(
            'update term set french=?, english=?, frenchAlt=?, englishAlt=?, gender=? where id=?',
            (french, english, french_alts, english_alts, gender, id)
        )
        connection.commit()
        return True
    except mariadb.Error as e:
        print(e)
        return False
    finally:
        connection.close()

# Numbers related SQL functions
def get_user_unlearned_numbers():
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select base10, english, french from number where base10 not in (select base10 from userKnowsNumber where userid=?)', (id,))
    numbers = cursor.fetchall()
    connection.close()
    numbers_as_dicts = []
    for number, english, french in numbers:
        numbers_as_dicts.append({ 'number': number, 'english': english, 'french': french })
    return numbers_as_dicts

def get_user_known_numbers():
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select a.base10, french, english, difficulty from number as a, userKnowsNumber as b where a.base10=b.base10 and userid=?', (id,))
    numbers = cursor.fetchall()
    connection.close()
    numbers_as_dicts = []
    for number, french, english, difficulty in numbers:
        numbers_as_dicts.append({'number': number, 'french': french, 'english': english, 'difficulty': difficulty})
    return numbers_as_dicts

def mark_number_as_learned(number):
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('replace into userKnowsNumber values (?, ?, ?)', (id, number, 5))
    connection.commit()
    connection.close()

def mark_all_numbers_as_learned():
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select base10 from number where number.base10 not in (select base10 from userKnowsNumber where userid=?)', (id,))
    numbers = cursor.fetchall()
    for number, in numbers:
        cursor.execute('replace into userKnowsNumber values (?, ?, ?)', (id, number, 5))
    connection.commit()
    connection.close()

def record_number_attempt(number, correct):
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    if correct:
        cursor.execute('update userKnowsNumber set difficulty = (case when difficulty > 0 then difficulty - 1 else 0 end) where userid=? and base10=?', (id, number))
    else:
        cursor.execute('update userKnowsNumber set difficulty = (case when difficulty < 6 then difficulty + 2 else 7 end) where userid=? and base10=?', (id, number))
    connection.commit()
    connection.close()

def query_speech(phrase):
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute(
        'select id from speech where words=?',
        (phrase,)
    )
    result = cursor.fetchone()
    if result:
        id, = result
        connection.close()
        return id

    cursor.execute(
        'insert into speech (words) values (?)', (phrase,)
    )
    connection.commit()
    connection.close()
    id = cursor.lastrowid

    polly_client = boto3.client('polly')

    response = polly_client.synthesize_speech(VoiceId='Lea',
        OutputFormat='mp3', 
        Text = phrase,
        Engine = 'standard',
        LanguageCode='fr-FR')

    file = open(f'static/sounds/speech/{id}.mp3', 'wb')
    file.write(response['AudioStream'].read())
    file.close()
    return id
    