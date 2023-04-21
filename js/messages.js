$(function() {
    $('tr.message').click(function() {
        let id = $(this).data('message-id');
        console.log(id);
        window.location = 'viewNotification.php?id=' + id;
    });
});