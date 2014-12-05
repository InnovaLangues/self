$( "body" ).on( "click", '.toggle-favorite', function() {
    var btn = $(this);
    var testId = btn.data("test-id");
    $.ajax({
        url: Routing.generate('test_favorite_toggle', {'testId': testId }),
        type: 'GET'
    })
    .done(function(data) {
        var favoriteName = data["favoriteName"];
        if (data["isFavorite"] == true) {
            btn.find(".glyphicon").removeClass("glyphicon-star-empty").addClass("glyphicon-star");
            var url = Routing.generate('editor_test_questionnaires_show', {'testId': testId });
            $("#user-favorites").append("<li data-favorite-id=\""+testId+"\"><a  href=\""+url+"\">"+favoriteName+"</a></li>");
        } else {
            btn.find(".glyphicon").removeClass("glyphicon-star").addClass("glyphicon-star-empty");
            $("#user-favorites").find("[data-favorite-id='" + testId + "']").remove();
        };
    });
});