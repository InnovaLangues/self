$(function() {
    $('input#search').quicksearch('#sessions-table tbody tr');
        $('#datetimepicker6, #datetimepicker7').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});

        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });

});

$( "body" ).on( "click", '.delete-session', function() {
    var sessionId = $(this).data("session-id");
    var url = Routing.generate('editor_test_delete_session', {sessionId: sessionId });
    $("#session-delete-confirmation").attr("href", url);
    $('#delete-session-modal').modal('show');
    $("#session-delete-confirmation").restfulizer();
});

$( "body" ).on( "click", '.export-session-by-date', function() {
    var sessionId = $(this).data("session-id");
    var url = Routing.generate('editor_session_export_results_dates', {sessionId: sessionId });
    $("#export-session-by-dates").attr("action", url);
    $('#export-session-modal').modal('show');
});


