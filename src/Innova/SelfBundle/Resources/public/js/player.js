$(document).ready(function() {

    getListenCount();
    checkBadges();

    /**************
        GESTION AUDIO
    **************/

    play_in_progress = false;

    $("audio").bind("ended", function(){
        play_in_progress = false;
        sound = $(this).attr('id');
        $(".item_audio_button").css("opacity","1");
    });

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
            $(".item_audio_button").css("opacity","0.5");
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
            $(".subquestion-not-ok").hide(200).show(200);
        }
    });


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
       CHECK BADGES
    **************/

    function checkBadges(){
        var incomplete_tab = 0;
        $( ".tab-pane" ).each(function( index ) {
            subquestionId = $( this ).attr("data-subquestion-id");
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
});