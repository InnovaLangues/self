$(document).ready(function() {
    $('*').tooltip({placement:'top'});

    $('body').on('click', '.change-locale', function () {
        $("#locale-modale").modal('show');
    });

    $(".rest").restfulizer();
});