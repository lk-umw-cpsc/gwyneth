function sendDelete(id) {
    sendAJAXRequest('deleteNotification.php?id=' + id, { }, deleteCallback);
}

function deleteCallback() {
    let response = JSON.parse(this.responseText);
    if (response.result) {
        window.location = 'inbox.php?deleteSuccess';
    }
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
    $('tr.message').click(function() {
        let id = $(this).data('message-id');
        window.location = 'viewNotification.php?id=' + id;
    });

    $('#delete-button').click(function() {
        let id = $(this).data('message-id');
        sendDelete(id);
    });
});