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

    console.log("Length");

    console.log(flashes.info.length);
    
    for (var i = flashes.info.length - 1; i >= 0; i--) {
        console.log(i);
        $('.flash-messages').append('<div class="alert alert-info">' + flashes[i][1] + '</div>');
        console.log(flashes[i]);
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