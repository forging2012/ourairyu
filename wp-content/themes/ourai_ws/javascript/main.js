(function() {

//Shadowbox.init({
//	handleOversize: "drag",
//	modal: true
//});

Blog.init();

$(document).ready(function() {
	$("#tinyProfile .avatar").hover(function() {
		$("#popProfile").show();
	}, function() {
		$("#popProfile").hide();
	});
});

})();