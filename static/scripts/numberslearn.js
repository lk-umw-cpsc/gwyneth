let numbers;
let currentNumber;

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
        // TO-DO: let user know they're out of numbers to learn...
        return;
    }
    currentNumber = numbers.pop();
    $('#term-english').html(currentNumber.number);
    $('#term-english').html(currentNumber.french);
    $('#you-try').attr('placeholder', currentNumber.french);
}

function fetchUnlearnedNumbers() {
    sendAJAXRequest('/numbers/fetch', {'learned': false}, numbersFetched, );
}

function checkUserEnteredFrench() {
    let youTry = $("#you-try")
    let value = youTry.val();
    let placeholder = youTry.attr("placeholder");
    if (value == placeholder) {
        nextNumber();
    }
}

$(function() {
    let youTry = $('#you-try');
    youTry.on('input', function() {
        let value = $(this).val();
        let placeholder = $(this).attr("placeholder");
        let disable = value != placeholder;
        $('#got-it').prop('disabled', disable);
    });

    $('#you-try').keypress(function(e) {
        if (e.which == 13) {
            checkUserEnteredFrench();
        }
    });
    $('#got-it').click(checkUserEnteredFrench);
    fetchUnlearnedNumbers();
});