$(document).ready(function() {
    var questionnaireId = $("#questionnaire-id").val();
    fillMediaName($("#theme").val());
    afterAjax();

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

    $('#status').on('change',function(e){
        setStatus(questionnaireId);
    });

    $('#language').on('change',function(e){
        setLanguage(questionnaireId);
    });

    $('#fixed-order').on('change',function(e){
        isChecked = $('#fixed-order').prop('checked');
        setFixedOrder(isChecked);
    });

    /**********************
        COMMENT RELATED EVENTS 
    ************************/

    $( "body" ).on( "click", '#add-comment', function() {
        setParamForRequest("questionnaire", "comment", questionnaireId, "comments-container");
        chooseMediaTypeModal();
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

    $( "body" ).on( "click", '#add-functional-instruction', function() {
        setParamForRequest("questionnaire", "functional-instruction", questionnaireId, "functional-instruction-container");
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

    $( "body" ).on( "click", '#delete-functional-instruction', function() {
        setParamForRequest("questionnaire", "functional-instruction", questionnaireId, "functional-instruction-container");
        unlinkMedia();
    });

    $( "body" ).on( "click", '.text-type', function() {
        var textType = $(this).data("text-type");
        setTextType(textType);
    });

    $( "body" ).on( "click", '.add-instruction', function() {
        setParamForRequest("questionnaire", "instruction", questionnaireId, "subquestion-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '.delete-instruction', function() {
        setParamForRequest("questionnaire", "instruction", questionnaireId, "subquestion-container");
        unlinkMedia();
    });
    
    $( "body" ).on( "click", '#add-feedback', function() {
        setParamForRequest("questionnaire", "feedback", questionnaireId, "feedback-container");
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '#delete-feedback', function() {
        setParamForRequest("questionnaire", "feedback", questionnaireId, "feedback-container");
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
        EEC RELATED EVENTS 
    ************************/

    $( "body" ).on( "click", '#create-lacunes', function() {
        createLacunes();
    });

    $( "body" ).on( "click", '#create-liste', function() {
        createListe();
    });

    $('body').on('blur', '.clue',function(e){
        var clue = $(this).val();
        var subquestionId = $(this).data("subquestion-id");
        if(clue != ""){
            setClue(clue, subquestionId);
        }
    });

    $('body').on('change', '.clue-type',function(e){
        var clueType = $(this).val();
        var clueId = $(this).data("clue-id");
        setClueType(clueType, clueId);
    });

    $('body').on('blur', ".syllable", function(e){
        var syllable = $(this).val();
        var subquestionId = $(this).data("subquestion-id");
        setSyllable(syllable, subquestionId);
    });

    $('body').on('click', '.eec-add-distractor',function(e){
        addDistractor();
    });

    $('body').on('click', '.eec-add-distractor-mult',function(e){
        var subquestionId = $(this).data("subquestion-id");
        addDistractorMult(subquestionId);
    });

    $('body').on('click', '#add-blank-text',function(e){
        setParamForRequest("questionnaire", "blank-text", questionnaireId, "subquestion-container");
        chooseMediaTypeModal();
    });

    $('body').on('click', '#delete-blank-text',function(e){
            setParamForRequest("questionnaire", "blank-text", questionnaireId, "subquestion-container");
            unlinkMedia();
    });

    $('body').on('blur', '.eec-distractor',function(e){
        var mediaId = $(this).data("media-id");
        var text =  $(this).val();
        editDistractor(mediaId, text);
    });

    $('body').on('click', ' .eec-distractor-delete',function(e){
        var propositionId = $(this).data("proposition-id");
        setParamForRequest("proposition", "distractor", propositionId, "subquestion-container");
        unlinkMedia();
    });

    /**********************
        PROPOSITION RELATED EVENTS 
    ************************/

    $( "body" ).on( "click", '#create-proposition', function() {
        var subquestionId = $(this).data("subquestion-id");
        setParamForRequest("proposition", "proposition", subquestionId, "subquestion-"+subquestionId+"-container");
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
        createMediaModal( $(this).attr("media-type"), null);
    });

    $( "body" ).on( "click", '.edit-media', function() {
        $("#entity-to-be-reloaded").val($(this).data("entity-reloaded"));
        editMediaModal( $(this).data("media-type"), $(this).data("media-id"));
    });

    $( "body" ).on( "click", '.edit-media-btn', function() {
        editMedia($(this).data("media-type"));
    });

    $( "body" ).on( "click", '#create-texte-btn', function() {
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
        setParamForRequest("subquestion", "app-media", subquestionId, "subquestion-container");
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
        setParamForRequest("subquestion", "app-paire", subquestionId, "subquestion-container");
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

function createMediaModal(mediaType, mediaId) {
    $('#modal-media-type').modal('hide');
    $('#modal-create-'+mediaType).modal('show');  
}

function editMediaModal(mediaType, mediaId) {
    $('#modal-media-type').modal('hide');

    getMediaInfo(mediaId, function(data){
        $("#"+data.mediaType+"-description").val(data.description);
        $("#"+data.mediaType+"-name").val(data.name);
        $("#"+data.mediaType+"-url").val(data.url);
        $("#"+data.mediaType+"-id").val(data.id);
        switchEditMode();
        $('#modal-create-'+mediaType).modal('show');
    });
}


$( "body" ).on( "click", '.close-modal', function() {
    switchCreateMode();
});

function switchCreateMode(){
    $(".create-media-btn").show();
    $(".edit-media-btn").hide();
}

function switchEditMode(){
    $(".create-media-btn").hide();
    $(".edit-media-btn").show();
}




/************************************************
*************************************************

                    CREATE / EDIT MEDIA MEDIA

*************************************************
**************************************************/

function createText(){
    var name = $("#texte-name").val();
    var description = $("#texte-description").val();
    createMedia(name, description, null, "texte");
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
function editMedia(mediaType){
    beforeAjax();

    var mediaId = $("#"+mediaType+"-id").val();
    var name = $("#"+mediaType+"-name").val();
    var description = $("#"+mediaType+"-description").val();
    var url = $("#"+mediaType+"-url").val();
    var toBeReloaded = $("#entity-to-be-reloaded").val();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_update-media'),
        type: 'PUT',
        data: 
        { 
            name: name,
            description: description,
            url: url,
            mediaId: mediaId,
            toBeReloaded: toBeReloaded,
            questionnaireId: questionnaireId
        }
    })
    .done(function(data) {
        $("#"+toBeReloaded+"-container").replaceWith(data);
        initializeFormsFields();
        afterAjax();
        $("*").modal('hide');
    });
}

function createMedia(name, description, url, type) {
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    var entityField = $("#entity-field").val();
    var entityId = $("#entity-id").val();
    var entityType = $("#entity-type").val();
    var toBeReloaded = $("#entity-to-be-reloaded").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-media'),
        type: 'PUT',
        data: 
        { 
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
        afterAjax();
    });
}

function setTheme(questionnaireId) {
    beforeAjax();

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
        $("#theme").val(data.theme);
        if(data.msg != ""){
            alert(data.msg);
        }
        fillMediaName(data.theme);
        afterAjax();
    }); 
}

function setSkill(questionnaireId) {
    beforeAjax();
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
        afterAjax();
    }); 
}

function setTypology(questionnaireId) {
    beforeAjax();
    $.ajax({
        url: Routing.generate('editor_questionnaire_set-typology'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            typology: $("#typology").val() 
        }
    })
    .done(function(data) {
        $("#typology").val(data.typology);
        $("#subquestion-container").replaceWith(data.subquestions);
        afterAjax();
    }); 
}

function setStatus(questionnaireId) {
    beforeAjax();
    $.ajax({
        url: Routing.generate('editor_questionnaire_set-status'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            status: $("#status").val() 
        }
    })
    .done(function(data) {
        $("#status").val(data.status);
        afterAjax();
    }); 
}

function setLanguage(questionnaireId) {
    beforeAjax();
    $.ajax({
        url: Routing.generate('editor_questionnaire_set-language'),
        type: 'POST',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            language: $("#language").val() 
        }
    })
    .done(function(data) {
        $("#language").val(data.language);
        afterAjax();
    }); 
}


function setFixedOrder(isChecked){
    beforeAjax();
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
        afterAjax();
    }); 

}

function setLevel(questionnaireId) {
    beforeAjax();

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
        afterAjax();
    }); 
}

function unlinkMedia(){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    var entityField = $("#entity-field").val();
    var entityId = $("#entity-id").val();
    var entityType = $("#entity-type").val();
    var toBeReloaded = $("#entity-to-be-reloaded").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_unlink-media'),
        type: 'DELETE',
        data: 
        {
            questionnaireId: questionnaireId, 
            entityType: entityType,
            entityId: entityId,
            entityField: entityField
        }
    })
    .done(function(data) {
        $("#"+toBeReloaded).replaceWith(data);
        initializeFormsFields();
        afterAjax();
    });
}


function createSubquestion(questionnaireId) {
    beforeAjax();


    $.ajax({
        url: Routing.generate('editor_questionnaire_create-subquestion'),
        type: 'PUT',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            questionnaireTypology: $("#typology").val()
        }
    })
    .complete(function(data) {
        afterAjax();
        $("#subquestion-container").replaceWith(data.responseText);
    }); 
}

function deleteSubquestion(questionnaireId, subquestionId){
    beforeAjax();


    $.ajax({
        url: Routing.generate('editor_questionnaire_delete_subquestion'),
        type: 'DELETE',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            subquestionId: subquestionId,
        }
    })
    .complete(function(data) {
        afterAjax();
        $("#subquestion-container").replaceWith(data.responseText);
    });
}


function toggleRightWrong(propositionId){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_toggle_right_anwser'),
        type: 'PUT',
        data: { 
            questionnaireId: questionnaireId,
            propositionId: propositionId,
        }
    })
    .done(function(data) {
        afterAjax();
        $("#proposition-"+propositionId+"-container").replaceWith(data);
    }); 
}


function setListeningLimit(mediaId, listeningLimit){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('set-listening-limit'),
        type: 'POST',
        data: { 
            questionnaireId: questionnaireId,
            mediaId: mediaId,
            listeningLimit: listeningLimit
        }
    })
    .done(function(data) {
        afterAjax();
    });
}

function setTextType(textType){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('set-text-type'),
        type: 'PUT',
        data: {
            questionnaireId: questionnaireId,
            textType: textType,
        }
    })
    .done(function(data) {
        $("#texte-container").replaceWith(data);
        afterAjax();
    });
}

function getMediaInfo(mediaId, callBack){
    $.ajax({
        url: Routing.generate('get-media-info'),
        type: 'GET',
        dataType: 'json',
        data:
        {
            mediaId: mediaId
        }
    })
    .done(function(data) {
        return callBack(data);
    });
}

/************************************************
*************************************************

                    EEC

*************************************************
**************************************************/
function createLacunes(){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-lacunes'),
        type: 'PUT',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
        }
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        afterAjax();
    }); 
}

function createListe(){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-liste'),
        type: 'PUT',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
        }
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        afterAjax();
    }); 
}

function setClue(clue, subquestionId){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-clue'),
        type: 'PUT',
        data: { 
            questionnaireId: questionnaireId,
            subquestionId: subquestionId,
            clue: clue,
        }
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        afterAjax();
    }); 
}

function setClueType(clueType, clueId){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_set-clue-type'),
        type: 'PUT',
        dataType: 'json',
        data: { 
            clueType: clueType,
            clueId: clueId,
            questionnaireId: questionnaireId
        }
    })
    .complete(function(data) {
        afterAjax();
    }); 
}

function setSyllable(syllable, subquestionId){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-syllable'),
        type: 'PUT',
        dataType: 'json',
        data: { 
            questionnaireId: questionnaireId,
            subquestionId: subquestionId,
            syllable: syllable 
        }
    })
    .complete(function(data) {
        afterAjax();
    }); 
}


function addDistractor(){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_add-distractor'),
        type: 'PUT',
        data: {
            questionnaireId: questionnaireId,
        }
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        afterAjax();
    }); 
}

function addDistractorMult(subquestionId){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_add-distractor-mult'),
        type: 'PUT',
        data: {
            subquestionId: subquestionId,
            questionnaireId: questionnaireId,
        }
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        afterAjax();
    }); 
}

function editDistractor(mediaId, text){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_edit-distractor'),
        type: 'PUT',
        dataType: 'json',
        data: {
            questionnaireId: questionnaireId,
            mediaId: mediaId,
            text: text
        }
    })
    .complete(function(data) {
        afterAjax();
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
    $(".edit-media-btn").hide();
    $(".create-media-btn").show();
    $(".media-url").val("");
    $(".media-description").val("");
    $(".media-file").val("");
}

function fillMediaName(theme){
    $(".media-name").val(theme+"_");
}

function beforeAjax(){
    $("#loader-img").show();
    $(".btn, input").attr("disabled", "disabled");
}

function afterAjax(){
    $("#loader-img").hide();
    $(".btn, input").removeAttr("disabled");   
    $('*').tooltip({placement:'top'});
}

/************************************************
*************************************************

                    UPLOAD FILE 

*************************************************
**************************************************/

$('.file').on('change', function(event){
    beforeAjax();
    var files = event.target.files;
    var fileType = $(this).data("file-type");
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });
        
    data.append("file-type", fileType);

    $.ajax({
        url: Routing.generate('editor_questionnaire_upload-file'),
        type: 'POST',
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        data : data
    })
    .done(function(data) {
        $("#"+fileType+"-url").val(data["url"]);
        $("#create-"+fileType+"-btn").prop("disabled", false);
        afterAjax();
    }); 
});
