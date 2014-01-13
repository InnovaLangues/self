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
		if ((limit - listened) < 0){
			var diff = listened - limit;
		}
		else
		{
			var diff = limit - listened;
		}
		if(diff < 2){
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
			if (sound === "situation"){

				var consigne = 0;

				$.ajax({
						url: Routing.generate('sessionConsigneListenNumber'),
						async: false,
						type: 'GET',
						dataType: 'json'
					})
					.done(function(data) {
						consigne = data.consigneListenNumber;
					})
					.fail(function() {
						alert('Ajax error 2');
					});

				if (consigne > 0){

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
				else
				{
					alert('Vous n\'avez pas encore écouté la consigne située à gauche de l\'écran');
				};

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
    	alert("session");
      $.ajax({
         url: Routing.generate('resetSessionSituationListenNumber'),
         async: false,
         type: 'PUT',
         dataType: 'json'
      })
      .done(function(data) {
         var reste = data.situationListenNumber;
         alert('Ajax session');
         alert(reste);
         var reste = data.situationListenNumber;
         alert(reste);
      })
      .fail(function() {
         alert('Ajax error session');
      });

    	alert("consigne");
      $.ajax({
         url: Routing.generate('resetSessionConsigneListenNumber'),
         async: false,
         type: 'PUT',
         dataType: 'json'
      })
      .done(function(data) {
         var reste = data.consigneListenNumber;
         alert('Ajax consigne');
         alert(reste);
         var reste = data.consigneListenNumber;
         alert(reste);
      })
      .fail(function() {
         alert('Ajax error consigne');
      });
   });

    /*Login form validation*/
    $('.fos_user_registration_register #_submit').click(function(event) {

    	$('.fos_user_registration_register .help-block').remove();
    	$('.fos_user_registration_register .has-error').removeClass('has-error');

    	$('#register-form-tabs a:first').tab('show');

    	$('.fos_user_registration_register').find('input').each(function(){
   			if($(this).prop('required') && !$(this).val()){
	    		event.preventDefault();
	    		var div = $(this).parent().parent();
	    		div.addClass('has-error');
		   		if ($(this).prop('type') === 'email') {
	    			div.append('<div class="col-md-offset-2 col-md-10"><span class="help-block">Ce champ doit obligatoirement être un email valide</span></div>');
	    		} else {
	    			div.append('<div class="col-md-offset-2 col-md-10"><span class="help-block">Ce champ est obligatoire</span></div>');
	    		};
    		}
		});

    });

    /*Display or not "Quel était le niveau du dernier cours LANSAD que vous avez validé ?". EV, 20/12/2013 */
    $('#fos_user_registration_form_originStudent').click(function(event) {

    	// Je récupère la zone sélectionnée et en minuscules.
		var choice = $("#fos_user_registration_form_originStudent option:selected").text().toLowerCase();

		// Demande de Cristiana : si je choisis "LANSAD" alors j'affiche la liste suivante sinon je n'affiche pas.
		if (choice == 'lansad')
		{
	    	$('#fos_user_registration_form_levelLansad').show();
    		$('#fos_user_registration_form_levelLansad').parent().parent().show();
		}
		else
		{
    		$('#fos_user_registration_form_levelLansad').hide();
    		$('#fos_user_registration_form_levelLansad').parent().parent().hide();
		}
    });

	/***
    /* Allow or not to listen "Situation de départ". We must listen "Consigne didactique" before.". EV, 20/12/2013
	****/
	$(".consigne").click(function(){
		//Increment session
		$.ajax({
			url: Routing.generate('incrementeSessionConsigneListenNumber'),
			type: 'PUT',
			dataType: 'json'
		})

		.done(function(data) {
			var consigne = data.consigneListenNumber;
		})

		.fail(function() {
			alert('Ajax error 4');
		});
	});

});