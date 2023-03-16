$(function() {
    // Show date picker menu when user clicks on calendar heading
    $("#calendar-heading-month").click(function(e) {
        $('#month-jumper').css('left', e.pageX);
        $('#month-jumper').css('top', e.pageY);
        $('#month-jumper').focus();
        $('#month-jumper')[0].showPicker();
    });

    // Change to selected date when user chooses a new month
    // let startingMonth = $('#month-jumper').val();
    // startingMonth = startingMonth.substring(0, startingMonth.length - 3);
    $('#month-jumper').change(function() {
        let value = $(this).val();
        value = value.substring(0, value.length - 3);
        if (value != startingMonth) {
            document.location = 'calendar.php?month=' + value;
        }
    });
    $('.calendar-day:not(.other-month)').click(function() {
        document.location = 'date.php?date=' + $(this).data('date');
    });
});