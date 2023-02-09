let numbers;
let currentNumber;

let amountLearned = 0;

function sendAJAXRequest(url, requestData, onSuccess, onFailure) {
    var request = new XMLHttpRequest();
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onload = onSuccess;
    request.onerror = onFailure;
    request.send(JSON.stringify(requestData));
    return false;
}

function numbersFetched() {
    let response = JSON.parse(this.responseText);
    numbers = response.numbers.reverse();
    nextNumber();
}

function fetchFailed() {
    console.log("Fetch failed!");
}

function nextNumber() {
    if (numbers.length == 0) {
        $('#out-of-numbers').removeClass('hidden');
        $('#learning-prompt').addClass('hidden');
        return;
    }
    if (amountLearned && amountLearned % 10 == 0) {
        if ($('#keep-going-prompt').attr('class') == 'hidden') {
            $('#keep-going-prompt').removeClass('hidden');
            $('#learning-prompt').addClass('hidden');
            return;
        } else {
            $('#keep-going-prompt').addClass('hidden');
            $('#learning-prompt').removeClass('hidden');
        }
    }
    amountLearned++;
    $('#got-it').prop('disabled', true);
    currentNumber = numbers.pop();
    $('#term-english').html(currentNumber.number.toLocaleString('fr-FR'));
    $('#term-french').html(currentNumber.french);
    $('#you-try').attr('placeholder', currentNumber.french).val('').focus();
}

function fetchUnlearnedNumbers() {
    sendAJAXRequest('/numbers/fetch', {learned: false}, numbersFetched, fetchFailed);
}

function checkUserEnteredFrench() {
    let youTry = $("#you-try")
    let value = youTry.val();
    let placeholder = youTry.attr("placeholder");
    if (value == placeholder) {
        sendAJAXRequest('/numbers/update', {number: currentNumber.number, type: 'learned'}, nextNumber);
    }
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
    let youTry = $('#you-try');
    youTry.on('input', function() {
        let value = $(this).val();
        let placeholder = $(this).attr("placeholder");
        let disable = value != placeholder;
        $('#got-it').prop('disabled', disable);
    });
    $("#speak-button").click(speak);

    $('#you-try').keypress(function(e) {
        if (e.which == 13) {
            checkUserEnteredFrench();
        }
    });
    $('#got-it').click(checkUserEnteredFrench);
    fetchUnlearnedNumbers();
    $('#practice').click(function() { location.href = "/numbers/practice"; });
    $('#keep-going').click(nextNumber);
    $('#out-practice').click(function() { location.href = "/numbers/practice"; });
    $('#review').click(function() { 
        $('#out-of-numbers').addClass('hidden');
        $('#learning-prompt').removeClass('hidden');
        sendAJAXRequest('/numbers/fetch', {learned: true}, numbersFetched, fetchFailed);
    });
});