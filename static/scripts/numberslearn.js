$(function() {
    $('#you-try').change(function() {
        let value = $(this).val();
        let placeholder = $(this).attr("placeholder");
        let goodToGo = value == placeholder;
        $('#got-it').prop('disabled', goodToGo);
    });
});