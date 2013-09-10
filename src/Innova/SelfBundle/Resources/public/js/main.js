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
		//$(".item_audio_button").css("background-color","transparent");
		// if(listening_count[sound] > 1){$('.item_audio_button[sound="'+sound+'"]').css("background-color","transparent");}
	});

	$(".item_audio_button").click(function(){
		var limit = Number($(this).attr("data-limit"));
		var listened = Number($(this).attr("data-listened"));
		

		if(!play_in_progress && (limit == 0 || listened < limit)){
			play_in_progress = true;
			sound = $(this).attr("sound");
			audio = document.getElementById(sound);
			
			listened++;
			$(this).attr("data-listened", listened);

			if (sound == "situtation"){
				$("#limit_listening").html($(this).attr("data-listened"));
			}
			

			if(listened == limit){
				$(this).css("opacity","0.2");
			}


			
			audio.play();
		}
	});

	$("form").submit(function(){
		totalTime = timestamp() - timestampIn;
		$("#totalTime").val(totalTime);
	});

});