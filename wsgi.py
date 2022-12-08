import hashlib
import os
import mariadb
from flask import Flask, render_template, redirect, url_for, request

app = Flask(__name__)

app.loggedin = True

@app.route('/')
def home():
    if not app.loggedin:
        return redirect(url_for('login'))
    return render_template('home.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if app.loggedin:
        return redirect(url_for('home'))
    
    if request.method == 'POST':
        app.loggedin = True
        email = request.form['email']
        password = request.form['password']
        create_user(email, password, 'Lauren')
        return redirect(url_for('home'))
    return render_template("login.html")

@app.route('/register')
def register():
    return "TBI"

@app.route('/logout')
def logout():
    app.loggedin = False
    return redirect(url_for('login'))   

@app.route('/account')
def account():
    if not app.loggedin:
        return redirect(url_for('login'))
    return "TBI"

@app.route('/vocab')
def vocab():
    return 'TBI'

@app.route('/verbs')
def verbs():
    return 'TBI'

@app.route('/numbers')
def numbers():
    if not app.loggedin:
        return redirect(url_for('login'))
    return render_template('numbers.html')

@app.route('/numbers/practice')
def numbers_practice():
    if not app.loggedin:
        return redirect(url_for('login'))
    return render_template('numberspractice.html')

# MariaDB utility
def get_database():
    return mariadb.connect(user='undertoe', password='vXXtbewgyyWHMXuqc5nmKN29zk9yaxiM5zJy4CfPf4x85j138hzvEpw9d42HpIp1', host='localhost', port=3306, database='etudamie')

# User creation, authentication, password hashing & salting utility
def create_user(email, password, name):
    salt = generate_password_salt()
    hash = hash_password(password, salt)

    salt_hex = salt.hex()
    hash_hex = hash.hex()

    authorization = 0
    if email == 'lknight2@mail.umw.edu':
        authorization = 2
    insert_user(email, name, hash_hex, salt_hex, authorization)

def insert_user(email, name, hash_hex, salt_hex, authorization):
    connection = get_database()
    cursor = connection.cursor()
    try:
        cursor.execute('insert into user (email, name, passwordHash, salt, authorization) values (?, ?, ?, ?, ?)', (email, name, hash_hex, salt_hex, authorization))
    except mariadb.Error as e:
        print(e)
        return False
    return True

def hash_password(password, salt):
    return hashlib.pbkdf2_hmac('sha256', password.encode(), salt, 10000)

def generate_password_salt():
    return os.urandom(32)