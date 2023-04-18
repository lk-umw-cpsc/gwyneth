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

/*
    Adapted from https://stackoverflow.com/a/43467144
*/
function isValidURL(string) {
    let url;
    try {
      url = new URL(string);
    } catch (_) {
      return false;
    }
    return true;
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
    // start = time12hTo24h(start);
    // end = time12hTo24h(end);
    if (!start || !end) {
        return false;
    }
    return start < end;
}

function validate12hTimeRange(start, end) {
    start = time12hTo24h(start);
    end = time12hTo24h(end);
    if (!start || !end) {
        return false;
    }
    return start < end;
}

function validateDateRange(start, end) {
    return start <= end;
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
        let fields = $(this).parent().parent().children('select');
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
        // $('div.availability-day > p > select').prop('required', noDaysChecked);
        $('div.availability-day > p > input[type=checkbox]').prop('required', noDaysChecked);
    });

    $('input:not([type=password])').blur(function() {
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
    $('form#new-event-form').submit(function(e) {
        let start = $('#start-time').val();
        let end = $('#end-time').val();
        if (!validate12hTimeRange(start, end)) {
            scrollIntoView($('#start-time'));
            $('#date-range-error').removeClass('hidden');
            e.preventDefault();
        } else {
            $('#date-range-error').addClass('hidden');
        }
    });

    /* date.php */
    $('table.event th').click(function() {
        let id = $(this).data('event-id');
        if (id) {
            document.location = 'event.php?id=' + id;
        }
    });

    /* eventSearch.php */
    $('#date-start, #date-end').change(function(){
        let start = $('#date-start').val();
        let end = $('#date-end').val();
        if (!start || !end) {
            return;
        }
        if (!validateDateRange(start, end)) {
            $('#date-range-error').removeClass('hidden');
        } else {
            $('#date-range-error').addClass('hidden');
        }
    });

    $('#event-date-range-search').submit(function(e) {
        let start = $('#date-start').val();
        let end = $('#date-end').val();
        if (!start || !end) {
            return;
        }
        if (!validateDateRange(start, end)) {
            $('#date-range-error').removeClass('hidden');
            e.preventDefault();
        } else {
            $('#date-range-error').addClass('hidden');
        }
    });

    /* changePassword.php */
    $('form#password-change').submit(function(e) {
        let passwordField = $('#new-password');
        if (passwordField.val() != $('#new-password-reenter').val()) {
            scrollIntoView(passwordField);
            passwordField.focus();
            $('#password-match-error').removeClass('hidden');
            e.preventDefault();
        } else {
            $('#password-match-error').addClass('hidden');
        }
    });
    $('#new-password-reenter').change(function() {
        if ($(this).val() == $('#new-password').val()) {
            $('#password-match-error').addClass('hidden');
        } else {
            $('#password-match-error').removeClass('hidden');
        }
    });
    
    // Edit Photo link
    $('#edit-profile-picture').click(function() {
        let form = $('#edit-profile-picture-form');
        if (form.hasClass('hidden')) {
            form.removeClass('hidden');
            $(this).addClass('edit-profile-picture-clicked');
            $(this).removeClass('edit-profile-picture-unclicked');
            $(this).html('Cancel');
        } else {
            $(this).html('Edit Photo');
            $(this).addClass('edit-profile-picture-unclicked');
            $(this).removeClass('edit-profile-picture-clicked');
            form.addClass('hidden');
        }
    });
    
    // Submit profile image link
    $('#edit-profile-picture-form').submit(function(e) {
        if (!isValidURL($('#url').val())) {
            e.preventDefault();
            $('#url-error').removeClass('hidden');
            $('#url').focus();
        }
    });

	
	// Event training media
    $('#attach-training-media').click(function() {
        let form = $('#attach-training-media-form');
        if (form.hasClass('hidden')) {
            form.removeClass('hidden');
            $(this).html('Cancel');
        } else {
            $(this).html('Attach Event Training Media');
            form.addClass('hidden');
        }
    });
    // Post-event media
    $('#attach-post-media').click(function() {
        let form = $('#attach-post-media-form');
        if (form.hasClass('hidden')) {
            form.removeClass('hidden');
            $(this).html('Cancel');
        } else {
            $(this).html('Attach Post-Event Media');
            form.addClass('hidden');
        }
    });
    $('#url').blur(function() {
        let val = $(this).val();
        if (isValidURL(val)) {
            $('#url-error').addClass('hidden');
            return;
        }
        val = 'https://' + val;
        if (isValidURL(val)) {
            $(this).val(val);
            $('#url-error').addClass('hidden');
            return;
        }
        $('#url-error').removeClass('hidden');
    });
    $('#post-url').blur(function() {
        let val = $(this).val();
        if (isValidURL(val)) {
            $('#post-url-error').addClass('hidden');
            return;
        }
        val = 'https://' + val;
        if (isValidURL(val)) {
            $(this).val(val);
            $('#post-url-error').addClass('hidden');
            return;
        }
        $('#post-url-error').removeClass('hidden');
    });
    $('#attach-training-media-form').submit(function(e) {
        if (!isValidURL($('#url').val())) {
            e.preventDefault();
            $('#url-error').removeClass('hidden');
            $('#url').focus();
        }
    });
    $('#attach-post-media-form').submit(function(e) {
        if (!isValidURL($('#post-url').val())) {
            e.preventDefault();
            $('#post-url').focus();
        }
    });
    

    // Person search
    $('form#person-search').submit(function(e) {
        let name = $('#name').val().trim();
        let id = $('#id').val().trim();
        let phone = $('#phone').val().trim();
		let zip = $('#zip').val().trim();
        let role = $('#role').val().trim();
        let status = $('#status').val().trim();
        if (!(name || id || phone || zip || role || status)) {
            $('#criteria-error').removeClass('hidden');
            e.preventDefault();
        }
    });
});
