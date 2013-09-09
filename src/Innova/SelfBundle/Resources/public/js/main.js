function timestamp(){
	return Math.round((new Date()).getTime() / 1000);
}

$(document).ready(function() {
	play_in_progress = false;
	timestampIn = timestamp();
	listening_count = new Array;

	/***
			GESTION AUDIO
							****/

	$("audio").bind("ended", function(){
		play_in_progress = false;
		sound = $(this).attr('id');
		$(".item_audio_button").css("background-color","transparent");
		// if(listening_count[sound] > 1){$('.item_audio_button[sound="'+sound+'"]').css("background-color","transparent");}
	});

	$(".item_audio_button").click(function(){
		if(!play_in_progress){
			play_in_progress = true;
			sound = $(this).attr("sound");
			statut = $(this).attr("statut");
			$(".item_audio_button").css("background-color","lightgrey");
			$(this).css("background-color","#90EE90");
			audio = document.getElementById(sound);
			audio.play();
		}
	});

	$("form").submit(function(){
		totalTime = timestamp() - timestampIn;
		$("#totalTime").val(totalTime);
	});

});