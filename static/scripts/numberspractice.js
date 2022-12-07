let userInput;
let promptQuestion;
let promptNumber;

let mode;
let answer;
let checkButton;
const MODE_TRANSLATE = 0;
const MODE_TYPE = 1;

let incorrectAnswerSound;
let correctAnswerSound;

let numbers = [
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
    'cent', 'cent un', 'mille', 'un million', 'un milliard'];

function roll() {
    if (Math.random() > 0.5) {
        mode = MODE_TRANSLATE;
        promptQuestion.html('What number is this?');
        choice = Math.floor(Math.random() * numbers.length);
        promptNumber.html(numbers[choice]);
        if (choice > 101) {
            choice = Math.pow(1000, choice - 101);
        }
        answer = choice;
    } else {
        mode = MODE_TYPE;
        promptQuestion.html('Write in French:');
        let choice = Math.floor(Math.random() * numbers.length);
        answer = numbers[choice];
        if (choice > 101) {
            choice = Math.pow(1000, choice - 101);
            choice = choice.toLocaleString('fr-FR');
        }
        promptNumber.html(choice);
    }
    let length = promptNumber.html().length;
    if (length < 5) {
        promptNumber.attr('class', 'biggest');
    } else if (length < 10) {
        promptNumber.attr('class', 'bigger');
    } else {
        promptNumber.attr('class', 'big');
    }
}

function checkAnswer() {
    let input = userInput.val().toLowerCase();
    let inputNoSpaces = input.replace(/\s/g, '');
    if (input == answer || inputNoSpaces == answer) {
        correctAnswerSound.play();
        userInput.val('');
        $(':root').addClass('correct').on('animationend', correctAnimationEnded);
        lockInterface();
} else {
        incorrectAnswerSound.play();
        $(':root').addClass('incorrect').on('animationend', function(){$(this).removeClass('incorrect').off('animationend')});
    }
}

function lockInterface() {
    userInput.prop('disabled', true);
    checkButton.html('Good job!');
}

function unlockInterface() {
    userInput.prop('disabled', false);
    userInput.focus();
    checkButton.html('Check');
}

function correctAnimationEnded() {
    $(this).removeClass('correct').off('animationend');
    unlockInterface();
    roll();
}

$(function() {
    incorrectAnswerSound = new Audio('/static/sounds/incorrect.wav');
    correctAnswerSound = new Audio('/static/sounds/correct.mp3');
    userInput = $('#user-input');
    userInput.keypress(function(event) {
        if (event.which == 13) {
            checkAnswer();
        }
    });
    promptNumber = $('#prompt-number');
    promptQuestion = $('#prompt-question');
    checkButton  = $('#check');
    checkButton.click(checkAnswer);
    roll();
});