$(document).ready(function() {
    var questionnaireId = $("#questionnaire-id").val();


    $( "body" ).on( "click", '#btn-theme', function() {
       setTheme(questionnaireId);
    });

    $( "body" ).on( "click", '#add-context', function() {
        $("#entity-field").val("contexte");
        $("#entity-id").val(questionnaireId);
        $("#entity-type").val("questionnaire");

        chooseMediaTypeModal("contexte");
    });

    $( "body" ).on( "click", '.media-type-choice', function() {
        createMediaModal( $(this) );
    });

    $( "body" ).on( "click", '#create-text-btn', function() {
        createText();
    });


});


/************************************************
*************************************************

                    MODALE

*************************************************
**************************************************/
function chooseMediaTypeModal( forwhat ) {
    $(".media-type-choice").attr("for-what", forwhat);
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
    createMedia(null, description, null, "text");
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
        dataType: 'json',
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
        var mediaId = data.mediaId;
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
