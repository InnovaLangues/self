$(function() {
    $('input#search').quicksearch('.users-table tbody tr');
});


$(function() {
	$(".delete-trace").click(function(event) {
		if ($(this).attr("href") == "#"){
			event.preventDefault();
			$(this).attr('href',$(this).attr('realpath'));
	 		$(this).html(" Confimer !");
	 	}
	});
});