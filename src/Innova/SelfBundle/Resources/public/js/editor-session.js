$( "body" ).on( "click", '.delete-session', function() {
    var sessionId = $(this).data("session-id");
    var url = Routing.generate('editor_test_delete_session', {sessionId: sessionId });
    $("#session-delete-confirmation").attr("href", url);
    $('#delete-session-modal').modal('show');
    $("#session-delete-confirmation").restfulizer();
});