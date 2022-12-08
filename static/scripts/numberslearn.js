$(function() {
    $('#you-try').change(function() {
        let value = $(this).val();
        let placeholder = $(this).attr("placeholder");
        let disable = value != placeholder;
        $('#got-it').prop('disabled', disable);
    });
});