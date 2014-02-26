$(document).ready(function() {
	$( ".draggable" ).draggable({
		snap: true,
		revert: "invalid"
	});

	$( ".droppable" ).droppable({
		accept: '.draggable',
		activeClass: "valid-target",
		drop: function( event, ui ) {
			$(this).droppable('option', 'accept', ui.draggable);
			var propositionId = ui.draggable.attr('propositionId');
			$("input[equivalence='"+propositionId+"']").prop("checked", false);
			$(this).find("input[equivalence='"+propositionId+"']").prop("checked", "checked");
			$("[subquestionId='"+ui.draggable.attr("last-position")+"']").droppable('option', 'accept', '.draggable');
			ui.draggable.attr("last-position", $(this).attr("subquestionId"));
		}
	});
});