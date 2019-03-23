$(function () {
    $('input#search').quicksearch('.users-table tbody tr');

    $(".delete-trace").click(function (event) {
        if ($(this).attr("href") == "#") {
            event.preventDefault();
            $(this).attr('href', $(this).attr('realpath'));
            $(this).html(" Confimer !");
        }
    });

    let $unselectAll = $('#batch-actions .unselect-all');
    let $selectAll = $('#batch-actions .select-all');

    $unselectAll.on('click', function () {
        $('.user-selector input').attr('checked', false);

        $unselectAll.toggleClass('hidden', true);
        $selectAll.toggleClass('hidden', false);
    });

    $selectAll.on('click', function () {
        $('.user-selector input:enabled').click();

        $selectAll.toggleClass('hidden', true);
        $unselectAll.toggleClass('hidden', false);
    });
});
