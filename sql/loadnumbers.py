import mariadb

thing = [
    'zéro', 'un', 'deux', 'trois', 'quatre', 
    'cinq', 'six', 'sept', 'huit', 'neuf', 
    'dix', 'onze', 'douze', 'treize', 'quatorze', 
    'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf',
    'vingt', 'vingt et un', 'vingt-deux', 'vingt-trois', 'vingt-quatre', 
    'vingt-cinq', 'vingt-six', 'vingt-sept', 'vingt-huit', 'vingt-neuf',
    'trente', 'trente et un', 'trente-deux', 'trente-trois', 'trente-quatre',
    'trente-cinq', 'trente-six', 'trente-sept', 'trente-huit', 'trente-neuf',
    'quarante', 'quarante et un', 'quarante-deux', 'quarante-trois', 'quarante-quatre',
    'quarante-cinq', 'quarante-six', 'quarante-sept', 'quarante-huit', 'quarante-neuf',
    'cinquante', 'cinquante et un', 'cinquante-deux', 'cinquante-trois', 'cinquante-quatre',
    'cinquante-cinq', 'cinquante-six', 'cinquante-sept', 'cinquante-huit', 'cinquante-neuf',
    'soixante', 'soixante et un', 'soixante-deux', 'soixante-trois', 'soixante-quatre',
    'soixante-cinq', 'soixante-six', 'soixante-sept', 'soixante-huit', 'soixante-neuf',
    'soixante-dix', 'soixante et onze', 'soixante-douze', 'soixante-treize', 'soixante-quatorze',
    'soixante-quinze', 'soixante-seize', 'soixante-dix-sept', 'soixante-dix-huit', 'soixante-dix-neuf',
    'quatre-vingts', 'quatre-vingt-un', 'quatre-vingt-deux', 'quatre-vingt-trois', 'quatre-vingt-quatre',
    'quatre-vingt-cinq', 'quatre-vingt-six', 'quatre-vingt-sept', 'quatre-vingt-huit', 'quatre-vingt-neuf',
    'quatre-vingt-dix', 'quatre-vingt-onze', 'quatre-vingt-douze', 'quatre-vingt-treize', 'quatre-vingt-quatorze',
    'quatre-vingt-quinze', 'quatre-vingt-seize', 'quatre-vingt-dix-sept', 'quatre-vingt-dix-huit', 'quatre-vingt-dix-neuf',
    'cent'
]

connection = mariadb.connect(user='undertoe', password='vXXtbewgyyWHMXuqc5nmKN29zk9yaxiM5zJy4CfPf4x85j138hzvEpw9d42HpIp1', host='localhost', port=3306, database='etudamie')
cursor = connection.cursor()
for i, n in enumerate(thing):
    cursor.execute('insert into numbers value (?, ?)', (i, n))