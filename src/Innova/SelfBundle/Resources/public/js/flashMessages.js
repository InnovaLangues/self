function showFlash()
{ 
    var cookie = $.cookie("flashes");

    if (!cookie) {
        return;
    }

    var flashes = JSON.parse(cookie);

    $.each(flashes, function( index, value ) {
        var msgs = flashes[index];
        for (var i = msgs.length - 1; i >= 0; i--) {
            $('.flash-messages').append('<div class="alert alert-'+index+'">' + msgs[i] + '</div>');
        };
    });

    $.removeCookie('flashes', { path: '/' });
}

$(document).ready(function() {
    showFlash();
});