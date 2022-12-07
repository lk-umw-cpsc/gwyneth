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