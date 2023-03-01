$(function() {
    $('#menu-toggle').click(function() {
        let element = $('nav > ul');
        if (element.css('display') == 'none') {
            element.css('display', 'flex');
        } else {
            element.css('display', 'none');
        }
    });

    $('.other-month').click(function() {
        document.location = 'calendar.php?month=' + $(this).data('month');
    });

    $('#previous-month-button, #next-month-button').click(function() {
        document.location = 'calendar.php?month=' + $(this).data('month');
    });

    $('.dashboard-item').click(function() {
        let link = $(this).data('link');
        if (link) {
            document.location = link;
        }
    });
});