var client = new Faye.Client('http://localhost:3000/');
client.subscribe('/all', function (message) {
	if (!$("#alert-maintenance").length) {
		$(".flash-messages").append('<div class="alert alert-warning">' + message.text + '</div>');
	};
});