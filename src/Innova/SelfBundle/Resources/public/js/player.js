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
        $(".item_audio_button, video").css("opacity","1");
    });

    if($("#situation").length > 0){
        var progress = $("#progress-bar");
        var situation = $("#situation").get("0");
        situation.addEventListener("timeupdate", function() {
            var value = (100 / situation.duration) * situation.currentTime;
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

        if(((listened === null || listened <= limit) && listened > 0 || sound != "situation" || limit == 0) && !play_in_progress) {
            if (sound != "situation"){
                playMedia(audio, $(this));
            } else {
                var context = getSessionContextListenNumber();
                if (context > 0 || questionnaireHasContext == false) {
                    playMedia(audio, $(this));
                    updateListenCount();
                } else {
                    $('#modal-listen-context').modal('show'); 
                }
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

            if(((listened === null || listened <= limit) && listened > 0 || limit == 0) && !play_in_progress) {

                var context = getSessionContextListenNumber();
                if (context > 0 || questionnaireHasContext == false) {
                    playButton.attr("disabled", "disabled");
                    playMedia(video, $(this));
                    $("#video").css("opacity","1");
                    updateListenCount();
                } else {
                    $('#modal-listen-context').modal('show'); 
                }
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

    $("#contexte-icon").click(function(){
        incrementeSessionContextListenNumber();
    });

});


function getSessionContextListenNumber() {
    var context = 0;
    $.ajax({
            url: Routing.generate('sessionContextListenNumber'),
            async: false,
            type: 'GET',
            dataType: 'json'
    })
    .done(function(data) {
        context = data.contextListenNumber;
    });

    return context;
}

function incrementeSessionContextListenNumber() {
    $.ajax({
        url: Routing.generate('incrementeSessionContextListenNumber'),
        type: 'PUT',
        dataType: 'json'
    });

     return true;
}


function playMedia(media, btn){
    play_in_progress = true;
    $(".item_audio_button").css("opacity","0.5");
    btn.css("opacity","1");
    media.play();
}

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
    });

    $.ajax({
         url: Routing.generate('resetSessionContextListenNumber'),
         async: false,
         type: 'PUT',
         dataType: 'json'
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

