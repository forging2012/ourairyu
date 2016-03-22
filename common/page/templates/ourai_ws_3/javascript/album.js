(function() {

var flag = setInterval(function() {
	if ( $(".alb-lst-cnt .alb-lst").children().size() ) {
		clearInterval(flag);
		
		if ( $(".alb-dtl").size() ) {
			$(".alb-lst-cnt .alb-lst").find("img").each(function() {
				$(this).siblings(".alb-btm").eq(1).css({width: 80, height: 80});
			});
			slideAlbumList.call($(".alb-next")[0], $(".alb-data").index($("#" + $(".alb-dtl").attr("data-id")).closest(".alb-data")));
		}
		
		if ( $(".alb-dtl").size() ) {
			$(window).bind("resize", function() {
				$(".alb-dtl .pto-lst").height($(".alb-dtl").height()-$(".alb-hd").outerHeight(true)-($(".alb-bd").outerHeight(true)-$(".alb-bd").height()));
			});
		}
	}
}, 100);

if ( $(".alb-dtl").size() ) {
	$(window).bind("resize", function() {
		resizePhotoDetail();
	});
	
	// 获取当前相册的图片列表
	Flickr.albumPhotos( $(".alb-dtl").attr("data-id"), function( photos ) {
		var html = new Array(), htmlDetail = new Array(),
			width = Math.floor(($(".alb-dtl .pto-lst")[0].clientWidth-120)/10)-4;
		
		$.each( photos.photo, function( idx, photo ) {
			html.push("<li><a href=\"javascript:void(0);\" data-id=\"" + photo.id + "\" data-secret=\"" + photo.secret + "\" data-server=\"" + photo.server + "\" data-farm=\"" + photo.farm + "\">");
			html.push("<img src=\"" + photo.url + "\" title=\"" + photo.title + "\" /></a></li>");
			
			htmlDetail.push("<li class=\"abs-ctr-wrp\" data-photoid=\"" + photo.id + "\"><div class=\"abs-ctr-cnt\">");
			htmlDetail.push("<div class=\"meta fr\"><div class=\"meta-basic\"><b class=\"txt-elp\" title=\"" + photo.title + "\">" + photo.title + "</b><p></p></div></div>");
			htmlDetail.push("<div class=\"photos\"></div>");
			htmlDetail.push("</div></li>");
		});
		
		$(".pto-lst").each(function() { $(this).empty().append(html.join("")); });
		$(".alb-dtl .pto-lst img").width(width).height(width);
		$("#photoInfo .abs-ctr").empty().append(htmlDetail.join(""));
		$("#photoInfo .pto-count").text($("#photoInfo .pto-lst li").size());
	});
	
	$(".alb-dtl .pto-lst").height($(".alb-dtl").height()-$(".alb-hd").outerHeight(true)-($(".alb-bd").outerHeight(true)-$(".alb-bd").height()));
	
	if ( $(".alb-data").size() ) {
		$(".alb-ctrl").bind("click", function() {
			slideAlbumList.call(this);
			return false;
		});
	}
		
	// 点击相片列表中的相片
	$(".alb-dtl .pto-lst a").live("click", function() {
		if ( $("#photoInfo .alb-tb").css("display") !== "none" ) {
			$("#photoInfo .abs-ctr").height(document.documentElement.clientHeight - $("#photoInfo .alb-tb").outerHeight(true));
		}
		else {
			$("#photoInfo .abs-ctr").height(document.documentElement.clientHeight);
		}
		
		var self = $(this), photoId = self.attr("data-id"), item = $("[data-photoid='" + photoId + "']"),
			clWidth = document.documentElement.clientWidth*0.9, clHeight = $("#photoInfo .abs-ctr").height()*0.9;
		
		$("#photoInfo .pto-lst [data-id='" + photoId + "']").closest("li").addClass("current").siblings(".current").removeClass("current");
		
		$("#photoInfo").fadeIn("fast", function() {
			item.addClass("current");
			$(".abs-ctr-cnt", item).width(clWidth).height(clHeight > 800 ? 800 : clHeight < 400 ? 400 : clHeight);
			
			if ( !item.data("inited") ) {
				item.data("inited", true);
				
				// 相片全部尺寸
				Flickr.size(photoId, function( sizes ) {
					var html = [], dir = "", style, wrpWHratio = $(".photos", item).width()/$(".photos", item).height();
					
					$.each( sizes.size, function( idx, size ) {
						if ( wrpWHratio > size.width/size.height ) {
							style = "width: auto; height: 100%;"
						}
						else {
							style = "width: 100%; height: auto;"
						}
						
						html.push("<img data-label=\"" + size.label + "\" data-width=\"" + size.width + "\" data-height=\"" + size.height + "\" ");
						html.push("data-media=\"" + size.media + "\" data-direction=\"" + dir + "\" src=\"" + size.source + "\" style=\"");
						html.push(style + "\" />");
					});
					
					$(".photos", item).append(html.join(""));
				});
				
				// 相片基本信息
				Flickr.photoInfo(photoId, function( info ) {
					$(".meta-basic p", item).html((info.description._content || "<span style=\"font-style: italic; color: #C0C0C0;\">该相片暂无任何描述</span>"));
				});
				
				// 相片详细信息
				Flickr.exif(photoId, function( photo ) {
					var html = [], exifs = [ "CreateDate", "Make", "Model", "ImageWidth", "ImageHeight", "ExposureTime", "ISO", "Flash", "FocalLength", "Software" ],
						exifLocalize = { "CreateDate": "拍摄日期", "Make": "设备厂商", "Model": "设备型号", "ImageWidth": "图像宽度", "ImageHeight": "图像高度", "ExposureTime": "曝光时间", "ISO": "ISO 速度", "Flash": "闪光灯", "FocalLength": "焦距", "Software": "处理软件"};
					
					$.each( photo.exif, function( idx, exif ) {
						var exifTag = exif.tag, exifIdx = $.inArray(exifTag, exifs),
							exifLabel = exifLocalize[exifTag] ? exifLocalize[exifTag] : exif.label,
							exifText = exif.clean ? exif.clean._content : exif.raw._content;
						
						if ( exifIdx > -1 ) {
							html[exifIdx] = "<tr><th class=\"exif-label\">" + exifLabel + "</th><td class=\"exif-text\">" + exifText + "</td></tr>";
						}
						
						if ( html.length == exifs.length ) {
							return false;
						}
					});
					
					$(".meta", item).append("<h3>相片详细信息</h3><table><colgroup><col style=\"width: 80px;\" /><col /></colgroup><tbody>" + html.join("") + "</tbody></table>");
				});
			}
			
			var counter = setInterval(function() {
				if ( $(".photos img", item).size() ) {
					clearInterval(counter);
					$(".photos", item).css("line-height", ($(".photos", item).height() + "px"));
					item.find("[data-label='Medium 640']").show();
				}
			}, 100);
		});
		
		return false;
	});
}

$("#photoInfo .btn-close").bind("click", function() {
	if ( $(this).hasClass("alb-close") ) {
		$("#photoInfo").fadeOut("fast", function(){
			$(".photos img").hide();
			$("[data-photoid].current").removeClass("current");
		});
	}
	else if ( $(this).hasClass("pto-close") ) {
		$("#photoInfo .pto-lst-ctrl").trigger("click");
	}
	
	return false;
});

$("#photoInfo .pto-lst-ctrl").bind("click", function() {
	var tri = $(".tri", $(this));
	
	if ( tri.hasClass("tri-t") ) {
		tri.removeClass("tri-t").addClass("tri-b");
		$("#photoInfo .alb-ol").show();
		$("#photoInfo .pto-lst-wrp").animate({ marginBottom: 0, height: 130 });
	}
	else if ( tri.hasClass("tri-b") ) {
		tri.removeClass("tri-b").addClass("tri-t");
		$("#photoInfo .alb-ol").hide();
		$("#photoInfo .pto-lst-wrp").animate({ marginBottom: -34, height: 0 });
	}
	
	return false;
});

$("#photoInfo .pto-lst a").bind("click", function() {
	
});

$("#photoInfo .pto-ctrl").bind("click", function() {
	slidePhotoList.call(this);
	return false;
});

function slideAlbumList( count, callback ) {
	count = !$.isNumeric(count) ? 1 : count;
	
	var ctrl = $(this), list = $(".alb-lst-cnt .alb-lst"), item = $("#" + $(".alb-dtl").attr("data-id")).closest(".alb-data"),
		height = (item.height() + parseFloat(item.css("margin-top")))*count,
		orginal = parseFloat(list.css("margin-top")),
		clientHeight = $(".alb-lst-cnt").height(),
		scrollHeight = list[0].scrollHeight,
		result, condition, link = $(".alb-link");
	
	if ( ctrl.hasClass("alb-prev") ) {
		result = orginal + height;
		result = result > 0 ? 0 : result;
	}
	else {
		result = Math.abs(orginal) + height;
		result = -(result > (scrollHeight - clientHeight) ? (scrollHeight - clientHeight) : result);
	}
	
	list.animate({ marginTop: result }, "normal", function() {
		condition = ctrl.hasClass("alb-prev") ? (parseFloat(list.css("margin-top")) === 0) : (Math.abs(parseFloat(list.css("margin-top"))) + clientHeight) >= scrollHeight;
					
		if ( condition ) {
			ctrl.fadeOut("fast");
		}
		
		if ( $(".alb-ctrl").not(ctrl).css("display") === "none" ) {
			$(".alb-ctrl").not(ctrl).css("display", "block");
		}
		
		var offsetTop = item.offset().top,
			parentOffsetTop = $(".alb-lst-cnt").offset().top;
		
		if ( offsetTop > parentOffsetTop && offsetTop < parentOffsetTop + $(".alb-lst-cnt").height() - item.height() ) {
			link.show();
			link.animate({top: (item.offset().top - $(".alb-dtl").offset().top + 4 - link.height() + item.height())}, "fast");
		}
		else {
			link.fadeOut("fast");
			item.animate({opacity: 0.3});
		}
		
		if ( $.isFunction(callback) ) {
			callback.call( ctrl[0] );
		}
	});
}

function slidePhotoList( count, callback ) {
	count = !$.isNumeric(count) ? 1 : count;
	
	var ctrl = $(this), list = $("#photoInfo .pto-lst"), item = $("li.current", list),
		width = (item.width() + parseFloat(item.css("margin-left")))*count,
		orginal = parseFloat(list.css("margin-left")),
		clientWidth = $("#photoInfo .pto-lst-cnt").width(),
		scrollWidth = list[0].scrollWidth,
		result, condition;
	
	if ( ctrl.hasClass("pto-prev") ) {
		result = orginal + width;
		result = result > 0 ? 0 : result;
	}
	else {
		result = Math.abs(orginal) + width;
		result = -(result > (scrollWidth - clientWidth) ? (scrollWidth - clientWidth) : result);
	}
	
	list.animate({ marginLeft: result }, "normal", function() {
		condition = ctrl.hasClass("pto-prev") ? (parseFloat(list.css("margin-left")) === 0) : (Math.abs(parseFloat(list.css("margin-left"))) + clientWidth) >= scrollWidth;
					
		if ( condition ) {
			ctrl.fadeOut("fast");
		}
		
		if ( $(".pto-ctrl").not(ctrl).css("display") === "none" ) {
			$(".pto-ctrl").not(ctrl).css("display", "block");
		}
		
		if ( $.isFunction(callback) ) {
			callback.call( ctrl[0] );
		}
	});
}

function resizePhotoDetail() {
	if ( $("#photoInfo .alb-tb").css("display") !== "none" ) {
		$("#photoInfo .abs-ctr").height(document.documentElement.clientHeight - $("#photoInfo .alb-tb").outerHeight(true));
	}
	else {
		$("#photoInfo .abs-ctr").height(document.documentElement.clientHeight);
	}
	
	var clWidth = document.documentElement.clientWidth*0.9, clHeight = $("#photoInfo .abs-ctr").height()*0.9,
		item = $("[data-photoid].current"), img = $(".photos img:visible", item),
		wrpWHratio = $(".photos", item).width()/$(".photos", item).height(), WHratio = img.attr("data-width")*1/img.attr("data-height")*1;
	
	if ( wrpWHratio > WHratio ) {
		img.css({"width": "auto", "height": "100%"});
	}
	else {
		img.css({"width": "100%", "height": "auto"});
	}
	
	$(".abs-ctr-cnt", item).width(clWidth).height(clHeight > 800 ? 800 : clHeight < 400 ? 400 : clHeight);
	$(".photos", item).css("line-height", ($(".photos", item).height() + "px"));
}

})();