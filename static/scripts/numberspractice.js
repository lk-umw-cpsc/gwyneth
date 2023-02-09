let userInput;
let promptQuestion;
let promptNumber;
let promptContainer;

let mode;
let answer;
let checkButton;
const MODE_TRANSLATE = 0;
const MODE_TYPE = 1;

const STATE_PROMPT = 0;
const STATE_VIEW_ANSWER = 1;
let state = STATE_PROMPT;

let incorrectAnswerSound;
let correctAnswerSound;

let remainingNumbers;
let incorrectPile = [];
let rootElement;

let currentNumber;
let currentDifficulty;

let sound;
let speakButton;

function chooseAndDisplayNextPrompt() {
    if (remainingNumbers.length > 0) {
        if (incorrectPile.length > 0 && currentNumber.difficulty > remainingNumbers[remainingNumbers.length - 1].difficulty) {
            shuffleArray(incorrectPile);
            remainingNumbers = remainingNumbers.concat(incorrectPile);
            incorrectPile = [];
        }
    } else if (incorrectPile.length > 0) {
        shuffleArray(incorrectPile);
        remainingNumbers = incorrectPile;
        incorrectPile = [];
    } else {
        $('#prompt-container').addClass('hidden');
        $('#out-of-cards').removeClass('hidden');
        return;
    }
    currentNumber = remainingNumbers.pop();
    if (Math.random() > 0.5) {
        mode = MODE_TRANSLATE;
        promptQuestion.html('What number is this?');
        promptNumber.html(currentNumber.french);
        answer = currentNumber.number;
        speakButton.removeClass('disabled');
    } else {
        mode = MODE_TYPE;
        promptQuestion.html('Write in French:');
        promptNumber.html(currentNumber.number.toLocaleString('fr-FR'));
        answer = currentNumber.french;
        speakButton.addClass('disabled');
    }
    let length = promptNumber.html().length;
    if (length < 5) {
        promptContainer.attr('class', 'biggest');
    } else if (length < 10) {
        promptContainer.attr('class', 'bigger');
    } else {
        promptContainer.attr('class', 'big');
    }
}

function userSubmittedAnswer() {
    if (state == STATE_PROMPT) {
        let input = userInput.val().toLowerCase().trim();
        let correct;
        if (mode == MODE_TRANSLATE) {
            correct = input == currentNumber.english || input == currentNumber.english.replaceAll('-', ' ') || input == currentNumber.number || input.replaceAll(' ', '') == currentNumber.number;
        } else {
            correct = input == currentNumber.french;
        }
        if (correct) {
            if (sound) {
                correctAnswerSound.play();
            }
            changeUICorrect();
            recordCorrect(currentNumber, true);
        } else {
            if (sound) {
                incorrectAnswerSound.play();
            }
            incorrectPile.push(currentNumber);
            recordCorrect(currentNumber, false);
            changeUIIncorrect();
        }
        state = STATE_VIEW_ANSWER;
        speakButton.removeClass('disabled');
    } else if (state == STATE_VIEW_ANSWER) {
        chooseAndDisplayNextPrompt();
        unlockInterface();
        rootElement.removeClass('incorrect');
        rootElement.removeClass('correct');
        state = STATE_PROMPT;
    }
}

function changeUICorrect() {
    rootElement.addClass('correct');
    checkButton.html('Good job!');
    lockInterface();
}

function changeUIIncorrect() {
    rootElement.addClass('incorrect');
    userInput.val('Answer: ' + answer);
    lockInterface();
    checkButton.html('Next');
}

function lockInterface() {
    userInput.blur();
    userInput.prop('disabled', true);
}

function unlockInterface() {
    userInput.val('');
    userInput.prop('disabled', false);
    userInput.focus();
    checkButton.html('Check');
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

function compareDifficulty(a, b) {
    return a.difficulty - b.difficulty;
}

function practiceAgainClicked() {
    location.reload();
}

function practiceAnywayClicked() {
    $('#practice-anyway').prop('disabled', true);
    sendAJAXRequest('/numbers/update', { type: 'learn all' }, function() {
        location.reload();
    });
}

function numbersFetched() {
    let response = JSON.parse(this.responseText);
    let numbers = response.numbers;
    const length = numbers.length;
    if (length == 0) {
        // sendAJAXRequest('/numbers/update', { type: 'learn all' });
        $('#prompt-container').addClass('hidden');
        $('#none-learned').removeClass('hidden');
    } else {
        remainingNumbers = new Array(length);
        for (let i = 0; i < length; i++) {
            remainingNumbers[i] = numbers[i];
        }
        shuffleArray(remainingNumbers);
        remainingNumbers.sort(compareDifficulty);
        chooseAndDisplayNextPrompt();
    }
}

function fetchFailed() {
    console.log("Fetch failed!");
}

function fetchNumbers() {
    // window.location.href
    sendAJAXRequest('/numbers/fetch', { learned: true }, numbersFetched, fetchFailed);
}

function recordCorrect(number, correct) {
    sendAJAXRequest('/numbers/update', { type: 'attempt', number: number.number, correct: correct});
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

function speak() {
    if (!currentNumber.speech) {
        currentNumber.speech = new Audio(generateSoundURL());
    }
    currentNumber.speech.play();
}

function generateSoundURL() {
    return '/numbers/' + currentNumber.number + '/speech';
}

$(function() {
    // const AudioContext = window.AudioContext || window.webkitAudioContext;
    // const audioCtx = new AudioContext();
    sound = navigator.userAgent.indexOf("Chrome") != -1;
    if (sound) {
        incorrectAnswerSound = new Audio('/static/sounds/incorrect.wav');
        correctAnswerSound = new Audio('/static/sounds/correct.wav');
    }
    userInput = $('#user-input');
    userInput.keypress(function(event) {
        if (event.which == 13) {
            userSubmittedAnswer();
        }
    });
    $(document).keypress(function(event) {
        if (event.which == 13) {
            var tag = event.target.tagName.toLowerCase();
            if (tag == 'input' || state != STATE_VIEW_ANSWER) {
                return;
            }
            userSubmittedAnswer();
        }
    });

    speakButton = $("#speak-button");
    speakButton.click(speak);

    promptNumber = $('#prompt-number');
    promptQuestion = $('#prompt-question');
    promptContainer = $('#prompt-container');
    checkButton  = $('#check');
    checkButton.click(userSubmittedAnswer);
    rootElement = $(':root');
    $('#learn-more').click(function() { location.href = '/numbers/learn'; });
    $('#learn').click(function() { location.href = '/numbers/learn'; });
    $('#practice-anyway').click(practiceAnywayClicked);
    $('#practice-again').click(practiceAgainClicked);
    fetchNumbers();
});