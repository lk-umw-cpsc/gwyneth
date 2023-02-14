$(function() {
    let idsAndEndings = [
        [ '#je-cnd', 'ais'],
        [ '#tu-cnd', 'ais'],
        [ '#il-cnd', 'ait'],
        [ '#nous-cnd', 'ions'],
        [ '#vous-cnd', 'iez'],
        [ '#ils-cnd', 'aient'],

        [ '#je-ftr', 'ai'],
        [ '#tu-ftr', 'as'],
        [ '#il-ftr', 'a'],
        [ '#nous-ftr', 'ons'],
        [ '#vous-ftr', 'ez'],
        [ '#ils-ftr', 'ont']
    ];
    $('#conditional-future-stem').on("input", function() {
        let value = $(this).val();
        for (let pair in idsAndEndings) {
            $(pair[0]).html(value + pair[1]);
        }
    });
});