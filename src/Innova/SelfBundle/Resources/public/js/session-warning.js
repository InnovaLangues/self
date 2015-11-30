$(function() {
	$( "a.session-japanese").click(function( event ) {
		if ($(this).hasClass("disabled")) {
			event.preventDefault();
			showFlash("warning", "Vous devez lire l'avertissement concernant le japonais.");
		};
	});

	$( "a.japanase-warning" ).click(function( event ) {
		$( "a.session-japanese" ).removeClass("disabled");
	});
});
