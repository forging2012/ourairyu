(function() {

$("#list [ourai-list] a").live("click", function() {
	var self = $(this), item,
		type = self.closest("[ourai-list]").attr("ourai-list"),
		id = self.parent().attr("id").split("-")[1];
		
	if ( !$("#articles [ourai-" + type + "='" + id + "']").size() ) {
		$("#articles").append("<li class=\"post\" ourai-" + type + "=\"" + id + "\">" + Blog.write( id, type ) + "</li>");
	}
	
	item = $("#articles [ourai-" + type + "='" + id + "']");
	
	if ( !item.hasClass("current") ) {
		$("[ourai-list='" + type + "'] li.current").removeClass("current");
		self.closest("li").addClass("current");
		
		$("#articles").children("li.current").removeClass("current");
		item.addClass("current");
		resize();
		
		if ( !$("#page").data("display") ) {
			$("#page").data("pos", $("#page").css("left"));
			$("#page").animate( { left: 316 }, 1000 );
			$("#page").data("display", true);
		}
	}

	return false;
});

$(document).ready(function() {
	$("#menu").children(".cat-item").each(function() {
		if ($(this).children("ul.children").size()) {
			$(this).addClass("has-children");
			$(this).children("ul.children").addClass(function( idx, cls ) {
				return "bb clr"; 
			}).prepend("<b class=\"tri tri-t\">所属分类</b>");
		}
	});
	
	// Window 全局事件
	$(window).bind({
		"click": function( e ) {
			if ( $("#selector").hasClass("selected") && !$.contains($("#selector")[0], e.target) ) {
				$("#curItemTitle a").trigger("click");
			}
		}
	});
	
	$("#curItemTitle a").bind("click", function() {
		if ( !$("#selector").hasClass("selected") ) {
			$("#selector").addClass("selected").find("dd").fadeIn("fast");
		}
		else {
			$("#selector dd").fadeOut("fast", function() { $("#selector").removeClass("selected"); });
		}
		
		return false;
	});
	
	$("#navi a, #menu a").bind("click", function() {
		if ( !$(this).parent().hasClass("current") ) {
			var list = $.contains($("#navi")[0], this) ? $("#navi") : $("#menu"),
				filter = list.attr("id") == "navi" ? $(this).attr("filter") : "category",
				cat = filter in { "category": 1, "recent": 1, "popular": 1 } ? "article" : filter;
			
			$("li.current", list).removeClass("current");
			$(this).parent().addClass("current");
			$("#curItemTitle").children("b").text($(this).text());
			
			$("#list ul:not([ourai-list='" + cat + "'])").hide();
			if ( !$(this).data("listInited") ) {
				if ( !$("#list form input[name='filter']").size() )
					$("#list form").append("<input type=\"hidden\" name=\"filter\" value=\"\" />");
				$("#list form input[name='filter']").val( filter );
				$("#list form").attr("action", $(this).attr("href")).trigger("submit");
				$(this).data("listInited", true);
			}
			else {
				if ( filter == "category" ) {
					$("#list ul:[ourai-list='" + cat + "'] li[category*='" + $(this).attr("category") + "']").show().siblings("[category!='" + $(this).attr("category") + "']").hide();
				}
				else {
					$("#list ul:[ourai-list='" + cat + "'] li[category]").show();
				}
				$("#list ul:[ourai-list='" + cat + "']").show();
			}
			
			$("#curItemTitle a").trigger("click");
			
			if ( $("#page").data("display") ) {
				$("#page").animate( { left: $("#page").data("pos") }, 1000 );
				$("#page").data("display", false);
				$("#page li.current").removeClass("current");
			}
		}
		
		return false;
	});
	
	$("#list form").bind("submit", function() {
		var form = $(this),
			type = form.find("input[name='filter']:hidden").val(),
			cat = type in { "recent": "1", "popular": "1", "category": "1" } ? "article" : type;
			
		$("#loader").show();
		
		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			data: form.serialize(),
			dataType: "json",
			success: function( j ) {
				$("#loader").hide();
				
				if ( j.code > 0 ) {
					if ( !$("#list ul[ourai-list='" + cat + "']").size() )
						$("#list").append("<ul ourai-list=\"" + cat + "\" class=\"list-" + cat + "\"></ul>");
					
					$("#list ul[ourai-list='" + cat + "']").append(Blog.list( j.items, cat, type ));
					resize();
				}
				else {
					alert( j.msg );
				}
			}
		});
		
		return false;
	});
});
	
window.onresize = function() {
	resize();
};

function resize() {
	$("#list ul[ourai-list]:visible").height(function() {
		return $("#panel").outerHeight(true) - $("#info").outerHeight(true) - $("#filter").outerHeight(true);
	});
	
	$("#page li.current .post-content").height(function() {
		return $("#page").height() - $("#page li.current .post-header").outerHeight(true);
	});
}

})();