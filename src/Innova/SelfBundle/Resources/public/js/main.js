$(document).ready(function() {
    $('*').tooltip({placement:'top'});

    $('body').on('click', '.change-locale', function () {
        $("#locale-modale").modal('show');
    });

    $(".rest").restfulizer();

    $(document).on('click', 'body .dropdown-menu', function (e) {
        e.stopPropagation();
    });

    $(document).on('click', '#user-search-btn', function (e) {
        $("#user-search").submit();
    });
});