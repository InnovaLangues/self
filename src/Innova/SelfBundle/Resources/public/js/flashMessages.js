function showFlashes()
{ 
    var cookie = $.cookie("flashes");

    if (!cookie) {
        return;
    }

    var flashes = JSON.parse(cookie);

    $.each(flashes, function( index, value ) {
        var msgs = flashes[index];
        for (var i = msgs.length - 1; i >= 0; i--) {
            showFlash(index, msgs[i]);
        };
    });

    $.removeCookie('flashes', { path: '/' });
}

function showFlash(index, text){
    $('.flash-messages').append('<div class="alert alert-'+index+'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + text + '</div>');
}

$(document).ready(function() {
    showFlashes();
});