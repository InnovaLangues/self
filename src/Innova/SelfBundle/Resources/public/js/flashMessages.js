function showFlash()
{
    var cookie = $.cookie("flashes");

    if (!cookie) {
        return;
    }

    var flashes = JSON.parse(cookie);
    
    for (var i = flashes.length - 1; i >= 0; i--) {
        $('.flash-messages').append('<div class="alert alert-' + flashes[i][0] + '">' + flashes[i][1] + '</div>');
        //console.log(flashes[i]);
    };

    $.removeCookie('flashes', { path: '/' });
}

$(document).ready(function() {
    showFlash();
});