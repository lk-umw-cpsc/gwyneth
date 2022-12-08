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

let remainingNumbers;
let studiedPile = [];

function roll() {
    if (remainingNumbers.length == 0) {
        // TO-DO: Ask user if they want to keep going
        return;
    }
    let number = remainingNumbers.pop();
    if (Math.random() > 0.5) {
        mode = MODE_TRANSLATE;
        promptQuestion.html('What number is this?');
        promptNumber.html(number.french);
        answer = number.number;
    } else {
        mode = MODE_TYPE;
        promptQuestion.html('Write in French:');
        promptNumber.html(number.number)
        answer = number.french;
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
        correctAnswerSound.load();
        correctAnswerSound.play();
        $(':root').addClass('correct').on('animationend', correctAnimationEnded);
        lockInterface();
    } else {
        incorrectAnswerSound.load();
        incorrectAnswerSound.play();
        $(':root').addClass('incorrect').on('animationend', function(){$(this).removeClass('incorrect').off('animationend')});
    }
}

function lockInterface() {
    userInput.prop('disabled', true);
    checkButton.html('Good job!');
}

function unlockInterface() {
    userInput.val('');
    userInput.prop('disabled', false);
    userInput.focus();
    checkButton.html('Check');
}

function correctAnimationEnded() {
    $(this).removeClass('correct').off('animationend');
    unlockInterface();
    roll();
}

function shuffleArray(arr) {
    const length = arr.length;
    const iters = length - 1;
    for (let i = 0; i < iters; i++) {
        r = Math.floor(Math.random() * (length - i)) + i;
        let tmp = arr[i];
        arr[i] = arr[r];
        arr[r] = tmp;
    }
}

function numbersFetched() {
    let response = JSON.parse(this.responseText);
    let numbers = response.numbers;
    const length = numbers.length;
    remainingNumbers = new Array(length);
    for (let i = 0; i < length; i++) {
        remainingNumbers[i] = numbers[i];
    }
    shuffleArray(remainingNumbers);
    roll();
}

function fetchFailed() {
    console.log("Fetch failed!");
}

function fetchNumbers() {
    // window.location.href
    sendAJAXRequest('/numbers/fetch', { learned: true }, numbersFetched, fetchFailed);
}

function sendAJAXRequest(url, requestData, onSuccess, onFailure) {
    var request = new XMLHttpRequest();
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onload = onSuccess;
    request.onerror = onFailure;
    request.send(JSON.stringify(requestData));
    return false;
}

$(function() {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    const audioCtx = new AudioContext();
    incorrectAnswerSound = new Audio('/static/sounds/incorrect.wav');
    correctAnswerSound = new Audio('/static/sounds/correct.wav');
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

    fetchNumbers();
});