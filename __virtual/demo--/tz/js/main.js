(function( window ) {

var productMenu = $("ul[data-role='products']"),
	categories = $.isPlainObject(SITE_DATA) && $.isArray(SITE_DATA.catetories) ? SITE_DATA.catetories : [],
	currentSite = location.protocol + "\/\/" + location.host,
	currentUrl = currentSite + location.pathname;

createProductMenu(categories, productMenu);
buildPage();

function createProductMenu( data, host ) {
	var catPrefix,
		pageUrl = $("#navigator [data-rel='products']").attr("href");
	
	if ( host.size() ) {
		host.empty();
		
		catPrefix = host.closest("li").size() ? (host.closest("li").attr("data-cat") + ".") : "cat-";
		
		$.each( data, function( idx, p ) {
			var text = "",
				children = [],
				branch, cat;
			
			if ( $.isPlainObject(p) ) {
				text = p.name;
				
				if ( $.isArray(p.children) ) {
					children = p.children;
				}
			}
			else if ( $.type(p) === "string" ) {
				text = $.trim(p);
			}
			
			if ( text !== "" ) {
				cat = catPrefix + (idx + 1);
				
				host.append( "<li data-cat=\"" + cat + "\"><div><a href=\"" + pageUrl + "?p_cat=" + cat.replace("cat-", "") + "\" title=\"查看属于 " + text + " 的产品\">" + text + "</a></div></li>" );
				
				if ( children.length ) {
					branch = $("li:last", host);
					branch.addClass("has-children").append("<ul class=\"submenu\"></ul>");
					createProductMenu(children, branch.children(".submenu"));
					branch.children("div").children("a").attr("href", $("li:first a", branch.children(".submenu")).attr("href"));
				}
			}
		});
	}
}

function buildPage() {
	var page = $("body").attr("data-page"),
		brief = ["<div id=\"briefIntro\">",
	             "<p>欢迎光临泰州市东华西泰索具有限公司！</p>",
	             "<p>本公司主营吊索具生产，是集研发、生产、销售为一体的专业化企业，吊索具生产的基地。 </p>",
	             "<p>热情欢迎广大海内外的客户与我们联系，我们将竭诚为您服务！</p>",
	             "</div>"];
	
	$("#header").prepend("<h3 id=\"headline\">泰州市东华西泰索具有限公司<small>——索具行业领先者</small></h3>");
	$("#header").append(brief.join(""));
	$("#footer").html("<span>版权所有&nbsp;&copy;&nbsp;泰州市东华西泰索具有限公司</span>");

	// 首页
	if ( page === "home" ) {
		$("#sidebar").height($("#content").height() - parseInt($("#sidebar").css("padding-bottom"), 10));
	}
	// 产品介绍
	else if ( page === "products" ) {
		viewProducts();
	}
}

function viewProducts() {
	var cat = location.search,
		query = {},
		branch = $(),
		target = $(),
		pageNum = 1;
	
	$.each( cat.substring(1).split("&"), function( idx, comb ) {
		comb = comb.split("=");
		query[comb[0]] = comb[1];
	});
	
	pageNum = query.p_page || pageNum;
	cat = query.p_cat;
	
	if ( cat === undefined ) {
		branch = $("#sidebar [data-role='products']").children("li").eq(0);
		
		if ( $(".submenu", branch).size() ) {
			cat = $(".submenu li:eq(0)").attr("data-cat");
		}
		else {
			cat = branch.attr("data-cat");
		}
		
		cat = cat.replace("cat-", "");
	}
	else {
		branch = $("[data-cat='cat-" + cat.split(".")[0] + "']");
	}
	
	if ( branch.size() ) {
		if ( $(".submenu", branch).size() ) {
			branch.addClass("expanded");
			target = $("[data-cat='cat-" + cat + "'] a");
		}
		else {
			target = $("a", branch);
		}
				
		$("[data-cat='cat-" + cat + "'] a").css({"font-weight": "bold", "color": "#333", "text-decoration": "none", "cursor": "default"}).removeAttr("title");
		$("#content .header").html( target.text() );
		
		showProducts(cat, pageNum);
	}
}

/**
 * 显示指定分类、页码的产品
 */
function showProducts( category, page ) {
	var numPer = 9,
		source = $.isPlainObject(SITE_DATA) && $.isPlainObject(SITE_DATA.products) ? SITE_DATA.products : {},
		products = source,
		pageNavi = [],
		catName = [],
		dirs = location.pathname.split("/"),
		catNum, catInfo, pageTotal, url;
	
	// 获取产品列表
	$.each( category.split("."), function( idx, num ) {
		var cat = "cat_";
		
		if ( catNum ) {
			catNum = catNum + "." + num;
			catInfo = catInfo.children[num-1];
		}
		else {
			catNum = num;
			catInfo = categories[num-1];
		}
		
//		catName.push( $.isPlainObject(catInfo) ? catInfo.name : catInfo );
		catName.push( num );
		
		cat += catNum;
		
		if ( products[cat] ) {
			products = products[cat];
		}
		else {
			return false;
		}
	});
		
	products = products.list || [];
	page = parseInt(page, 10);
	pageTotal = Math.ceil(products.length/numPer);
	
	if ( page > 0 && page <= pageTotal ) {
		dirs.pop();
		url = currentSite + dirs.join("/");
		
		pageNavi.push("<div class=\"page-navi\">");
		pageNavi.push("<span class=\"page-desc\">共 " + products.length + " 个产品&nbsp;&nbsp;每页 " + numPer + " 个&nbsp;&nbsp;" + page + "/" + pageTotal + " 页</span>");
		pageNavi.push("<ul class=\"page-turn\">");
		
		for ( var i=1; i<=pageTotal; i++ ) {
			if ( i === page ) {
				pageNavi.push("<li><b>" + i + "</b></li>");
			}
			else {
				pageNavi.push("<li><a href=\"" + currentUrl + "?p_cat=" + category + "&p_page=" + i + "\">" + i + "</a></li>");
			}
		}
		
		pageNavi.push("</ul></div>");
		pageNavi = pageNavi.join("");

		// 当前页显示的产品
		products = products.slice((page-1)*numPer, (numPer*page > products.length ? products.length : numPer*page));
		
		$.each( products, function( idx, p ) {
			var name = p.name || $.trim($("#content .header").text());
			
			$("#content .image-list").append("<li title=\"" + name + "\"><img src=\"" + url + "/image/products/" + encodeURI(catName.join("\/")) + "/" + p.id + ".png\"><span>" + p.id + "<br>" + name + "</span></li>");
		});
		
		$("#content .image-list").after(pageNavi);
	}
	
	return;
}
	
})( window );