$(function() {
    $('input#search').quicksearch('#sessions-table tbody tr');

    $('#datetimepickerStart, #datetimepickerEnd').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});

    $("#datetimepickerStart").on("dp.change", function (e) {
        $('#datetimepickerEnd').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerEnd").on("dp.change", function (e) {
        $('#datetimepickerStart').data("DateTimePicker").maxDate(e.date);
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
    $('#export-session-dates-modal').modal('show');
});

$( "body" ).on( "click", '.export-btn', function() {
    var url = $(this).data("url");
    $("#export-session-by-dates").attr("action", url);
    $('#export-session-dates-modal').modal('show');
});
