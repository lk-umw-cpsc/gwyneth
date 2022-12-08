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
}

function nextNumber() {
    if (numbers.length == 0) {
        // TO-DO: let user know they're out of numbers to learn...
        return;
    }
    currentNumber = numbers.pop();
    $('#term-english').html(number.number);
    $('#term-english').html(number.french);
    $('#you-try').attr('placeholder', number.french);
}

function fetchUnlearnedNumbers() {
    sendAJAXRequest('/numbers/fetch', {'learned': false}, );
}

$(function() {
    $('#you-try').on('input', function() {
        let value = $(this).val();
        let placeholder = $(this).attr("placeholder");
        let disable = value != placeholder;
        $('#got-it').prop('disabled', disable);
    });

    $('#you-try').click(function() {
        nextNumber();
    });

    fetchUnlearnedNumbers();
});