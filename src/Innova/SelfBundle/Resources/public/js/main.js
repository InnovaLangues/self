$(document).ready(function() {
	/* TOOLTIP */
	$('*').tooltip({placement:'top'});

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


    /*En cas de réponse affirmative, indiquez le niveau obtenu dans chaque compétence.
    Compréhension de l’orale # menu déroulant
    Compréhension de l’écrit # menu déroulant
    Expression écrite # menu déroulant". EV, 26/06/2014 */
    $('#fos_user_registration_form_testDialang').click(function(event) {

        // Je récupère la zone sélectionnée et en minuscules.
        var choice = $("#fos_user_registration_form_testDialang option:selected").text().toLowerCase();

        // Demande de Cristiana : si je choisis "LANSAD" alors j'affiche la liste suivante sinon je n'affiche pas.
        if (choice == 'oui')
        {
            $('#fos_user_registration_form_coLevel').show();
            $('#fos_user_registration_form_coLevel').parent().parent().show();
            $('#fos_user_registration_form_ceLevel').show();
            $('#fos_user_registration_form_ceLevel').parent().parent().show();
            $('#fos_user_registration_form_eeLevel').show();
            $('#fos_user_registration_form_eeLevel').parent().parent().show();
        }
        else
        {
            $('#fos_user_registration_form_coLevel').hide();
            $('#fos_user_registration_form_coLevel').parent().parent().hide();
            $('#fos_user_registration_form_ceLevel').hide();
            $('#fos_user_registration_form_ceLevel').parent().parent().hide();
            $('#fos_user_registration_form_eeLevel').hide();
            $('#fos_user_registration_form_eeLevel').parent().parent().hide();
        }
    });


    //Tabs login page #130
    var $tabs = $('#register-form-tabs li');

    $('.nexttab').on('click', function() {
        $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
    });


    $('body').on('click', '.locale-select', function () {
        $.ajax(Routing.generate('locale_change', {'_locale': $(this).html().toLowerCase()}))
        .done(function () {
            window.location.reload();
        });
    });

    $('body').on('click', '.change-locale', function () {
        $("#locale-modale").modal('show');
    });

});