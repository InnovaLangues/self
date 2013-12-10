$(document).ready(function() {

    $("html").addClass("fuelux");
     /***
    TO FUEL UX in registration form.
    ****/
    $('.btn-wizard-prev').on('click', function() {
            $('#register-wizard').wizard('previous');
    });
    $('.btn-wizard-next').on('click', function() {
            $('#register-wizard').wizard('next','foo');
    });
});