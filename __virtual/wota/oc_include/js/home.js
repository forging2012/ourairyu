$(".timeline li.timeline-unit").each(function( idx, d ) {
	idx = $(this).closest(".timeline").children(".timeline-unit").index($(this));
	
	var lastFl = $(this).closest(".timeline").find("li.fl:last"),
		lastFr = $(this).closest(".timeline").find("li.fr:last"),
		cls;
	
	if ( idx > 1 ) {
		cls = lastFl.offset().top + lastFl.height() > lastFr.offset().top + lastFr.height() ? "fr" : "fl";
	}
	else {
		cls = idx == 0 ? "fl" : "fr";
	}
	
	$(this).addClass(cls);
});

$("[rel*='external']").live("click", function() {
	var url = this.href;
	
	if ( url && !/(^\#)|javascript/i.test(url) ) {
		window.open(url);
	}
	
	return false;
});