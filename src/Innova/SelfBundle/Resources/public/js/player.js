function timestamp(){
    return Math.round((new Date()).getTime() / 1000);
}

$(document).ready(function() {
    /***
        VAR INIT
    ****/
    play_in_progress = false;
    timestampIn = timestamp();
    listening_count = new Array;

    /***
        TO KNOW IF I HAVE A SESSION DATA
    ****/
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
        alert('Ajax error 1');
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
            if (sound != "situation"){
                play_in_progress = true;
                $("#limit_listening_text").html(
                    pluralizeListen(limit, listened)
                );

                $(".item_audio_button").css("opacity","0.5");
                $(this).css("opacity","1");
                audio.play();
            }

            // Cas du clic sur "Situation de départ".
            if (sound === "situation"){
                play_in_progress = true;
                $("#limit_listening_text").html(
                    pluralizeListen(limit, listened)
                );

                $(".item_audio_button").css("opacity","0.5");
                $(this).css("opacity","1");
                audio.play();

                //Increment session
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
                    $("#limit_listening_text").html(
                        pluralizeListen(limit, listened)
                    );
                })
                .fail(function() {
                    alert('Ajax error 3');
                });
            
            }
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
        GESTION AUDIO
    **************/
    $("audio").bind("ended", function(){
        play_in_progress = false;
        sound = $(this).attr('id');
        $(".item_audio_button").css("opacity","1");
    });


    /**************
        FORM  
     **************/
    $("form").submit(function(){
        totalTime = timestamp() - timestampIn;
        $("#totalTime").val(totalTime);
    });

    /**************
        TO RESET SESSION VARIABLE IF I CLICK ON "VALIDER" BUTTON
    **************/

    $("form").submit(function(){
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
         alert('Ajax error session');
      });
    });


    /**************
        GESTION DES BADGES SUR LES ONGLETS
    **************/

    $(":checkbox, :radio").change(function(){
        var incomplete_tab = 0;
        $( ".tab-pane" ).each(function( index ) {
            subquestionId = $( this ).attr("data-subquestion-id");
            if ( $("[name='"+subquestionId+"[]']:checked").length > 0 ){
                $( "#badge-" + subquestionId ).css("background-color", "#5CB85C");
                $( "#badge-" + subquestionId ).text("ok");
                
            } else {
                $( "#badge-" + subquestionId ).css("background-color", "grey");
                $( "#badge-" + subquestionId ).text(" ");
                incomplete_tab++;

            } 
        });
        
        if (incomplete_tab == 0) {
            $("#submit").removeAttr("disabled", "disabled");
        } else {
            $("#submit").attr("disabled", "disabled");
        }
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

});