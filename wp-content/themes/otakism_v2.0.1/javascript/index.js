Shadowbox.init({
	handleOversize: "drag",
	modal: true
});

$(document).ready(function() {
	// 日志一览展开/收缩
	$(".switcher", $("#posts")).bind("click", function() {
		var _this = $(this);
		var cntObj = _this.closest(".top").siblings(".bottom");

		if(_this.hasClass("open")) {
			cntObj.slideUp("normal", function() {
				_this.removeClass("open").addClass("close").attr("title", "点击展开");
			});
		}
		else {
			cntObj.slideDown("normal", function() {
				_this.removeClass("close").addClass("open").attr("title", "点击收缩");
			});
		}
	});
	
	// 网站地图分类展开/收缩
	$(".switcher", $("#categories")).bind("click", function() {
		var _this = $(this);
		var postsCnt = _this.siblings(".child-posts");
		
		if(_this.hasClass("open")) {
			_this.removeClass("open").addClass("close");
			postsCnt.fadeOut();
		}
		else {
			_this.removeClass("close").addClass("open");
			postsCnt.fadeIn();
		}
	});
	
	// 返回顶部
	$(".scroll-top").bind("click", function() { goto_top(); });
	
	if($("#profile").size() > 0) {
		$("li.profile-item").bind("click", function() {
			var _this = $(this);
			
			$(".current_profile_item").removeClass("current_profile_item");
			_this.addClass("current_profile_item");
			
			/*$("div.profile-item").hide();
			$("." + _this.attr("item")).show();*/
		});
		
		//$("li.profile-item:eq(1)").click();
	}
	
	// 分享按钮
	$("#sharebar a").bind("click", function(e) {
		var type = $(this).attr("id");
		share_to(type.substring(0, type.indexOf("-share")));
		return false;
	});
	
	// 初始化语法高亮
	SyntaxHighlighter.defaults["class-name"] = "syntaxhighlighter-ourai";
	SyntaxHighlighter.defaults["toolbar"] = false;
	SyntaxHighlighter.all();
});