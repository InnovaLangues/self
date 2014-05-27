$(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
});

$( "body" ).on( "click", '#save-order', function() {
    var newOrder = new Array();
    var testId = "";
    $('.questionnaire').each(function() {
        testId = $(this).data("test-id");
        newOrder.push($(this).data("questionnaire-id"));
    });
    newOrder = JSON.stringify(newOrder);

    $.ajax({
        url: Routing.generate('save-order-test-questionnaire'),
        type: 'POST',
        dataType: 'json',
        data: 
        { 
            testId: testId,
            newOrder: newOrder
        }
    })
    .done(function(data) {
        alert("ordre sauvegardé")
    });
});