$(document).ready(function() {
	drpbl(".droppable");

	$( ".draggable" ).draggable({
		revert: "invalid",
		zIndex: 1000,
	});	
});


function drpbl(selector){
	$( selector ).droppable({
		accept: '.draggable',
		hoverClass: "droppable-hover",
		drop: function( event, ui ) {
			var proposition = ui.draggable;
			var propositionId = proposition.attr('propositionId');
			var lastPositionId = proposition.attr("last-position");
			var lastPositionZone = $("[dropzoneId='"+lastPositionId+"']");
			var dropzone = $(this);

			if ($("#droppable-"+propositionId).length) {
				$("#droppable-"+propositionId).addClass("droppable");

				drpbl("#droppable-"+propositionId);
				$("#droppable-"+propositionId).removeAttr("id");
			}
			
			dropzone.droppable('option', 'accept', proposition);
			//console.log("1. la dropzone n'accepte plus que l'élément présent");

			lastPositionZone.find("input[equivalence='"+propositionId+"']").prop("checked", false);
			//console.log("2. on décoche le bouton radio ailleurs");

			dropzone.find("input[equivalence='"+propositionId+"']").prop("checked", "checked");
			//console.log("3. on coche dans la dropzone");

			lastPositionZone.droppable('option', 'accept', '.draggable');
			//console.log("4. La case d'ou vient l'élement accepte tout maintenant");

			proposition.attr("last-position", dropzone.attr("dropzoneId"));
			//console.log("5. on enregistre dans l'élément courant sa position");
		}
	});
}




