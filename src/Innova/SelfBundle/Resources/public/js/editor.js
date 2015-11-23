$(document).ready(function() {
    var questionnaireId = $("#questionnaire-id").val();
    fillMediaName($("#theme").val());
    afterAjax();
    disableAndHideElements();

    $( "#identity-container" ).on( "click", '#save-identity-task', function() {
        setIdentityField( $("#questionnaire-identity"), function( response ){});
    });

    $( "#general-infos" ).on( "change", 'select.identity-select, :checkbox.identity-select', function() {
        var field = $(this).data("field");
        var value = $(this).val();
        setGeneralInfoFields(questionnaireId, field, value);
    });

    $( "#general-infos" ).on( "blur", 'textarea.identity-select, :text.identity-select', function() {
        var field = $(this).data("field");
        var value = $(this).val();
        setGeneralInfoFields(questionnaireId, field, value);
    });

    $( "body" ).on( "change", 'select.identity-select.to-check', function() {
        $(this).addClass('blocked');
        $(this).attr('disabled', true);
    });

    $( "body" ).on( "click", '.identity-subquestion', function() {
        var subquestionId = $(this).data("subquestion-id");
        subquestionIdentityModal(subquestionId);
    });

    $("body").on("submit", '#subquestion-identity', function(e) { 
        e.preventDefault();
        postForm( $(this), function( response ){
        });
        return false;
    });


    /**********************
        GENERAL INFOS EVENTS 
    ************************/

    $('#text-title').on('blur',function(e){
        setTextTitle(questionnaireId);
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
        $("#delete-subquestion-id").val(subquestionId);
        $('#modal-subquestion-delete').modal('show');
    });

     $( "body" ).on( "click", '#delete-subquestion', function() {
        var subquestionId = $("#delete-subquestion-id").val();
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

    $( "body" ).on( "click", '#create-lacunes-need-confirm', function() {
        $("#modal-lacunes-generate").modal('show');
    });

    $( "body" ).on( "click", '#create-listes-need-confirm', function() {
        $("#modal-listes-generate").modal('show');
    });

    $( "body" ).on( "click", '#create-lacunes-confirmation, #create-lacunes', function() {
        createLacunes();
    });

    $( "body" ).on( "click", '#create-listes-confirmation, #create-listes', function() {
        createListes();
    });

    $( "body" ).on( "click", '#eec-add-answer-btn', function() {
        addEECAnswer();
    });

    $('body').on('blur', '.clue',function(e){
        var clue = $(this).val();
        var subquestionId = $(this).data("subquestion-id");
        setClue(clue, subquestionId);
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

    $('body').on('click', "#display", function(e){
        var isDisplay = $('#display').prop('checked');
        var subquestionId = $(this).data("subquestion-id");
        setDisplay(isDisplay, subquestionId);
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
        $("#modal-confirm-blank-delete").modal('show');
    });

    $('body').on('click', '#confirm-blank-delete',function(e){
        setParamForRequest("questionnaire", "blank-text", questionnaireId, "subquestion-container");
        unlinkMedia();
        $("#modal-confirm-blank-delete").modal('hide');
    });

    $('body').on('blur', '.eec-distractor',function(e){
        var mediaId = $(this).data("media-id");
        var text =  $(this).val();
        editDistractor(mediaId, text);
    });
        
    $('body').on('click', '.eec-distractor-delete',function(e){
        $("#confirm-distractor-delete").data("proposition-id", $(this).data("proposition-id"));
        $("#modal-confirm-distractor-delete").modal('show');
    });

    $('body').on('click', '#confirm-distractor-delete',function(e){
        var propositionId = $(this).data("proposition-id");
        setParamForRequest("proposition", "distractor", propositionId, "subquestion-container");
        unlinkMedia();
        $("#modal-confirm-distractor-delete").modal('hide');
    });

    $('body').on('click', ' .btn-display-answers',function(e){
       $('#answers-modal .modal-body').html("Loading...");
       var subquestionId = $(this).data("subquestion-id");
       getAnswers(subquestionId);
    });

    $('body').on('click', ' .btn-toggle-right-answer',function(e){
       var propositionId = $(this).data("proposition-id");
       toggleRightAnswer(propositionId);
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
        url: Routing.generate('editor_questionnaire_update-media', 
            {
                'questionnaireId':questionnaireId,
                'mediaId': mediaId
            }),
        type: 'PUT',
        data:
        {
            name: name,
            description: description,
            url: url,
            toBeReloaded: toBeReloaded,
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
        url: Routing.generate('editor_questionnaire_create-media', 
            {
                'questionnaireId': questionnaireId
            }),
        type: 'PUT',
        data:
        {
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
        
        afterAjax();
    });
}

function setTextTitle(questionnaireId) {
    beforeAjax();

    $.ajax({
        url: Routing.generate('editor_questionnaire_set-text-title',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'POST',
        dataType: 'json',
        data: {
            title: $("#text-title").val()
        }
    })
    .done(function(data) {
        $("#text-title").val(data.title);
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
        url: Routing.generate('editor_questionnaire_unlink-media',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'DELETE',
        data:
        {
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
        url: Routing.generate('editor_questionnaire_create-subquestion',
            {
                'questionnaireId': questionnaireId,
                'typologyId': $("#typology").val()

            }),
        type: 'PUT',
        dataType: 'json',
    })
    .complete(function(data) {
        afterAjax();
        $("#subquestion-container").replaceWith(data.responseText);
    });
}

function deleteSubquestion(questionnaireId, subquestionId){
    beforeAjax();

    $.ajax({
        url: Routing.generate('editor_questionnaire_delete_subquestion',
            {
                'questionnaireId': questionnaireId,
                'subquestionId': subquestionId
            }),
        type: 'DELETE',
        dataType: 'json',
    })
    .complete(function(data) {
        afterAjax();
        $("#subquestion-container").replaceWith(data.responseText);
        $('#modal-subquestion-delete').modal('hide');
    });
}


function toggleRightWrong(propositionId){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_toggle_right_anwser',
            {
                'questionnaireId': questionnaireId,
                'propositionId': propositionId
            }),
        type: 'PUT',
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
        url: Routing.generate('set-listening-limit', {
            'questionnaireId':questionnaireId, 
            'mediaId':mediaId,
            'limit': listeningLimit
        }),
        type: 'PUT',
    })
    .done(function(data) {
        afterAjax();
    });
}

function setTextType(textType){
    beforeAjax();

    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('set-text-type',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'PUT',
        data: {
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
        url: Routing.generate('get-media-info', { 'mediaId': mediaId}),
        type: 'GET',
        dataType: 'json',
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
        url: Routing.generate('editor_questionnaire_create-lacunes',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'PUT',
        dataType: 'json',
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        $("#modal-lacunes-generate").modal('hide');
        afterAjax();
    });
}

function createListes(){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-liste',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'PUT',
        dataType: 'json',
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        $("#modal-listes-generate").modal('hide');
        afterAjax();
    });
}

function setClue(clue, subquestionId){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-clue',
            {
                'questionnaireId': questionnaireId,
                'subquestionId': subquestionId
            }),
        type: 'PUT',
        data: {
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
        url: Routing.generate('editor_questionnaire_set-clue-type',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'PUT',
        data: {
            clueType: clueType,
            clueId: clueId,
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
        url: Routing.generate('editor_questionnaire_create-syllable',
            {
                'questionnaireId': questionnaireId,
                'subquestionId': subquestionId
            }),
        type: 'PUT',
        data: {
            syllable: syllable
        }
    })
    .complete(function(data) {
        afterAjax();
    });
}

function setDisplay(display, subquestionId){
    beforeAjax();

    $.ajax({
        url: Routing.generate('editor_questionnaire_set-display',
            {
                'subquestionId': subquestionId,
                'display': display
            }),
        type: 'PUT',
    })
    .done(function(data) {
        afterAjax();
    });
}

function addDistractor(){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_add-distractor',
            {
                'questionnaireId': questionnaireId
            }),
        type: 'PUT',
    })
    .complete(function(data) {
        $("#subquestion-container").replaceWith(data.responseText);
        afterAjax();
    });
}


function addEECAnswer(){
    var subquestionId = $("#eec-add-answer-btn").data("subquestion-id");
    var answer = $("#eec-add-answer").val();

    if (answer != ""){
        beforeAjax();
        $.ajax({
            url: Routing.generate('editor_questionnaire_add-eec-answer',
                {
                    'subquestionId': subquestionId,
                }),
            type: 'POST',
            data: {
                'answer': answer
            }
        })
        .complete(function(data) {
            getAnswers(subquestionId);
        });
    } 
}

function addDistractorMult(subquestionId){
    beforeAjax();
    var questionnaireId = $("#questionnaire-id").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_add-distractor-mult',
            {
                'questionnaireId': questionnaireId,
                'subquestionId': subquestionId
            }),
        type: 'PUT',
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
        url: Routing.generate('editor_questionnaire_edit-distractor',
            {
                'questionnaireId': questionnaireId,
                'mediaId': mediaId
            }),
        type: 'PUT',
        data: {
            text: text
        }
    })
    .complete(function(data) {
        afterAjax();
    });
}

function getAnswers(subquestionId){
    beforeAjax();
    $.ajax({
        url: Routing.generate('editor_questionnaire_get_answers',
            {
                'subquestionId': subquestionId
            }),
        type: 'GET',
        dataType: 'json',
    })
    .complete(function(data) {
        $("#answers-modal .modal-body").html(data.responseText);
        $('#answers-modal').modal('show');
        afterAjax();
    });
}

function toggleRightAnswer(propositionId){
    beforeAjax();
    $.ajax({
        url: Routing.generate('ecc_toggle_answer',
            {
                'propositionId': propositionId
            }),
        type: 'PUT',
        dataType: 'json',
    })
    .complete(function(data) {
        $("#answer-"+propositionId).html(data.responseText);
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
    $(".btn, input, textarea, select:not(.to-check)").attr("disabled", "disabled");
}

function afterAjax(){
    $("#loader-img").hide();
    $(".btn, input, textarea, select:not(.to-check)").removeAttr("disabled");
    $('*').tooltip({placement:'top'});
}

function disableAndHideElements(){
    var typologyContainer = $("#typology-container");
    var taskContent = $(".task-content");

    $( ".to-check" ).each(function() {
        if ($(this).val() != "-" && $( this ).val() != "" ) {
            $(this).attr("disabled", true);
        };
    });

    if(!typologyContainer.is(":visible") ){
        taskContent.hide();
    }
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
        data: data
    })
    .done(function(data) {
        if (data["msg"] != "") { 
            alert(data["msg"])
        } else {
            $("#"+fileType+"-url").val(data["url"]);
            $("#create-"+fileType+"-btn").prop("disabled", false);
        };
        afterAjax();
    });
});


/************************************************
*************************************************

                    fix tiny bug

*************************************************
**************************************************/

$.widget("ui.dialog", $.ui.dialog, {
    _allowInteraction: function(event) {
    return !!$(event.target).closest(".mce-container,.moxman-container").length || this._super( event );
    }
});

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window,.moxman-container").length) {
    e.stopImmediatePropagation();
    }
});

/************************************************
*************************************************

                  Identity

*************************************************
**************************************************/
function setIdentityField(form){
    var data = form.serializeArray();
    var questionnaireId = $("#questionnaire-id").val();
    beforeAjax();

    $.ajax({
        type: 'POST',
        url: Routing.generate('set-identity-field',
            {
                'questionnaireId': questionnaireId
            }),
        data: data,
        complete: function(data) {
            $('#modal-subquestion-identity').modal('hide');
            afterAjax();
        },

    });
}

function setGeneralInfoFields(questionnaireId, field, value){
    beforeAjax();
    $.ajax({
        url: Routing.generate('set-general-info-field',
            {
                'questionnaireId': questionnaireId
            }),
            type: 'POST',
            dataType: 'json',
            data: {
                field: field,
                value: value
            }
        })
        .done(function(data) {
            if (field == "skill") {
                $("#general-infos").html(data.template);
                $("#questionnaire_skill").attr("disabled", true);
            } else if(field == "typology") {
                $("#subquestion-container").replaceWith(data.subquestions);
                $(".task-content").show();
            } else if(field == "theme"){
                fillMediaName(value);
            }
            afterAjax();
        }
    );
}

function subquestionIdentityModal(subquestionId){
    beforeAjax();

    $.ajax({
        url: Routing.generate('editor_subquestion-identity-form',
            {
                'subquestionId': subquestionId
            }),
        type: 'GET',
    })
    .done(function(data) {
        $('#modal-subquestion-identity').find(".modal-body").html(data);
        $("#subquestion_id").val(subquestionId);
        $('#modal-subquestion-identity').modal('show');
        afterAjax();
    });
}

function postForm(form){
    var data = form.serializeArray();
    beforeAjax();

    $.ajax({
        type: 'POST',
        url: Routing.generate('set-subquestion-identity-field',
            {
                'subquestionId': $("#subquestion_id").val()
            }),
        data: data,
        complete: function(data) {
            $('#modal-subquestion-identity').modal('hide');
            afterAjax();
        },
    });
}



