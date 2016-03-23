(function() {

var Internal = function() {
    // External links
		$("a[rel*='external']").live("click", function() {
			window.open( $(this).attr("href") );
			
			return false;
		});

    // Tabs
    $(".tab-trigger").live("click", function() {
      var t = $(this);
      var w = t.closest(".tab-wrapper");
      var f = t.attr("data-flag");

      if ( t.attr("data-jump") !== "true" ) {
        if ( !t.hasClass("current") ) {
          $(".current", w).removeClass("current");

          t.addClass("current");
          $("[data-flag='" + f + "']", w).addClass("current");
        }

        location.hash = "tab_" + f;

        return false;
      }
    });

		$("#categoryList dt a").click(function() {
			if ( parseInt($(this).css("text-indent"), 10) < 0 ) {
				var content = $("#categoryList dd");

				if ( content.css("display") === "none" ) {
					content.slideDown();
				}
				else {
					content.slideUp();
				}

				return false;
			}
		});

    setTab();
	};
var External = function() {};
var ua = navigator.userAgent.toLowerCase();

function getTabFlag() {
  return (location.hash.substring(1).match(/tab_(\w+)/) || [,])[1];
}

function setTab() {
  var f = getTabFlag();

  if ( f ) {
    $(".tab-trigger[data-flag='" + f + "']").click();
  }
}

$.extend( Internal, {
	// Cookie
	getCookie: function() {
		var cookie = document.cookie, r = {};
		
		if ( cookie ) {
			$.each( cookie.split("; "), function( i, c ) {
				var t = c.split("=");
				r[unescape(t[0])] = unescape(t[1]);
			});
		}
		
		return r;
	},
	deleteCookie: function( name ) {
		if ( name && External.cookie && External.cookie[name] ) {
			var date = new Date();
			date.setTime( date.getTime()-1000000000 );
			document.cookie = escape(name) + "=" + escape(External.cookie[name]) + "; expires=" + date.toUTCString();
		}
	},
	
	// Client
	screenSize: function() {
		return { width: window.screen.width, height: window.screen.height };
	},
	systemInfo: function() {
		var plat = navigator.platform.toLowerCase(), r;
		
		if ( plat.indexOf("win") > -1 ) {
			r = ua.match(/windows nt ([\d.]+)/);
			r = r[1] == "5.0" || r[1] == "5.01" ? "Windows 2000" :
				r[1] == "5.1" ? "Windows XP" :
				r[1] == "5.2" ? "Windows Server 2003" :
				r[1] == "6.0" ? "Windows Vista" :
				r[1] == "6.1" ? "Windows 7" : null;
		}
		else {
			r = plat.indexOf("mac") > -1 ? "Mac OS" : plat.indexOf("linux") > -1 ? "Linux" : null;
		}
		
		return r;
	},
	
	// Browser
	browserInfo: function() {
		var r, s;
		
		(s = ua.match(/msie ([\d.]+)/)) ? r = { "type": navigator.appName, "version": s[1], "alias": "IE" } :
		(s = ua.match(/firefox\/([\d.]+)/)) ? r = { "type": "Mozilla Firefox", "version": s[1], "alias": "FF" } :
		(s = ua.match(/chrome\/([\d.]+)/)) ? r = { "type": "Google Chrome", "version": s[1], "alias": "GC" } :
		(s = ua.match(/opera.([\d.]+)/)) ? r = { "type": "Opera", "version": s[1], "alias": "OP" } :
		(s = ua.match(/version\/([\d.]+).*safari/)) ? r = { "type": "Apple Safari", "version": s[1], "alias": "AS" } : null;
		
		return r;
	},
	
	queryStr: function() {
		var r = null, q = location.search;
		
		if ( q ) {
			r = {};
			$.each( q.substring(1).split("&"), function( idx, val ) { r[decodeURI(val.split("=")[0])] = decodeURI(val.split("=")[1]); });
		}
		
		return r;
	}
});

$.extend( External, {
	cookie: Internal.getCookie(),
	client: {
		screen: Internal.screenSize(),
		system: Internal.systemInfo()
	},
	browser: Internal.browserInfo(),
	query: Internal.queryStr()
});

(function() {
	var cookie = External.cookie;
	
	// Filter cookie
	$.each( cookie, function( i, c ) {
		// Something about site
		if ( i == "wp_ourai" ) {
			External.site = $.parseJSON( c );
			delete External.cookie.wp_ourai;
		}
		// Visitor's IP
		else if ( i == "wp_client_ip" ) {
			External.client.ip = c;
			delete External.cookie.wp_client_ip;
		}
	});
	
	// Delicious
	if ( $("body").hasClass("pg-bookmarks") && !External.delicious ) {
		External.delicious = { tags: [] };
		
//		$.ajax({
//			url: "http://feeds.delicious.com/v2/json/tags/ourailin",
//			dataType: "jsonp",
//			success: function( tags ) {
//				$.each( tags, function( i, t ) {
//					External.delicious.tags.push( { title: i, count: t } );
//				});
//				
//				External.delicious.tags.sort(function(a, b) { return (a.title + "").charCodeAt(0) - (b.title + "").charCodeAt(0); });
//				
//				var h = new Array();
//				
//				$.each( External.delicious.tags, function( i, t ) {
//					h.push("<li><a href=\"#bookmark-tag-" + (i+1) + "\" rel=\"nofollow\">" + t.title + " (" + t.count + ")" + "</a></li>");
//				});
//				
//				$("#tags").append(h.join(""));
//			}
//		});
		
		$.ajax({
			url: "http://feeds.delicious.com/v2/json/ourailin?count=100",
			dataType: "jsonp",
			success: function( bkms ) {
				if ( bkms ) {
					var html = new Array();
					
					$.each( bkms, function( i, bkm ) {
						html.push("<li class=\"bkm\"><h3 class=\"bkm-url\"><a href=\"" + bkm.u + "\" rel=\"nofollow external\">" + bkm.d + "</a></h3>");
						$.each( bkm.t, function( n, tag ) {
							if ( tag != "" )
								html.push("<a class=\"bkm-tag\" href=\"http://delicious.com/" + bkm.a + "/" + tag + "\" rel=\"nofollow external\">" + tag + "</a>");
						});
						html.push("<span class=\"bkm-dt\">" + $.trim(bkm.dt.replace(/[T|Z]/g, " ")) + "</span></li>");
					});
					
					$("#bookmarks").append(html.join(""));
					$("#bookmarks .bkm:nth-child(even)").css({"background-color": "red", "float": "right"});
				}
			}
		});
	}
})();

Internal();

window.$_ = External;



/* --- DOM operations --- */

$("body").addClass(function() {
	return "os-" + ($_.client.system ? $_.client.system.substring(0, 3).toLowerCase() : "unknown") + " br-" + $_.browser.alias.toLowerCase() + ($.browser.msie ? parseInt($.browser.version) : "");
});

if ( window.SyntaxHighlighter ) {
	SyntaxHighlighter.defaults["auto-links"] = false;
	SyntaxHighlighter.defaults["toolbar"] = false;
	SyntaxHighlighter.all();
}

if ( $("#content .heading").size() && !$("#content .toc").size() ) {
	var mainContent = $("#toolbar").next(),
		tocItems = [];
	
	// 文章页面
	if ( $(".atc-bd", mainContent).size() ) {
		mainContent = $(".atc-bd", mainContent);
	}
	
	$("#content .heading").each(function() {
		var h = $(this),
			id = this.id,
			idx = $("#content .heading").index(h);
		
		if ( !id ) {
			id = "heading_" + (idx + 1);
			h.attr("id", id);
		}
		
		if ( idx === 0 ) {
			h.addClass("first");
		}
		else if ( idx === $("#content .heading").size() - 1 ) {
			h.addClass("last");
		}
		
		tocItems.push("<li><a href=\"#" + id + "\">" + $.trim(h.text()) + "</a></li>");
	});
	
	mainContent.prepend("<div class=\"toc\"><h3>目录</h3><ul class=\"n-rst\">" + tocItems.join("") + "</ul></div>");
}

})();
