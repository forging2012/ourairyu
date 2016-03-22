(function() {

$("#news .lst-wrp .lst-cnt").children("ul").children("li:last-child").css("margin-bottom", 0);
$("#news .lst-ttl").bind("click", function() {
	if ( !$(this).parent().hasClass("current") ) {
		var self = $(this), lst = self.parent(),
			lsttp = lst.attr("class").match(/lst-(.*)\b/),
			url = self.attr("href"), type = "json", html = new Array();
		
		$("#news .lst-wrp").children(".current").removeClass("current");
		lst.addClass("current");
		lst = $(".lst-cnt ul", lst);
		
		if ( lsttp ) {
			lsttp = lsttp[1];
		}
		
		if ( !lst.children().size() && !lst.data("locked") ) {
			if ( lsttp == "bkm" )	type = "jsonp";
			lst.data("locked", true).append("数据加载中...");
			
			$.ajax({
				url: url,
				type: lsttp == "bkm" ? "get" : "post",
				dataType: type,
				success: function( j ) {
					if ( j.length ) {
						$.each( j, function( i, b ) {
							html.push( "<li>" );
							
							if ( lsttp == "bkm" ) {
								html.push( "<a class=\"bkm-ttl txt-elp fl ltd-w\" href=\"" + b.u + "\" title=\"访问 &raquo; " + b.u + "\" rel=\"external nofollow\">" + b.d + "</a>" );
								html.push( "<div class=\"bkm-tag txt-elp fr ltd-w\">Tags:");
								$.each( b.t, function( n, t ) {
									html.push( " <a href=\"http://delicious.com/ourailin/" + t + "\" title=\"查看关于「" + t + "」的书签\" rel=\"external nofollow\">" + t + "</a>" );
								});
								html.push( "</div>" );
							}
							else if ( lsttp == "dm" ) {
								html.push( "<a class=\"fl txt-elp ltd-w\" href=\"" + url + b.name + "." + b.ext + "\" rel=\"external nofollow\" title=\"" + (b.description || b.title || b.name) + "\">" + (b.title || b.name) + "</a>" );
								html.push( "<span class=\"fr txt-elp ltd-w\">Updated: " + b.modified + "</span>" );
							}
							
							html.push( "</li>" );
						});
						
						lst.data("locked", false).empty().append(html.join("")).children("li:last").css("margin-bottom", 0);
					}
				},
				error: function( XMLHttpRequest, textStatus, errorThrown ) {
					alert( textStatus + ": " + errorThrown );
				}
			});
		}
	}
	
	return false;
});

})();