$(document).ready(function() {
    var questionnaireId = $("#questionnaire-id").val();

    /* GENERAL INFOS EVENTS */
    $('#theme').on('blur',function(e){
        setTheme(questionnaireId);
    });

    $('#skill').on('change',function(e){
        setSkill(questionnaireId);
    });

    $('#level').on('change',function(e){
        setLevel(questionnaireId);
    });

    $('#typology').on('change',function(e){
        setTypology(questionnaireId);
    });

    $('#fixed-order').on('change',function(e){
        isChecked = $('#fixed-order').prop('checked');
        setFixedOrder(isChecked);
    });

    /**********************
        QUESTIONNAIRE RELATED EVENTS 
    ************************/

    $( "body" ).on( "click", '#add-context', function() {
        setParamForRequest("questionnaire", "contexte", questionnaireId, "contexte-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '#add-text', function() {
        setParamForRequest("questionnaire", "texte", questionnaireId, "texte-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '#delete-context', function() {
        setParamForRequest("questionnaire", "contexte", questionnaireId, "contexte-container");
        unlinkMedia();
    });

    $( "body" ).on( "click", '#delete-text', function() {
        setParamForRequest("questionnaire", "texte", questionnaireId, "texte-container");
        unlinkMedia();
    });


    /**********************
        QUESTION RELATED EVENTS 
    ************************/

    $( "body" ).on( "click", '#create-subquestion', function() {
        createSubquestion(questionnaireId);
    });

    $( "body" ).on( "click", '.delete-subquestion', function() {
        var subquestionId = $(this).data("subquestion-id");
        deleteSubquestion(questionnaireId, subquestionId);
    });


    $( "body" ).on( "click", '.add-amorce', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("subquestion", "amorce", subquestionId, "subquestion-"+subquestionId+"-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '.delete-amorce', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("subquestion", "amorce", subquestionId, "subquestion-"+subquestionId+"-container");
        unlinkMedia();
    });

    /**********************
        PROPOSITION RELATED EVENTS 
    ************************/

    $( "body" ).on( "click", '#create-proposition', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("proposition", null, subquestionId, "subquestion-"+subquestionId+"-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '.delete-proposition', function() {
        var propositionId = $(this).data("proposition-id");
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("proposition", null, propositionId, "proposition-"+propositionId+"-container");
        unlinkMedia();
    });

    $( "body" ).on( "click", '.make-it-right-or-wrong', function() {
        var propositionId = $(this).data("proposition-id");
        toggleRightWrong(propositionId);
    });

    /**********************
        MEDIA RELATED EVENTS 
     ************************/

    $( "body" ).on( "click", '.media-type-choice', function() {
        createMediaModal( $(this) );
    });

    $( "body" ).on( "click", '#create-text-btn', function() {
        createText();
        $("*").modal('hide');
    });

    $( "body" ).on( "click", '#create-image-btn', function() {
        createImage();
        $("*").modal('hide');
    });

    $( "body" ).on( "click", '#create-video-btn', function() {
        createVideo();
        $("*").modal('hide');
    });

    $( "body" ).on( "click", '#create-audio-btn', function() {
        createAudio();
        $("*").modal('hide');
    });

    $( "body" ).on( "change", '.media-listening-limit', function() {
        var mediaId = $(this).data("media-id");
        var listeningLimit = $(this).val();
        setListeningLimit(mediaId, listeningLimit);
    });

    /**********************
        APPARIEMMENT RELATED EVENTS 
     ************************/

    $( "body" ).on( "click", '.app-add-subquestion', function() {
        createSubquestion(questionnaireId);
    });

    $( "body" ).on( "click", '.app-add-media', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("subquestion", "media", subquestionId, "subquestion-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '.app-add-answer', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("proposition", "app-answer", subquestionId, "subquestion-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '.app-add-distractor', function() {
        setParamForRequest("proposition", "app-distractor", questionnaireId, "subquestion-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '.app-delete-subquestion', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("subquestion", "app", subquestionId, "subquestion-container");
        unlinkMedia();
    });

    $( "body" ).on( "click", '.app-delete-distractor', function() {
        var propositionId = $(this).data("proposition-id");
        setParamForRequest("proposition", "app-distractor", propositionId, "subquestion-container");
        unlinkMedia();
    });

});

/************************************************
*************************************************

                    MODALE

*************************************************
**************************************************/
function chooseMediaTypeModal() {
    $('#modal-media-type').modal('show');
}

function createMediaModal( media ) {
    $('#modal-media-type').modal('hide');
    var mediaType = media.attr("media-type");
    $('#modal-create-'+mediaType).modal('show');
    // initTinyMCE();
}


/************************************************
*************************************************

                    CREATE MEDIA

*************************************************
**************************************************/

function createText(){
    var description = $("#create-text-textarea").val();
    createMedia(null, description, null, "texte");
}

function createImage(){
    var url = $("#image-url").val();
    var name = $("#image-name").val();
    var description = $("#image-description").val();
    createMedia(name, description, url, "image");
}

function createVideo(){
    var url = $("#video-url").val();
    var name = $("#video-name").val();
    var description = $("#video-description").val();
    createMedia(name, description, url, "video");
}

function createAudio(){
    var url = $("#audio-url").val();
    var name = $("#audio-name").val();
    var description = $("#audio-description").val();
    createMedia(name, description, url, "audio");
}


/************************************************
*************************************************

                    AJAX

*************************************************
**************************************************/

function createMedia(name, description, url, type) {
    $("#loader-img").show();

    var testId = $("#test-id").val();
    var questionnaireId = $("#questionnaire-id").val();

    var entityField = $("#entity-field").val();
    var entityId = $("#entity-id").val();
    var entityType = $("#entity-type").val();
    var toBeReloaded = $("#entity-to-be-reloaded").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-media'),
        type: 'POST',
        data: 
        { 
            testId: testId,
            questionnaireId: questionnaireId,
            name: name,
            description: description,
            url: url,
            type: type,
            entityType: entityType,
            entityId: entityId,
            entityField: entityField
        }
    })
    .done(function(data) {
        $("#"+toBeReloaded).replaceWith(data);
        initializeFormsFields();
        $("#loader-img").hide();
        $('*').tooltip({placement:'top'});
    });
}


function setTheme(questionnaireId) {
    $("#loader-img").show();

    $.ajax({
        url: Routing.generate('editor_questionnaire_set-theme'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            theme: $("#theme").val() 
        }
    })
    .done(function(data) {
        $("#loader-img").hide();
    }); 
}

function setSkill(questionnaireId) {
    $("#loader-img").show();
    $.ajax({
        url: Routing.generate('editor_questionnaire_set-skill'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            skill: $("#skill").val() 
        }
    })
    .done(function(data) {
        $("#loader-img").hide();
    }); 
}

function setTypology(questionnaireId) {
    $("#loader-img").show();
    var testId = $("#test-id").val();
    $.ajax({
        url: Routing.generate('editor_questionnaire_set-typology'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            testId: testId,
            typology: $("#typology").val() 
        }
    })
    .done(function(data) {
        $("#typology").val(data.typology);
        $("#subquestion-container").replaceWith(data.subquestions);
        $("#loader-img").hide();
    }); 
}

function setFixedOrder(isChecked){
    $("#loader-img").show();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_set-fixed-order'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            isChecked: isChecked 
        }
    })
    .done(function(data) {
        $("#loader-img").hide();
    }); 

}

function setLevel(questionnaireId) {
    $("#loader-img").show();

    $.ajax({
        url: Routing.generate('editor_questionnaire_set-level'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            level: $("#level").val() 
        }
    })
    .done(function(data) {
        $("#loader-img").hide();
    }); 
}

function unlinkMedia(){
    $("#loader-img").show();

    var testId = $("#test-id").val();
    var questionnaireId = $("#questionnaire-id").val();

    var entityField = $("#entity-field").val();
    var entityId = $("#entity-id").val();
    var entityType = $("#entity-type").val();
    var toBeReloaded = $("#entity-to-be-reloaded").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_unlink-media'),
        type: 'POST',
        data: 
        {
            testId: testId,
            questionnaireId: questionnaireId, 
            entityType: entityType,
            entityId: entityId,
            entityField: entityField
        }
    })
    .done(function(data) {
        $("#"+toBeReloaded).replaceWith(data);
        initializeFormsFields();
        $("#loader-img").hide();
        $('*').tooltip({placement:'top'});
    });
}


function createSubquestion(questionnaireId) {
    $("#loader-img").show();

    var testId = $("#test-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-subquestion'),
        type: 'POST',
        dataType: 'json',
        data: { 
            testId: testId,
            questionnaireId: questionnaireId,
            questionnaireTypology: $("#typology").val()
        }
    })
    .complete(function(data) {
        $("#loader-img").hide();
        $("#subquestion-container").replaceWith(data.responseText);
    }); 
}

function deleteSubquestion(questionnaireId, subquestionId){
    $("#loader-img").show();

    var testId = $("#test-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_delete_subquestion'),
        type: 'POST',
        dataType: 'json',
        data: { 
            testId: testId,
            questionnaireId: questionnaireId,
            subquestionId: subquestionId,
        }
    })
    .complete(function(data) {
        $("#loader-img").hide();
        $("#subquestion-container").replaceWith(data.responseText);
    });
}

function toggleRightWrong(propositionId){
    $("#loader-img").show();

    var testId = $("#test-id").val();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_toggle_right_anwser'),
        type: 'POST',
        data: { 
            testId: testId,
            questionnaireId: questionnaireId,
            propositionId: propositionId,
        }
    })
    .done(function(data) {
        $("#loader-img").hide();
        $("#proposition-"+propositionId+"-container").replaceWith(data);
        $('*').tooltip({placement:'top'});
    }); 
}


function setListeningLimit(mediaId, listeningLimit){
    $("#loader-img").show();

    var testId = $("#test-id").val();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('set-listening-limit'),
        type: 'POST',
        data: { 
            testId: testId,
            questionnaireId: questionnaireId,
            mediaId: mediaId,
            listeningLimit: listeningLimit
        }
    })
    .done(function(data) {
        $("#loader-img").hide();
    });
}

/************************************************
*************************************************

                    MISC

*************************************************
**************************************************/

function setParamForRequest(type, field, id, reloaded){
    $("#entity-field").val(field);
    $("#entity-id").val(id);
    $("#entity-type").val(type);
    $("#entity-to-be-reloaded").val(reloaded);
}


function initializeFormsFields(){
    $("#create-text-textarea").val("");
    $("#image-url").val("");
    $("#image-name").val("");
    $("#image-description").val("");
    $("#image-file").val("");
    $("#video-url").val("");
    $("#video-name").val("");
    $("#video-description").val("");
    $("#video-file").val("");
}

/************************************************
*************************************************

                    UPLOAD FILE (à factoriser)

*************************************************
**************************************************/

$('#image-file').on('change', function(event){
    $("#loader-img").show();
    files = event.target.files;

    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });

    $.ajax({
        url: Routing.generate('editor_questionnaire_upload-image'),
        type: 'POST',
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        data : data
    })
    .done(function(data) {
        var url = data["url"];
        $("#image-url").val(url);
        $('#create-image-btn').prop("disabled", false);
        $("#loader-img").hide();
    }); 
});


$('#video-file').on('change', function(event){
    $("#loader-img").show();
    files = event.target.files;

    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });

     $.ajax({
        url: Routing.generate('editor_questionnaire_upload-video'),
        type: 'POST',
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        data : data
    })
    .done(function(data) {
        var url = data["url"];
        $("#video-url").val(url);
        $('#create-video-btn').prop("disabled", false);
        $("#loader-img").hide();
    }); 
});

$('#audio-file').on('change', function(event){
    $("#loader-img").show();
    files = event.target.files;

    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });

     $.ajax({
        url: Routing.generate('editor_questionnaire_upload-audio'),
        type: 'POST',
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        data : data
    })
    .done(function(data) {
        var url = data["url"];
        $("#audio-url").val(url);
        $('#create-audio-btn').prop("disabled", false);
        $("#loader-img").hide();
    }); 
});