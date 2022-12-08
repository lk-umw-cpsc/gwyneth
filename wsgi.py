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
    welcome = 'welcome' in request.args
    name = session['name']
    return render_template('home.html', welcome=welcome, name=name)

@app.route('/vocab')
def vocab():
    return 'TBI'

@app.route('/verbs')
def verbs():
    return 'TBI'

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

@app.route('/numbers/fetch')
def numbers_fetch():
    if not user_logged_in():
        return "ERROR - User not logged in"
    data = request.get_json()
    if 'learned' not in data:
        return 'INVALID REQUEST'
    if data['learned']:
        return jsonify(numbers=get_user_known_numbers())
    return jsonify(numbers=get_user_unlearned_numbers())

# User account- and login-related routes
@app.route('/login', methods=['GET', 'POST'])
def login():
    if user_logged_in():
        return redirect(url_for('home'))
    
    if request.method == 'POST':
        form = request.form
        email = form['email']
        password = form['password']
        if authenticate_user(email, password) == 0:
            app.loggedin = True
        return redirect(url_for('home', welcome=1))
    return render_template("login.html")

@app.route('/register', methods=['GET', 'POST'])
def register():
    if user_logged_in():
        return redirect(url_for('home'))
    if request.method == 'POST':
        form = request.form
        email = form['email']
        password = form['password']
        name = form['name']
        success = create_user(email, password, name)
        if success:
            return redirect(url_for('login', creationSuccess=1))
        else:
            return render_template('register.html', creationError=1)
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

def user_logged_in():
    return 'userid' in session

def hash_password(password, salt):
    # using password-based key derivation with salt
    return hashlib.pbkdf2_hmac('sha256', password.encode(), salt, 10000)

def generate_password_salt():
    return os.urandom(32)

# MariaDB utility
def get_database():
    return mariadb.connect(user='undertoe', password='vXXtbewgyyWHMXuqc5nmKN29zk9yaxiM5zJy4CfPf4x85j138hzvEpw9d42HpIp1', host='localhost', port=3306, database='etudamie')

# Numbers related SQL functions
def get_user_unlearned_numbers():
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select base10, french from number where base10 not in (select base10 from userKnowsNumber where userid=?)', (id,))
    numbers = cursor.fetchall()
    connection.close()
    numbers_as_dicts = []
    for number, french in numbers:
        numbers_as_dicts.append({'number': number, 'french': french})
    return numbers_as_dicts

def get_user_known_numbers():
    id = session['userid']
    connection = get_database()
    cursor = connection.cursor()
    cursor.execute('select base10, french from number where base10 in (select base10 from userKnowsNumber where userid=?)', (id,))
    numbers = cursor.fetchall()
    connection.close()
    numbers_as_dicts = []
    for number, french in numbers:
        numbers_as_dicts.append({'number': number, 'french': french})
    return numbers_as_dicts