$(document).ready(function() {
	$( ".draggable" ).draggable({
		revert: "invalid",
		zIndex: 100,
		start: function (){
			$(this).addClass('draggable-in-black');
		},
		stop: function (){
			$(this).removeClass('draggable-in-black');
		}
	});	

	$( ".droppable" ).droppable({
		accept: '.draggable',
		activeClass: "ui-state-highlight",
		hoverClass: "droppable-hover",
		drop: function( event, ui ) {
			$(this).droppable('option', 'accept', ui.draggable);
			var propositionId = ui.draggable.attr('propositionId');
			$("input[equivalence='"+propositionId+"']").prop("checked", false);
			$(this).find("input[equivalence='"+propositionId+"']").prop("checked", "checked");
			$(this).addClass("answered");
			$("[subquestionId='"+ui.draggable.attr("last-position")+"']").droppable('option', 'accept', '.draggable');
			$("[subquestionId='"+ui.draggable.attr("last-position")+"']").removeClass("answered");
			ui.draggable.attr("last-position", $(this).attr("subquestionId"));
		}
	});
});