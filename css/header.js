function scrollIntoView(element) {
    if (element instanceof jQuery) {
        element = element[0];
    }
    element.scrollIntoView({
        behavior: 'auto',
        block: 'center',
        inline: 'center'
    });
}

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

    $('.signup-form #email').change(function() {
        $('#email-dupe').html($(this).val());
    });

    $('#email-dupe').click(function() {
        let element = $('.signup-form #email');
        scrollIntoView(element);
        element.focus();
    });

    // Show password match error if passwords don't match
    // as user clicks out of the password re-enter input
    $('#password-reenter').change(function() {
        if ($(this).val() == $('#password').val()) {
            $('#password-match-error').addClass('hidden');
        } else {
            $('#password-match-error').removeClass('hidden');
        }
    });

    // Format phone number inputs to (XXX) XXX-XXXX format
    $('input[type=tel]').blur(function() {
        let raw = $(this).val();
        let numbers = '';
        for (let i = 0; i < raw.length; i++) {
            let c = raw.charAt(i);
            if (c >= '0' && c <= '9') {
                numbers += c;
            }
        }
        if (numbers.length == 10) {
            let formattedPhoneNumber = '(' + numbers.slice(0, 3) + ') ' + numbers.slice(3, 6) + '-' + numbers.slice(6);
            $(this).val(formattedPhoneNumber);
        }
    });
});