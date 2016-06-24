 $(function(){
    var min=10;  
    var max=33; 
    var elm = $('#item-container');  

    $('#font-up').click(function() {
        var size = getSize();
        if (size<=max) {
            size++;
            elm.css('fontSize', size+"px");
            $.cookie('self-font-size', size, { path: '/'});
        }
    });

    $('#font-down').click(function() {
        var size = getSize();
        if (size>=min) {
            size--;
            elm.css('fontSize' , size+"px");
            $.cookie('self-font-size', size, { path: '/'});
        }
    });
    
    $('#font-reset').click(function () {
        elm.css('fontSize', 19);
        $.cookie('self-font-size', 19, { path: '/'});  
    });
   
});
 
function str_replace(haystack, needle, replacement) {
    var temp = haystack.split(needle);
    return temp.join(replacement);
}

function getSize(){
    var size = $('#item-container').css("fontSize");
    size = str_replace(size, 'px', '');

    return size; 
}
