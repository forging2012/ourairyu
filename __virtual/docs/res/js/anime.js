$("#content .table").each(function() {
	var self = $(this), year = self.attr("data-year"), colgroup = [], thead = "";
	
	$.each([50, 0, 100, 100, 80, 220], function( idx, width ) {
		width = width === 0 ? "" : ("width:" + width + "px");
		colgroup.push("<col style=\"" + width + "\">");
	});
	colgroup = "<colgroup>" + colgroup.join("") + "</colgroup>"
	thead = "<thead><tr><th>NO</th><th>名字</th><th>开播日期</th><th>播放形式</th><th>集数</th><th>文件信息</th></tr></thead>";
	
	self.before("<h2 id=\"Year_" + year + "\" class=\"year\" data-year=\"" + year + "\"><span>&#9798;</span> " + year + "</h2>");
	$("tbody", self).before(colgroup + thead);
	$("tbody tr", self).each(function(idx) {
		$("th", $(this)).text(idx + 1);
		$("td:first", $(this)).addClass("anime-title");
	});
	
	// 添加到目录
	$("#year_catalog").append("<li>&ndash; <a href=\"#Year_" + year + "\">" + year + "</a> (" + $("tbody tr", self).size() + ")</li>");
});

//$("#sidebar .log_section a").live("click", function() {
//	var self = $(this), hash = self.attr("href").substring(1),
//		target, tarSt, docSt = document.documentElement.scrollTop, counter, per, count = 0;
//	
//	if ( self.closest(".log_section")[0].id === "year_catalog" ) {
//		hash = hash.split("_")[1];
//		target = $("#content .year[data-year='" + hash + "']");
//		
//		tarSt = target.offset().top;
//		per = (docSt - tarSt)/10;
//		
//		counter = setInterval(function() {
//			count++;
//			document.documentElement.scrollTop = docSt - (per * count);
//			
//			if ( document.documentElement.scrollTop === tarSt ) {
//				clearInterval(counter);
//			}
//		}, 10);
//	}
//	
//	return false;
//});