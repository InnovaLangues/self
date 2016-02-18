$('#right_user_test_user, #right_user_session_user').select2({
	ajax: {
	    url: Routing.generate('get_users_for_rights'),
	    dataType: 'json',
	    type: "GET",
	    minimumInputLength: 0,            
	    delay: 1000,
	    processResults: function (data) {
	    	console.log(data);
	        return {
	            results: $.map(data.users, function (user) {
	                return {
	                    text: user.username,
	                    id: user.id
	                }
	            })
	        };
	    }
	}
});
