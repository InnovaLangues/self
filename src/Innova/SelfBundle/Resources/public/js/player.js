$(document).ready(function() {
    getListenCount();
    uncheckEverything();
    checkBadges();

    /**************
        GESTION AUDIO
    **************/
    play_in_progress = false;

    $("audio").bind("ended", function(){
        play_in_progress = false;
        sound = $(this).attr('id');
        $(".item_audio_button, video").css("opacity","1");
    });

    if($("#situation").length > 0){
        var progress = $("#progress-bar");
        var situation = $("#situation").get("0");
        situation.addEventListener("timeupdate", function() {
            // Calculate the slider value
            var value = (100 / situation.duration) * situation.currentTime;
            // Update the slider value
            progress.attr("aria-valuenow",value).css("width",value+"%");
        });
    }

    $(".item_audio_button").click(function(){
        // Number of possible listens
        var limit = Number($(this).attr("data-limit"));

        // Number of times listened
        //var listened = Number($(this).attr("data-listened"));
        var listened = $("#listening_number").html();
        var sound = $(this).attr("sound");
        var audio = document.getElementById(sound);

        if(((listened === null || listened <= limit) && listened > 0 || sound != "situation") && !play_in_progress) {
            play_in_progress = true;
            $(".item_audio_button, video").css("opacity","0.5");
            $(this).css("opacity","1");
            audio.play();

            if (sound === "situation"){
                // $("#limit_listening_text").html( pluralizeListen(limit, listened) );
                updateListenCount();
            }
        }
    });

    /**************
        FORM  
     **************/

    timestampIn = timestamp();

    $("form").submit(function(){
        resetListenCount();
        totalTime = timestamp() - timestampIn;
        $("#totalTime").val(totalTime);
    });

    /**************
        GESTION DES BADGES SUR LES ONGLETS
    **************/

    $(":checkbox, :radio").change(function(){
        checkBadges();
    });
   

    /**************
        Fix for checkboxes group required
    **************/
    
    var chbxs = $(':checkbox[required]');
    var namedChbxs = {};
    chbxs.each(function(){
        var name = $(this).attr('name');
        namedChbxs[name] = (namedChbxs[name] || $()).add(this);
    });
    chbxs.change(function(){
        var name = $(this).attr('name');
        var cbx = namedChbxs[name];
        if(cbx.filter(':checked').length>0){
            cbx.removeAttr('required');

        }else{
            cbx.attr('required','required');
        }
    });

    /**************
        bounce the badges 
    **************/
    $(".submit-container").click(function(){
        if($("#submit").is(":disabled")) {
            $(".subquestion-not-ok").toggle( "pulsate" ).toggle( "pulsate" );
        }
    });



    /**************
        VIDEO 
    **************/
    if($("#video").length > 0){
        var progress = $("#progress-bar");
        var video = $("#video").get(0);
        var videoContainer = $("#video");
        var playButton = $("#play");

        // Event listener for the play/pause button
        playButton.click(function(){
            var limit = Number(videoContainer.attr("data-limit"));
            var listened = $("#listening_number").html();

            if(((listened === null || listened <= limit) && listened > 0 ) && !play_in_progress) {
                playButton.attr("disabled", "disabled");
                play_in_progress = true;
                video.play();
                $(".item_audio_button").css("opacity","0.5");
                $("#video").css("opacity","1");
                updateListenCount();
            }
        });

        video.addEventListener("timeupdate", function() {
            // Calculate the slider value
            var value = (100 / video.duration) * video.currentTime;
            // Update the slider value
            progress.attr("aria-valuenow",value).css("width",value+"%");
        });

        $("#video").bind("ended", function(){
            var limit = Number(videoContainer.attr("data-limit"));
            var listened = $("#listening_number").html();

            play_in_progress = false;
            $(".item_audio_button").css("opacity","1");
            progress.attr("aria-valuenow",0).css("width","0%");

            if (listened <= limit) {
                playButton.removeAttr("disabled", "disabled");
            };
            
        });

        videoContainer.bind('contextmenu',function() { return false; });
    }

});

/**************
   CHECK BADGES
**************/

function checkBadges(){
    var incomplete_tab = 0;
    $( ".tab-pane" ).each(function( index ) {
        var subquestionId = $( this ).attr("data-subquestion-id");
        var badge = $( "#badge-" + subquestionId );
        if ( $("[name='"+subquestionId+"[]']:checked").length > 0 ) {
            badge.removeClass("subquestion-not-ok").addClass("subquestion-ok");
        } else {
            badge.removeClass("subquestion-ok").addClass("subquestion-not-ok");
            incomplete_tab++;
        } 
    });
    
    if (incomplete_tab == 0) {
        $("#submit").removeAttr("disabled", "disabled");
    } else {
        $("#submit").attr("disabled", "disabled");
    }
}


/**************
    WORD "ECOUTE" DISPLAY WITH OR WITHOUT "s"
**************/

function pluralizeListen(limit, listened) {
    if ((limit - listened) < 0){
        var diff = listened - limit;
    } else {
        var diff = limit - listened;
    }
    if(diff < 2){
        return 'écoute';
    };
    return 'écoutes';
}


/**************
   AJAX REQUEST TO GET LISTENING COUNT
**************/

function getListenCount() {
    $.ajax({
        url: Routing.generate('sessionSituationListenNumber'),
        type: 'GET',
        dataType: 'json'
    })
    .done(function(data) {
        var number = $("#listening_number").html();
        if (data.situationListenNumber !== null) {
            var limit = $('#listening_number').html()
            var listened = data.situationListenNumber;

            $("#listening_number").html(limit - listened);

            $("#limit_listening_text").html(
                pluralizeListen(limit, listened)
            );
        };

        $('#listens-counter').removeClass('hidden');
    })
    .fail(function() {
        // console.log('Ajax error 1');
    });
}

/**************
   AJAX REQUEST TO INCREMENT LISTENING COUNT
**************/

function updateListenCount() {
    $.ajax({
        url: Routing.generate('incrementeSessionSituationListenNumber'),
        type: 'PUT',
        dataType: 'json'
    })
    .done(function(data) {
        var limitListening = $("#limit_listening").html();
        var reste = $("#limit_listening").html() - data.situationListenNumber;
        var consigne = data.consigneListenNumber;
        $("#listening_number").html(reste);
        var limit = $("#limit_listening").html();
        var listened = data.situationListenNumber;
        $("#limit_listening_text").html( pluralizeListen(limit, listened));
    })
    .fail(function() {
        // console.log('Ajax error 3');
    });
}


/**************
   AJAX REQUEST TO RESET LISTENING COUNT
**************/

function resetListenCount() {
    $.ajax({
         url: Routing.generate('resetSessionSituationListenNumber'),
         async: false,
         type: 'PUT',
         dataType: 'json'
    })
    .done(function(data) {
        var reste = data.situationListenNumber;
    })
    .fail(function() {
        // console.log('Ajax error session');
    });
}


/**************
    Timestamp function
**************/

function timestamp(){
    return Math.round((new Date()).getTime() / 1000);
}

/**************
    Uncheck Everything function
**************/
function uncheckEverything(){
    $('input[type="radio"],input[type="checkbox"]').prop('checked', false);
}





