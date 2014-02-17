$(document).ready(function() {
    $("video").click(function(){
        $(this).get(0).play();
    });

    $('.modal').on('hidden.bs.modal', function () {
        $("video").each(function(){
            $(this).get(0).pause();
        });
    })
});