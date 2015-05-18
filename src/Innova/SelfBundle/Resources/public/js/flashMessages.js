function showFlash()
{ 
    var cookie = $.cookie("flashes");

    if (!cookie) {
        return;
    }

    var flashes = JSON.parse(cookie);

    for (var i = flashes.danger.length - 1; i >= 0; i--) {
        $('.flash-messages').append('<div class="alert alert-danger">' + flashes.danger[i] + '</div>');
    };

    for (var i = flashes.warning.length - 1; i >= 0; i--) {
        $('.flash-messages').append('<div class="alert alert-warning">' + flashes.warning[i] + '</div>');
    };

    for (var i = flashes.success.length - 1; i >= 0; i--) {
        $('.flash-messages').append('<div class="alert alert-success">' + flashes.success[i] + '</div>');
    };

    for (var i = flashes.info.length - 1; i >= 0; i--) {
        $('.flash-messages').append('<div class="alert alert-info">' + flashes.info[i] + '</div>');
    };

    $.removeCookie('flashes', { path: '/' });
}

$(document).ready(function() {
    showFlash();
});