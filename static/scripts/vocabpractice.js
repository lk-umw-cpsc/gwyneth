let userInput;
let promptQuestion;
let promptTerm;

let mode;
let answer;
let checkButton;
const MODE_TRANSLATE_TO_ENGLISH = 0;
const MODE_TRANSLATE_TO_FRENCH = 1;

const STATE_PROMPT = 0;
const STATE_VIEW_ANSWER = 1;
let state = STATE_PROMPT;

let incorrectAnswerSound;
let correctAnswerSound;

let remainingTerms;
let incorrectPile = [];
let rootElement;

let currentTerm;
let currentDifficulty;

let categoryID;

let sound;

function chooseAndDisplayNextPrompt() {
    if (remainingTerms.length > 0) {
        if (incorrectPile.length > 0 && currentTerm.difficulty > remainingTerms[remainingTerms.length - 1].difficulty) {
            shuffleArray(incorrectPile);
            remainingTerms = remainingTerms.concat(incorrectPile);
            incorrectPile = [];
        }
    } else if (incorrectPile.length > 0) {
        shuffleArray(incorrectPile);
        remainingTerms = incorrectPile;
        incorrectPile = [];
    } else {
        $('#prompt-container').addClass('hidden');
        $('#out-of-cards').removeClass('hidden');
        return;
    }
    currentTerm = remainingTerms.pop();
    if (Math.random() > 0.5) {
        mode = MODE_TRANSLATE_TO_ENGLISH;
        promptQuestion.html('Translate to English:');
        promptTerm.html(currentTerm.french);
        answer = currentTerm.english;
    } else {
        mode = MODE_TRANSLATE_TO_FRENCH;
        promptQuestion.html('Translate to French:');
        promptTerm.html(currentTerm.english);
        answer = currentTerm.french;
    }
    let length = promptTerm.html().length;
    if (length < 5) {
        promptTerm.attr('class', 'biggest');
    } else if (length < 10) {
        promptTerm.attr('class', 'bigger');
    } else {
        promptTerm.attr('class', 'big');
    }
    if (currentTerm.gender === 'm') {
        promptTerm.addClass('masculine');
        promptTerm.removeClass('feminine');
    } else if (currentTerm.gender === 'f') {
        promptTerm.removeClass('masculine');
        promptTerm.addClass('feminine');
    } else {
        promptTerm.removeClass('masculine');
        promptTerm.removeClass('feminine');
    }
}

function userSubmittedAnswer() {
    if (state == STATE_PROMPT) {
        let input = userInput.val().toLowerCase().trim();
        let correct;
        if (mode == MODE_TRANSLATE_TO_ENGLISH) {
            correct = input == currentTerm.english;
        } else {
            correct = input == currentTerm.french;
        }
        if (correct) {
            if (sound) {
                correctAnswerSound.play();
            }
            changeUICorrect();
            recordCorrect(currentTerm, true);
        } else {
            if (sound) {
                incorrectAnswerSound.play();
            }
            incorrectPile.push(currentTerm);
            recordCorrect(currentTerm, false);
            changeUIIncorrect();
        }
        state = STATE_VIEW_ANSWER;
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
    sendAJAXRequest('/vocab/update', { type: 'learn all' }, function() {
        location.reload();
    });
}

function termsFetched() {
    let response = JSON.parse(this.responseText);
    let terms = response.terms;
    const length = terms.length;
    if (length == 0) {
        $('#prompt-container').addClass('hidden');
        $('#none-learned').removeClass('hidden');
    } else {
        remainingTerms = new Array(length);
        for (let i = 0; i < length; i++) {
            remainingTerms[i] = terms[i];
        }
        shuffleArray(remainingTerms);
        remainingTerms.sort(compareDifficulty);
        chooseAndDisplayNextPrompt();
    }
}

function fetchFailed() {
    console.log("Fetch failed!");
}

function fetchTerms() {
    // window.location.href
    sendAJAXRequest('/vocab/' + categoryID + '/fetch', { learned: true }, termsFetched, fetchFailed);
}

function recordCorrect(term, correct) {
    sendAJAXRequest('/vocab/update', { type: 'attempt', term: term.id, correct: correct});
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
    categoryID = $('#category-id').val();
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
    promptTerm = $('#prompt-term');
    promptQuestion = $('#prompt-question');
    checkButton  = $('#check');
    checkButton.click(userSubmittedAnswer);
    rootElement = $(':root');
    $('#learn-more').click(function() { location.href = '/numbers/learn'; });
    $('#learn').click(function() { location.href = '/numbers/learn'; });
    $('#practice-anyway').click(practiceAnywayClicked);
    $('#practice-again').click(practiceAgainClicked);
    fetchTerms();
});