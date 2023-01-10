import mariadb

category = "Vocab 1: Shopping & Food"
filename = '201.txt'

def get_database():
    return mariadb.connect(user='undertoe', password='vXXtbewgyyWHMXuqc5nmKN29zk9yaxiM5zJy4CfPf4x85j138hzvEpw9d42HpIp1', host='localhost', port=3306, database='etudamie')

connection = get_database()
cursor = connection.cursor()

def category_create(category_name, cursor):
    cursor.execute('insert into category (sortindex, name, ischapter) values (default, ?, ?)', (category_name, category_name.startswith('Liaisons Ch')))
    return cursor.lastrowid

category_id = category_create(category, cursor)

with open(filename) as f:
    for line in f:
        line = line.strip()
        if not line:
            continue
        french, english, gender = [x.strip() for x in line.split(',')]
        if gender == 'm':
            gender = 1
        elif gender == 'f':
            gender = 2
        else:
            gender = 0
        french = [x.strip() for x in french.split('/')]
        english = [x.strip() for x in english.split('/')]
        french_actual = french[0]
        english_actual = english[0]
        french_alts = '/'.join(french[1:]) if len(french) > 1 else None
        english_alts = '/'.join(english[1:]) if len(english) > 1 else None
        # english, french, english alts, french alts, gender (0/1/2), [Categories]
        cursor.execute('insert into term (english, french, englishAlt, frenchAlt, gender) values (?, ?, ?, ?, ?)', (english_actual, french_actual, english_alts, french_alts, gender))
        term_id = cursor.lastrowid
        cursor.execute('insert into termInCategory (termid, categoryid) values (?, ?)', (term_id, category_id))

connection.commit()
connection.close()