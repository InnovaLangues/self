$(document).ready(function() {
    $('body *[data-toggle="tooltip"]').tooltip({placement:'top'});

    $('body').on('click', '.change-locale', function () {
        $("#locale-modale").modal('show');
    });

    $('body').on('click', '.locale-select', function () {
        $.ajax(Routing.generate('locale_change', {'_locale': $(this).html().toLowerCase()}))
        .done(function () {
            window.location.reload();
        });
    });

    $(".rest").restfulizer();

    $(document).on('click', 'body .dropdown-menu', function (e) {
        e.stopPropagation();
    });

    $(document).on('click', '#user-search-btn', function (e) {
        $("#user-search").submit();
    });

    $('.datepicker').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('.datepicker_date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});
