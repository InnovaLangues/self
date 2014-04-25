$(document).ready(function() {
    $( "body" ).on( "click", '*[data-function="edit"]', function() {
        target = $(this).data("target");
        mediaId = $(this).data("media-id");
        getMediaInfo(mediaId);
    });

});



function getMediaInfo(id) {
    $.ajax({
        url: Routing.generate('edit-media'),
        type: 'GET',
        dataType: 'json',
        data: { id: id }
    })
    .done(function(media) {
        constructModal(media);
    });
}


function constructModal(media){
    if (media["type"] == "texte"){
        modalContent = '<textarea class="tinymce">'+media["description"]+'</textarea>';
    } else if(media["type"] == "image"){
        
    }

    $("#modal-editor-body").html(modalContent);
    $('#modalEditor').modal('show');
    initTinyMCE();
}