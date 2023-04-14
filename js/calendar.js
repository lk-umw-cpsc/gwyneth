$(function() {

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


    $('#calendar-heading-month').click(function() {
        $('#month-jumper-wrapper').removeClass('hidden');
    });

    $('#month-jumper').submit(function() {
        let month = $('#jumper-month').val();
        let year = $('#jumper-year').val();
        $('#jumper-value').val(year + '-' + month);
    });

    $('#jumper-cancel').click(function() {
        $('#month-jumper-wrapper').addClass('hidden');
    });

    $('#month-jumper-wrapper').click(function(e) {
        if (e.target === this) {
            $('#month-jumper-wrapper').addClass('hidden');
        }
    });
});