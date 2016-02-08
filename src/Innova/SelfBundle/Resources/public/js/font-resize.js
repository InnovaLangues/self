 $(function(){

    //min font size
    var min=10;  

    //max font size
    var max=33; 
    
    //grab the default font size
    var reset = $('#item-container').css("fontSize");
    
    //font resize these elements
    var elm = $('#item-container');  
    
    //set the default font size and remove px from the value
    var size = str_replace(reset, 'px', ''); 
    
    //Increase font size
    $('#font-up').click(function() {
        //if the font size is lower or equal than the max value
        if (size<=max) {
                //increase the size
            size++;
                //set the font size
            elm.css({'fontSize' : size});
        }
        //cancel a click event
        return false;   
    });

    $('#font-down').click(function() {

        //if the font size is greater or equal than min value
        if (size>=min) {
                //decrease the size
            size--;
                //set the font size
            elm.css({'fontSize' : size});
        }
        //cancel a click event
        return false;   
    });
    
    //Reset the font size
    $('#font-reset').click(function () {
        //set the default font size 
         elm.css({'fontSize' : reset});     
    });
   
});
 
 //A string replace function
function str_replace(haystack, needle, replacement) {
    var temp = haystack.split(needle);
    return temp.join(replacement);
}