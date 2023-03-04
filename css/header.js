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

function time12hTo24h(time) {
    time = time.toLowerCase();
    let pattern = /^([1-9]|1[0-2]):([0-5][0-9]) ?([ap]m)$/i;
    let result = pattern.exec(time);
    if (result) {
        let hour = parseInt(result[1]);
        let minute = result[2];
        let part = result[3];
        if (hour == 12) {
            hour = 0;
        }
        if (part == 'pm') {
            hour += 12;
        }
        if (hour < 10) {
            return '0' + hour + ':' + minute;
        } else {
            return hour + ':' + minute;
        }
    }
    return null;
}

function validateTimeRange(start, end) {
    start = time12hTo24h(start);
    end = time12hTo24h(end);
    if (!start || !end) {
        return false;
    }
    return start < end;
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
    $('div.availability-day > p > input[type=checkbox]').each(function() {
        if ($(this).prop('checked')) {
            numberChecked++;
        }
    });
    $('div.availability-day > p > input[type=checkbox]').change(function() {
        let checked = $(this).prop('checked');
        let fields = $(this).parent().parent().children('input[type=text]');
        fields.prop('disabled', !checked);
        fields.prop('required', checked);
        let requiredAsterisks = $(this).parent().parent().find('p em');
        if (checked) {
            requiredAsterisks.removeClass('hidden');
        } else {
            requiredAsterisks.addClass('hidden');
        }
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
        const ele = $(this);
        ele.addClass('visited');
        ele.val(ele.val().trim());
        // let id = ele.attr('id');
        // if (id) {
        //     let label = $('label[for=' + id + ']');
        //     if (label) {
        //         if (ele[0].checkValidity()) {
        //             label.children('em').addClass('hidden');
        //         } else {
        //             label.children('em').removeClass('hidden');
        //         }
        //     }
        // }
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

    const weekdays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    $('form.signup-form').submit(function(event) {
        let errors = false;
        let passwordField = $('#password');
        if (passwordField.val() != $('#password-reenter').val()) {
            scrollIntoView(passwordField);
            passwordField.focus();
            $('#password-match-error').removeClass('hidden');
            errors = true;
        } else {
            $('#password-match-error').addClass('hidden');
        }

        for (const day of weekdays) {
            let checkbox = $('#available-' + day + 's');
            let start = $('#' + day + 's-start');
            let end = $('#' + day + 's-end');
            if (checkbox.prop('checked')) {
                if (!validateTimeRange(start.val(), end.val())) {
                    scrollIntoView(start);
                    start.focus();
                    $('#' + day + 's-range-error').removeClass('hidden');
                    errors = true;
                } else {
                    $('#' + day + 's-range-error').addClass('hidden');
                }
            } else {
                $('#' + day + 's-range-error').addClass('hidden');
            }
        }
        if (errors) {
            event.preventDefault();
        }
    });
});