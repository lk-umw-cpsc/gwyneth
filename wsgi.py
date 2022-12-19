import hashlib
import os
import mariadb
from flask import Flask, render_template, redirect, url_for, request, session, jsonify

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

@app.route('/vocab')
def vocab():
    return 'TBI'

@app.route('/verbs')
def verbs():
    return 'TBI'

# Vocab pages
@app.route('/vocab/categories')
def vocab_categories():
    if not user_logged_in():
        return redirect(url_for('login'))
    return render_template('vocabcategories.html', categories=get_categories())

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
        record_attempt(number, correct)
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

def record_attempt(number, correct):
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    if correct:
        cursor.execute('update userKnowsNumber set difficulty = (case when difficulty > 0 then difficulty - 1 else 0 end) where userid=? and base10=?', (id, number))
    else:
        cursor.execute('update userKnowsNumber set difficulty = (case when difficulty < 6 then difficulty + 2 else 7 end) where userid=? and base10=?', (id, number))
    connection.commit()
    connection.close()