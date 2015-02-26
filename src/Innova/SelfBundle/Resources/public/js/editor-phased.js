$( "body" ).on( "click", '.get-potentials', function() {
	var componentId = $(this).attr("data-component-id");
    $("#potential-tasks").html("");
	$('#potential-tasks-modal').data("component-id", componentId);
    $('#potential-tasks-modal').modal('show');
    getPotentials(componentId);
});


$( "body" ).on( "click", '.add-questionnaire', function() {
	$(this).attr("disabled", true);
	var componentId = $('#potential-tasks-modal').data('component-id');
	var questionnaireId = $(this).attr("data-questionnaire-id");
	addQuestionnaire(componentId, questionnaireId);
	
});

$( "body" ).on( "click", '.duplicate-questionnaire', function() {
    $(this).attr("disabled", true);
    var componentId = $('#potential-tasks-modal').data('component-id');
    var questionnaireId = $(this).attr("data-questionnaire-id");
    duplicateQuestionnaire(componentId, questionnaireId);
    
});

$( "body" ).on( "click", '.remove-questionnaire', function() {
    $(this).attr("disabled", true);
    var orderQuestionnaireComponentId = $(this).data("order-questionnaire-id");
    removeQuestionnaire(orderQuestionnaireComponentId);
});


function getPotentials(componentId)
{
	$.ajax({
        url: Routing.generate('get-component-potentials', {'componentId': componentId }),
        type: 'POST'
    })
    .done(function(data) {
        $("#potential-tasks").html(data);
    });
}

function addQuestionnaire(componentId, questionnaireId)
{
	$.ajax({
        url: Routing.generate('add-component-questionnaire', {'componentId': componentId, 'questionnaireId': questionnaireId }),
        type: 'POST'
    })
    .done(function(data) {
        $("#component-"+componentId+"-tasks").html(data);
    });
}

function duplicateQuestionnaire(componentId, questionnaireId)
{
    $.ajax({
        url: Routing.generate('duplicate-component-questionnaire', {'componentId': componentId, 'questionnaireId': questionnaireId }),
        type: 'POST'
    })
    .done(function(data) {
        $("#component-"+componentId+"-tasks").html(data);
    });
}

function removeQuestionnaire(orderQuestionnaireComponentId)
{
    $.ajax({
        url: Routing.generate('remove-component-questionnaire', {'orderQuestionnaireComponentId': orderQuestionnaireComponentId }),
        type: 'POST'
    })
    .done(function(data) {
        $("#order"+orderQuestionnaireComponentId).remove();
    });
}


