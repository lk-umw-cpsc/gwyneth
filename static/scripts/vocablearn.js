const LEARNING_CUTOFF = 7;

let terms;
let currentTerm;

let amountLearned = 0;

let categoryID;

let currentSound;

function sendAJAXRequest(url, requestData, onSuccess, onFailure) {
    var request = new XMLHttpRequest();
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onload = onSuccess;
    request.onerror = onFailure;
    request.send(JSON.stringify(requestData));
    return false;
}

function termsFetched() {
    let response = JSON.parse(this.responseText);
    terms = response.terms.reverse();
    nextTerm();
}

function fetchFailed() {
    console.log("Fetch failed!");
}

function nextTerm() {
    if (terms.length == 0) {
        $('#out-of-numbers').removeClass('hidden');
        $('#learning-prompt').addClass('hidden');
        return;
    }
    if (amountLearned == LEARNING_CUTOFF) {
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
    currentTerm = terms.pop();
    $('#term-english').html(currentTerm.english);
    $('#term-french').html(currentTerm.french);
    $('#you-try').attr('placeholder', currentTerm.french).val('').focus();
    console.log(currentTerm.gender);
    if (currentTerm.gender === 'm') {
        $('#term-english').addClass('masculine');
        $('#term-french').addClass('masculine');
        $('#term-english').removeClass('feminine');
        $('#term-french').removeClass('feminine');
    } else if (currentTerm.gender === 'f') {
        $('#term-english').removeClass('masculine');
        $('#term-french').removeClass('masculine');
        $('#term-english').addClass('feminine');
        $('#term-french').addClass('feminine');
    } else {
        $('#term-english').removeClass('masculine');
        $('#term-french').removeClass('masculine');
        $('#term-english').removeClass('feminine');
        $('#term-french').removeClass('feminine');
    }
}

function speak() {
    if (!currentTerm.speech) {
        currentTerm.speech = new Audio(generateSoundURL());
    }
    currentTerm.speech.play();
}

function generateSoundURL() {
    return '/vocab/term/' + currentTerm.id + '/speech';
}

function fetchUnlearnedTerms() {
    // ??? send category
    sendAJAXRequest('/vocab/' + categoryID + '/fetch', {learned: false}, termsFetched, fetchFailed);
}

function checkUserEnteredFrench() {
    let youTry = $("#you-try")
    let value = youTry.val().toLowerCase().trim().replaceAll('\u2018', "'").replaceAll('\u2019', "'");
    let placeholder = youTry.attr("placeholder");
    if (value == placeholder) {
        sendAJAXRequest('/vocab/update', { term: currentTerm.id, type: 'learned' }, nextTerm);
    }
}

$(function() {
    categoryID = $('#category-id').val();
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

    $('#you-try').blur(function() {
        setTimeout(function(){ $('#you-try').focus() }, 20);
    });
    $('#got-it').click(checkUserEnteredFrench);
    fetchUnlearnedTerms();
    // ... category id?
    $('#practice').click(function() { location.href = "/vocab/" + categoryID + "/practice"; });
    $('#keep-going').click(nextTerm);
    $('#out-practice').click(function() { location.href = "/vocab/" + categoryID + "/practice"; });
    $('#review').click(function() { 
        $('#out-of-numbers').addClass('hidden');
        $('#learning-prompt').removeClass('hidden');
        sendAJAXRequest('/vocab/' + categoryID + '/fetch', {learned: true}, termsFetched, fetchFailed);
    });
});