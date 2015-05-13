function showFlash()
{
    //var cookie = getCookie("flashes"); // fos_http_cache.flash_message.name

    var cookie = $.cookie("flashes");

    if (!cookie) {
        console.log("pas trouvé le cookie");
        return;
    }

    console.log("trouvé le cookie");
    console.log(cookie);

    var flashes = JSON.parse(cookie);
    console.log(flashes);
    // show flashes in your DOM...
    for (var i = flashes.length - 1; i >= 0; i--) {
        console.log(flashes[i]);
    };

    document.cookie = "flashes=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}


$(document).ready(function() {
    showFlash();
});