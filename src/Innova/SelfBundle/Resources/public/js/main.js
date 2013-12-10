function timestamp(){
	return Math.round((new Date()).getTime() / 1000);
}

$(document).ready(function() {

	/* TOOLTIP */
	$('img').tooltip({placement:'top'});

	/***
	WORD "ECOUTE" DISPLAY WITH OR WITHOUT "s"
	****/
	function pluralizeListen(limit, listened) {
		if((limit - listened) < 2){
			return 'écoute';
		};

		return 'écoutes';
	}

	play_in_progress = false;
	timestampIn = timestamp();
	listening_count = new Array;

	/***
	GESTION AUDIO
	****/
	$("audio").bind("ended", function(){
		play_in_progress = false;
		sound = $(this).attr('id');
		$(".item_audio_button").css("opacity","1");
	});

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
		alert('Ajax error');
	});


	/***
	IF I CLICK ON SOUND THEN I DO ...
	****/

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
			$("#limit_listening_text").html(
				pluralizeListen(limit, listened)
			);

			$(".item_audio_button").css("opacity","0.5");
			$(this).css("opacity","1");
			audio.play();
			if (sound === "situation"){
				//Increment session
				$.ajax({
					url: Routing.generate('incrementeSessionSituationListenNumber'),
					type: 'PUT',
					dataType: 'json'
				})

				.done(function(data) {
					var limitListening = $("#limit_listening").html();
					var reste = $("#limit_listening").html() - data.situationListenNumber;
					$("#listening_number").html(reste);
					var limit = $("#limit_listening").html();
					var listened = data.situationListenNumber;
					$("#limit_listening_text").html(
						pluralizeListen(limit, listened)
					);
				})
				.fail(function() {
					alert('Ajax error');
				});
			}
		}
	});

	/* FORM  */

	$("form").submit(function(){
		totalTime = timestamp() - timestampIn;
		$("#totalTime").val(totalTime);
	});


	 /***
    TO RESET SESSION VARIABLE IF I CLICK ON "VALIDER" BUTTON
    ****/

    $('.reset-listening-number').click(function(event) {
        $.ajax({
                url: Routing.generate('resetSessionSituationListenNumber'),
                type: 'PUT',
                dataType: 'json'
        })
    });
});

