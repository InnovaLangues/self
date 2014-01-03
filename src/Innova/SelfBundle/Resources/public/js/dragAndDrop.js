$(document).ready(function() {
	$( ".draggable" ).draggable({
		snap: true,
		revert: "invalid"
	});

	$( ".droppable" ).droppable({
		accept: ".draggable",
		activeClass: "valid-target",
		drop: function( event, ui ) {
			$(this).droppable('option', 'accept', ui.draggable);
			var propositionId = ui.draggable.attr('propositionId');
			$(this).find("input[equivalence='"+propositionId+"']").prop("checked", "checked");
		}
		/*
		out: function(event, ui){
        	$(this).droppable('option', 'accept', '.draggable');
        	var propositionId = ui.draggable.attr('propositionId');
			$(this).find("input[equivalence='"+propositionId+"']").removeAttr("checked");
        }
        */
	});
});