$(document).ready(function() {
	drpbl(".droppable");

	$( ".draggable" ).draggable({
		revert: "invalid",
		stack:".droppable",
		cancel: '.modal'
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

			if(dropzone != lastPositionZone) {
				//console.log("On ajoute/enlève une classe aux dropzones");
				lastPositionZone.removeClass("answered");
				dropzone.addClass("answered");
			
				// on gère le cas de la position initiale qui peut
				// désormais accueillir d'autres draggable
				if ($("#droppable-"+propositionId).length) {
					$("#droppable-"+propositionId).addClass("droppable");
					drpbl("#droppable-"+propositionId);
					$("#droppable-"+propositionId).removeAttr("id");
				}
				
				//console.log("la nouvelle zone n'accepte que la proposition qu'elle contient")
				dropzone.droppable('option', 'accept', proposition);

				//console.log("2. on décoche le bouton radio ailleurs");
				lastPositionZone.find("input[equivalence='"+propositionId+"']").prop("checked", false);

				//console.log("3. on coche dans la dropzone");
				dropzone.find("input[equivalence='"+propositionId+"']").prop("checked", "checked");

				//console.log("4. La case d'ou vient l'élement accepte tout maintenant");
				lastPositionZone.droppable('option', 'accept', '.draggable');

				//console.log("5. on enregistre dans l'élément courant sa position");
				proposition.attr("last-position", dropzone.attr("dropzoneId"));
			}

			checkBadges();
		}
	});
}
