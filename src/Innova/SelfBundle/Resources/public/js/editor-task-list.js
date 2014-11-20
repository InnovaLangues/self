$(function() {
    sortableInit();
    $('input#search').quicksearch('#tasks li');
    $('input#search').quicksearch('#tasks-table tbody tr');
});

$( "body" ).on( "click", '.delete-task', function() {
    $("#questionnaire-id").val($(this).data("questionnaire-id"));
    $('#delete-task-modal').modal('show');
});

$( "body" ).on( "click", '.delete-task-list', function() {
    $("#questionnaire-id").val($(this).data("questionnaire-id"));
    $('#delete-task-modal').modal('show');
});

$( "body" ).on( "click", '#save-order', function() {
    saveOrder();
});

$( "body" ).on( "click", '.add-task', function() {
    $(this).attr("disabled", true);
    var testId = $(this).data("testId");
    var questionnaireId = $(this).data("questionnaireId");
    addTaskToTest(questionnaireId, testId);
});

$( "body" ).on( "click", '#delete-task-confirmation', function() {
    deleteTask();
});

$( "body" ).on( "click", '#delete-task-list-confirmation', function() {
    deleteTaskList();
});

$( "body" ).on( "click", '#refresh-potentials', function() {
    var testId = $(this).data("testId");
    refreshPotentials(testId);
});

$( "body" ).on( "click", '#create-task', function() {
    var testId = $(this).data("testId");
    createTask(testId);
});

function refreshPotentials(testId){
    $("#refresh-potentials").attr('disabled', true);
    $.ajax({
        url: Routing.generate('editor_test_questionnaires_potentials', {'testId': testId }),
        type: 'GET'
    })
    .done(function(data) {
        $("#refresh-potentials").removeAttr('disabled');
        $("#potential-questionnaires").html(data);
    });
}

function sortableInit(){
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        $("#save-order").removeAttr('disabled');
    });
}

function addTaskToTest(questionnaireId, testId){
    $("#loader-img").show();
    $.ajax({
        url: Routing.generate('editor_add_task_to_test'),
        type: 'PUT',
        data:
        {
            testId: testId,
            questionnaireId: questionnaireId
        }
    })
    .done(function(data) {
        $("#sortable").html(data);
        sortableInit();
        $("#loader-img").hide();
    });
}

function saveOrder(){
    $("#save-order").attr('disabled', true);
    $("#loader-img").show();
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
        $("#loader-img").hide();
    });
}

function deleteTask(){
    var testId = $("#test-id").val();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('delete-task'),
        type: 'POST',
        dataType: 'json',
        data:
        {
            testId: testId,
            questionnaireId: questionnaireId
        }
    })
    .done(function(data) {
        console.log("Tâche supprimée");
        $("#task-"+questionnaireId).remove();
        $('#delete-task-modal').modal('hide');
    });
}

function deleteTaskList(){
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('delete-task-list'),
        type: 'DELETE',
        dataType: 'json',
        data:
        {
            questionnaireId: questionnaireId
        }
    })
    .done(function(data) {
        console.log("Tâche supprimée");
        $("#task-"+questionnaireId).remove();
        $('#delete-task-modal').modal('hide');
    });
}

function createTask(testId){
    $.ajax({
        url: Routing.generate('editor_questionnaire_create'),
        type: 'POST',
        dataType: 'json',
        data: {
            testId : testId
        }
    })
    .done(function(data) {
        window.location = Routing.generate('editor_questionnaire_show', {'questionnaireId': data.questionnaireId, 'testId' : data.testId });
    });
}
