$(document).ready(function() {
    uncheckEverything();
    maskManager();
    getRemainingListening();
    checkSelect();
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
        var sound = $(this).attr("sound");
        var audio = document.getElementById(sound);
        var mediaId = $(this).data("media-id");

        if(!play_in_progress){
            checkMediaClicks(mediaId, function(isPlayable){
                if(isPlayable && !play_in_progress) {
                    if (sound != "situation"){
                        playMedia(audio, $(this), mediaId);
                    } else {
                        var context = getSessionContextListenNumber();
                        if (context > 0 || questionnaireHasContext == false) {
                            playMedia(audio, $(this), mediaId);
                        } else {
                            $('#modal-listen-context').modal('show');
                        }
                    }
                }
            });
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

    /** pour le cas EEC, afin d'activer ou pas le bouton "Submit" **/
    $(".check-select").change(function(){
        checkSelect();
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

        } else {
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
            var mediaId = $(this).data("media-id");

            checkMediaClicks(mediaId, function(isPlayable){
                if(isPlayable && !play_in_progress) {
                    var context = getSessionContextListenNumber();
                    if (context > 0 || questionnaireHasContext == false) {
                        playButton.attr("disabled", "disabled");
                        playMedia(video, $(this), mediaId);
                        $("#video").css("opacity","1");
                    } else {
                        $('#modal-listen-context').modal('show');
                    }
                }
            });
        });

        video.addEventListener("timeupdate", function() {
            // Calculate the slider value
            var value = (100 / video.duration) * video.currentTime;
            // Update the slider value
            progress.attr("aria-valuenow",value).css("width",value+"%");
        });

        $("#video").bind("ended", function(){
            play_in_progress = false;
            $(".item_audio_button").css("opacity","1");
            progress.attr("aria-valuenow",0).css("width","0%");
            playButton.removeAttr("disabled", "disabled");
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


function playMedia(media, btn, mediaId){
    play_in_progress = true;
    updateMediaClicks(mediaId);
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
   CHECK SELECT
   pour le cas EEC, afin d'activer ou pas le bouton "Submit"
**************/
function checkSelect(){
    var complete_select = true;
    $( ".check-select" ).each(function( index ) {
        if ( $(this).val() == '' ) {
            complete_select = false;        }
    });

    if (complete_select) {
        $("#submit").removeAttr("disabled", "disabled");
    } else {
        $("#submit").attr("disabled", "disabled");
    }
}

/**************
    WORD "ECOUTE" DISPLAY WITH OR WITHOUT "s"
**************/
function pluralizeListen(remainingListening) {
    if(remainingListening < 2){
        return 'écoute';
    };
    return 'écoutes';
}


/**************
   AJAX REQUEST TO HANDLE MEDIA LIMITS
**************/
function checkMediaClicks(mediaId, callBack){
    var questionnaireId = $("#questionnaireId").val();
    var testId = $("#testId").val();
    $.ajax({
        url: Routing.generate('is-media-playable'),
        type: 'GET',
        dataType: 'json',
        data:
        {
            questionnaireId: questionnaireId,
            testId: testId,
            mediaId: mediaId
        }
    })
    .done(function(data, isPlayable ) {
        isPlayable = data['isPlayable'];
        return callBack(isPlayable);
    });
}

function getRemainingListening(){
    if ($('[sound="situation"]').data("media-id")){
        var questionnaireId = $("#questionnaireId").val();
        var testId = $("#testId").val();
        var mediaId = $('[sound="situation"]').data("media-id");

        $.ajax({
            url: Routing.generate('get-remaining-listening'),
            type: 'GET',
            dataType: 'json',
            data:
            {
                questionnaireId: questionnaireId,
                testId: testId,
                mediaId: mediaId
            }
        })
        .done(function(data) {
            $("#listening_number").html(data.remainingListening);
            $("#limit_listening_text").html(pluralizeListen(data.remainingListening));
            $('#listens-counter').removeClass('hidden');
        });
    }
}

function updateMediaClicks(mediaId){
    var questionnaireId = $("#questionnaireId").val();
    var testId = $("#testId").val();

    $.ajax({
        url: Routing.generate('increment-media-clicks'),
        type: 'GET',
        dataType: 'json',
        data:
        {
            questionnaireId: questionnaireId,
            testId: testId,
            mediaId: mediaId
        }
    })
    .done(function(data) {
        if ($('[sound="situation"]').data("media-id") == mediaId){
            $("#listening_number").html(data.remainingListening);
            $("#limit_listening_text").html(pluralizeListen(data.remainingListening));
            $('#listens-counter').removeClass('hidden');
        }
    });
}

/**************
   AJAX REQUEST TO RESET LISTENING COUNT
**************/
function resetListenCount() {
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


/**************
    MASKS
**************/
function maskManager(){
    $('.mask').each(function() {
        var length = $(this).data("right-answer-length");
        var mask = constructMask(length, "*");
        var placeholder = constructMask(length, "-");

        $(this).attr("placeholder", placeholder);
        $(this).mask(mask, {placeholder:'-'});
    });
}

function constructMask(count, char){
    var mask = "";
    for (var i = 0; i < count; i++) {
        mask = mask + char;
    };

    return mask;
}

/**************
    SPECIAL CHAR PICKER
**************/

var lastInputId;
$("input").focus(function(){
       lastInputId = $(this).attr("id");
});

$(".special-char").click(function(){
        var input = $("#"+lastInputId);
        var specialChar = $(this).text();
       input.val(input.val() + specialChar);
});