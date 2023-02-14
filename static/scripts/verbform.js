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
    console.log(1);

    $('#conditional-future-stem').on("input", function() {
        let value = $(this).val();
        console.log(2);
        for (let pair in idsAndEndings) {
            console.log(pair[0] + ' ' + pair[1]);
            $(pair[0]).html(value + pair[1]);
        }
    });
});