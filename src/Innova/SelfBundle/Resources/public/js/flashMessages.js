function showFlash()
{
    console.log("finding cookies");
    
    var cookie = $.cookie("flashes");

    console.log(cookie);

    if (!cookie) {
        console.log("Not found");
        return;
    }

    console.log("Found");

    var flashes = JSON.parse(cookie);

    console.log(flashes);

    console.log("Length : " + flashes.info.length);
    
    for (var i = flashes.info.length - 1; i >= 0; i--) {
        console.log("i : " + i);
        console.log(flashes.info);
        $('.flash-messages').append('<div class="alert alert-info">' + flashes.info[i] + '</div>');
    };

    console.log("End for");

    console.log("Removing cookie");

    $.removeCookie('flashes', { path: '/' });

    console.log("Removed");

    console.log($.cookie("flashes"));

}

$(document).ready(function() {
    showFlash();
});