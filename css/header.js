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

    let numberChecked = 0;
    $('div.availability-day > p > input[type=checkbox]').change(function() {
        let checked = $(this).prop('checked');
        let fields = $(this).parent().parent().children('input[type=text]');
        fields.prop('disabled', !checked);
        fields.prop('required', checked);
        if (checked) {
            numberChecked++;
        } else {
            numberChecked--;
        }
        // Force user to choose at least one day with availability
        let noDaysChecked = numberChecked == 0;
        $('div.availability-day > p > input[type=checkbox]').prop('required', noDaysChecked);
    });

    $('input').blur(function() {
        $(this).addClass('visited');
    });
});