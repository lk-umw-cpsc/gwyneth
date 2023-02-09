$(function() {
    $('#french').blur(function() {
        let val = $(this).val().toLowerCase();
        if (val.startsWith('un ') || val.startsWith('le ')) {
            $('#gender-masculine').attr('checked', true);
        } else if (val.startsWith('une ') || val.startsWith('la ')) {
            $('#gender-feminine').attr('checked', true);
        }
    });
});