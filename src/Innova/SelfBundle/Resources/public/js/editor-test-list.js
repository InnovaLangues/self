$( "body" ).on( "click", '.toggle-favorite', function() {
    var btn = $(this);
    var testId = btn.data("test-id");

    $.ajax({
        url: Routing.generate('test_favorite_toggle', {testId: testId }),
        type: 'GET'
    })
    .complete(function() {
        window.location.reload();
    });
});