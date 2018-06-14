$(function() {
    sortableInit();
});

$( "body" ).on( "click", '.save-order', function() {
    $(this).attr("disabled", true);
    var componentId = $(this).attr("data-component-id");
    saveOrder(componentId);
});

$( "body" ).on( "click", '.check-level', function() {
    var testId = $(this).data("test-id");
    checkLevel(testId);
});

$( "body" ).on( "click", '.add-questionnaire', function() {
	$(this).attr("disabled", true);
	var componentId = $(this).data('component-id');
	var questionnaireId = $(this).attr("data-questionnaire-id");
	addQuestionnaire(componentId, questionnaireId);
});

$( "body" ).on( "click", '.duplicate-questionnaire', function() {
    $(this).attr("disabled", true);
    var componentId = $(this).data("component-id");
    var questionnaireId = $(this).attr("data-questionnaire-id");
    duplicateQuestionnaire(componentId, questionnaireId);
    
});

$( "body" ).on( "click", '.remove-alternative', function() {
    var testId = $(this).data("test-id");
    var componentId = $(this).data("component-id");
    var url = Routing.generate('editor_remove_component', { 'testId': testId, 'componentId': componentId  });
    $("#remove-component-confirm").attr("href", url);
    $('#delete-component-modal').modal('show');
});

$( "body" ).on( "click", '.remove-questionnaire', function() {
    $(this).attr("disabled", true);
    var orderQuestionnaireComponentId = $(this).data("order-questionnaire-id");
    $("#remove-questionnaire-confirm").data("order-questionnaire-component-id", orderQuestionnaireComponentId);
    $('#delete-order-questionnaire-component-modal').modal('show');
});

$( "body" ).on( "click", '#remove-questionnaire-confirm', function() {
    var orderQuestionnaireComponentId = $(this).data("order-questionnaire-component-id");
    removeQuestionnaire(orderQuestionnaireComponentId);
});

function getPotentials(componentId)
{
    $(".loader-img").show();
	$.ajax({
        url: Routing.generate('get-component-potentials', {'componentId': componentId }),
        type: 'GET'
    })
    .done(function(data) {
        $("#potential-tasks").html(data);
        // $('input#search').quicksearch('#tasks li', {
        //     delay: 500,
        //     loader: '.loader-img'
        // });
        $(".loader-img").hide();
    });
}

function addQuestionnaire(componentId, questionnaireId)
{
    $(".loader-img").show();
	$.ajax({
        url: Routing.generate('add-component-questionnaire', {'componentId': componentId, 'questionnaireId': questionnaireId }),
        type: 'POST'
    })
    .done(function(data) {
        $("#component-"+componentId+"-tasks").html(data);
        $(".loader-img").hide();
    });
}

function duplicateQuestionnaire(componentId, questionnaireId)
{
    $(".loader-img").show();
    $.ajax({
        url: Routing.generate('duplicate-component-questionnaire', {'componentId': componentId, 'questionnaireId': questionnaireId }),
        type: 'POST'
    })
    .done(function(data) {
        $("#component-"+componentId+"-tasks").html(data);
        $(".loader-img").hide();
    });
}

function removeQuestionnaire(orderQuestionnaireComponentId)
{
    $(".loader-img").show();
    $.ajax({
        url: Routing.generate('remove-component-questionnaire', {'orderQuestionnaireComponentId': orderQuestionnaireComponentId }),
        type: 'DELETE'
    })
    .done(function(data) {
        $("#order"+orderQuestionnaireComponentId).remove();
        $(".loader-img").hide();
        $('#delete-order-questionnaire-component-modal').modal('hide');
    });
}

function sortableInit()
{
    $( ".sortable" ).sortable();
    $( ".sortable" ).disableSelection();
    $( ".sortable" ).on( "sortupdate", function( event, ui ) {
        var componentId = $(this).data("component-id");
        $("#save-order-"+componentId).removeAttr('disabled');
    });
}

function saveOrder(componentId)
{
    $(".loader-img").show();
    var newOrder = new Array();
    $('#component-'+componentId+'-tasks .questionnaire').each(function() {
        newOrder.push($(this).data("order-id"));
    });
    newOrder = JSON.stringify(newOrder);

    $.ajax({
        url: Routing.generate('save-order-component-questionnaire', {'componentId': componentId }),
        type: 'PUT',
        data:{newOrder: newOrder}
    })
    .done(function(data) {
        $(".loader-img").hide();
    });
}

function checkLevel(testId)
{
    $(".loader-img").show();
    $.ajax({
        url: Routing.generate('phased-check-level', {'testId': testId }),
        type: 'GET'
    })
    .done(function(data) {
        console.log(data);
        jQuery.each(data, function(i, val) {
            $("li[data-questionnaire-id='"+i+"']").css("color","red");
        });
        $(".loader-img").hide();
    });
}
