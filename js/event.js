
function hideDeleteConfirmation(e) {
    if (e.target === this) {
        $('#delete-confirmation-wrapper').addClass('hidden');
    }
}

$(function() {
    $('#delete-cancel').click(hideDeleteConfirmation);
    $('#delete-confirmation-wrapper').click(hideDeleteConfirmation);
});

function showDeleteConfirmation() {
    $('#delete-confirmation-wrapper').removeClass('hidden');
}