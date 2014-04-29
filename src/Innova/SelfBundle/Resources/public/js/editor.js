$(document).ready(function() {
    var questionnaireId = $("#questionnaire-id").val();

    $( "body" ).on( "click", '#btn-theme', function() {
       setTheme(questionnaireId);
    });

    $( "body" ).on( "click", '#add-context', function() {
        setParamForRequest("questionnaire", "contexte", questionnaireId);
        chooseMediaTypeModal();
    });

    $( "body" ).on( "click", '#add-text', function() {
        setParamForRequest("questionnaire", "texte", questionnaireId);
        chooseMediaTypeModal();
    });

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


/************************************************
*************************************************

                    AJAX

*************************************************
**************************************************/

function createMedia(name, description, url, type) {
    var entityField = $("#entity-field").val();
    var entityId = $("#entity-id").val();
    var entityType = $("#entity-type").val();

    $.ajax({
        url: Routing.generate('editor_questionnaire_create-media'),
        type: 'POST',
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
        initializeFormsFields();
        //$("#contexte-container").replaceWith(data);
    });
}


function setTheme(questionnaireId) {
    $.ajax({
        url: Routing.generate('editor_questionnaire_set-theme'),
        type: 'POST',
        dataType: 'json',
        data: { questionnaireId: questionnaireId,
                theme: $("#theme").val() 
            }
    })
    .done(function(data) {

    }); 
}


/************************************************
*************************************************

                    MISC

*************************************************
**************************************************/

function setParamForRequest(type, field, id){
    $("#entity-field").val(field);
    $("#entity-id").val(id);
    $("#entity-type").val(type);
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

                    UPLOAD FILE

*************************************************
**************************************************/


$('#image-file').on('change', function(event){
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
    }); 
});


$('#video-file').on('change', function(event){
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
    }); 
});