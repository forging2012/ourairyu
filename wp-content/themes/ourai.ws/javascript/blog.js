/***************
 * Created on March 13, 2012 by Ourai Lam(http://ourai.us/)
 * 
 * 
 * 
 * Self-defined properties's table:
 * 
 * 		=================================================================================================================
 * 											Selector's				List's				Content's				Page's
 * 		=================================================================================================================
 * 		- {blog-role}:						selector-wrapper		list-wrapper		content-wrapper			page
 * 											selector				list				content
 * 											pointer					loader
 * 		-----------------------------------------------------------------------------------------------------------------
 * 		- {blog-filter}:					article					article
 * 											comment					comment
 * 											tag						tag
 * 		-----------------------------------------------------------------------------------------------------------------
 * 		- {blog-category}:					(system menu)			(system menu)
 * 											all
 * 		=================================================================================================================
 * 
 * 
 * Naming scheme of variables:
 * 
 * 		'a' is short for 'article'
 * 		'b' is short for 'blog'
 * 
 ***************/

(function() {
	
if ( !window.jQuery )
	return false;

// 内部对象
function internal() {}

// jQuery 对象的本地引用，防止其本身被污染
var $ = window.jQuery;

// 私有方法及属性
$.extend( internal, {
	articles: { items: {}, total: 0 },
	
	resize: function() {
		$("[blog-role='list']:visible").height(function() {
			return $("#panel").outerHeight(true) - $("#info").outerHeight(true) - $("#filter").outerHeight(true);
		});
		
		$("[blog-role='content'].current .post-content").height(function() {
			return $("[blog-role='page']").height() - $("[blog-role='content'].current .post-header").outerHeight(true);
		});
	},
	
	prepare: function() {},
	
	ready: function() {},
	
	init: function() {
		$( document ).ready(function() {
			var b_sel = $("[blog-role='selector']"),
				b_selwrp = $("[blog-role='selector-wrapper']"),
				b_page = $("[blog-role='page']"),
				b_cnt = $("[blog-role='content-wrapper']"),
				b_li = $("[blog-role='list-wrapper']");
			
			internal.constructMenu();
			
			// Window 全局事件
			$(window).bind({
				"click": function( e ) {
					if ( b_selwrp.hasClass("selected") && !$.contains(b_selwrp[0], e.target) ) {
						$("[blog-role='pointer'] a").trigger("click");
					}
				},
				"resize": function( e ) {
//					internal.resize();
				}
			});
			
			$("[blog-role='list'] a").live( "click", function() {
				var self = $(this), item, node,
					type = self.closest("[blog-role='list']").attr("blog-filter"),
					id = self.parent().attr("id").split("-")[1];
					
				if ( !$("[ourai-" + type + "='" + id + "']", b_cnt).size() ) {
					$.ajax({
						url: self.attr("href"),
						type: "post",
						dataType: "json",
						async: false,
						success: function( r ) {
							var html = new Array(), cats = new Array(), tags = new Array(), item = r;
							
							$.each( item.postCategory, function( idx, cat ) { cats.push( "<a rel=\"category\">" + cat.name + "</a>" ); });
							$.each( item.postTags, function( idx, tag ) { tags.push( "<a rel=\"tag\">" + tag.name + "</a>" ); });
							
							html.push( "<div class=\"post-header bb\"><h2 style=\"font-family: 'MS Yahei', 黑体;\">" + item.postTitle + "</h2><div class=\"meta\">发表于&nbsp;" + item.postDate + "&nbsp;&nbsp;&nbsp;分类：" + (cats.length ? cats.join(", ") : "暂未分类") + "&nbsp;&nbsp;&nbsp;标签：" + (tags.length ? tags.join(", ") : "暂无标签") + "</div></div>" );
							html.push( "<div class=\"post-content bb\"><div class=\"entry\"><div class=\"entry-content\">" + item.postContent + "</div></div></div>" );
							
							b_cnt.append("<li class=\"post\" ourai-" + type + "=\"" + id + "\" blog-role=\"content\">" + html.join("") + "</li>");
							
							$("[ourai-" + type + "='" + id + "'] pre", b_cnt).wrap( "<div class=\"pre-wrp\"></div>" );
						}
					});
				}
				
				item = $("[ourai-" + type + "='" + id + "']", b_cnt);
				
				if ( !item.hasClass("current") ) {
					$("[blog-role='list'][blog-filter='" + type + "'] li.current").removeClass("current");
					self.closest("li").addClass("current");
					
					b_cnt.children("li.current").removeClass("current");
					item.addClass("current");
//					internal.resize();
					
					if ( !b_page.data("display") ) {
						b_page.data("pos", b_page.css("left"));
						b_page.animate( { left: 316 }, 1000 );
						b_page.data("display", true);
					}
				}

				return false;
			});
			
			$("[blog-role='list'] sup").live( "click", function() {
				window.open( $(this).closest("a").attr("href") );
				return false;
			});
			
			$("[blog-role='pointer'] a").bind( "click", function() {
				if ( !b_selwrp.hasClass("selected") ) {
					b_selwrp.addClass("selected").find("dd").fadeIn("fast");
				}
				else {
					$("dd", b_selwrp).fadeOut("fast", function() { b_selwrp.removeClass("selected"); });
				}
				
				return false;
			});
			
			// 列表筛选器
			b_sel.live( "click", function() {
				var self = $(this),
					list = self.closest("ul"),
					item = self.parent(),
				
					b_flt = self.attr("blog-filter"),
					a_cat = self.attr("blog-category"),
					c_li = $("[blog-role='list'][blog-filter='" + b_flt + "']", b_li);
				
				// 已选中时不进行任何处理
				if ( !item.hasClass("current") ) {
					// 重新指定选中状态
					$("li.current", b_selwrp).removeClass("current");
					self.parent().addClass("current");
					self.closest("[blog-role='selector-wrapper']").find("[blog-role='pointer']").children("b").text(self.text());
					
					$("[blog-role='list']:visible", b_li).hide();
					
					if ( self.data("inited") || a_cat != "all" ) {
						if ( b_flt == "article" ) {
							if ( a_cat == "all" )
								$("li", c_li).show();
							else
								$("li:not(." + b_flt + "-" + a_cat + ")", c_li).hide().siblings("." + b_flt + "-" + a_cat).show();
						}
						
//						internal.resize();
						c_li.show().scrollTop(0);
					}
					else {
						$("[blog-role='loader']", b_li).show();
						
						$.ajax({
							url: self.attr("href"),
							type: "post",
							data: "filter=" + b_flt + "&category=" + a_cat,
							dataType: "json",
							success: function( r ) {
								$("[blog-role='loader']", b_li).hide();
								
								if ( r.code>0 ) {
									if ( !c_li.size() )
										c_li = b_li.append("<ul class=\"list-" + b_flt + "\" blog-role=\"list\" blog-filter=\"" + b_flt + "\"></ul>").find("[blog-filter='" + b_flt + "']");
									
									c_li.append( internal.constructList( r.items, b_flt, a_cat ) );
//									internal.resize();
									c_li.scrollTop(0);
									self.data("inited", true);
									$("[blog-role='list']:visible li:first a").trigger("click");
								}
								else {
									alert( r.msg );
									$("li.current", b_selwrp).removeClass("current");
									self.closest("[blog-role='selector-wrapper']").find("[blog-role='pointer']").children("b").text("选择类别");
								}
							}
						});
					}
					
					self.closest("[blog-role='selector-wrapper']").find("[blog-role='pointer'] a").trigger("click");
					
					if ( b_page.data("display") ) {
						b_page.animate( { left: b_page.data("pos") }, 1000, function() {
							b_page.find("[blog-role='content'].current").removeClass("current");
						});
						b_page.data("display", false);
					}
				}
				
				return false;
			});
			
			$("[blog-role='selector'][blog-category='all']").trigger("click");
			$("dd", b_selwrp).fadeOut("fast", function() { b_selwrp.removeClass("selected"); });
		});
	},
	
	constructMenu: function() {
		$.ajax({
			url: $("[blog-url]").attr("blog-url") + "list/",
			data: "filter=menu",
			type: "post",
			dataType: "json",
			aysnc: false,
			success: function( r ) {
				if ( r.code > 0 ) {
					var html = new Array();
					internal.constructMenuItem( r.items, html );
					$("[blog-url]").empty().append( html.join("") );
					$("[blog-url]").prepend($("[blog-url]").find("[blog-category='livelihood']").parent());
				}
			}
		});
	},
	
	constructMenuItem: function( items, htmlArr ) {
		$.each( items, function( i, item ) {
			htmlArr.push( "<li class=\"cat-item cat-item-" + item.id + (item.children ? " has-children" : "") + "\">" );
			htmlArr.push( "<a href=\"" + item.url + "\" title=\"" + (item.desc == "" ? ("查看 " + item.name + " 下的所有文章") : item.desc) + "\" blog-role=\"selector\" blog-filter=\"article\" blog-category=\"" + item.slug + "\">" + item.name + "</a>" );
			if ( item.children ) {
				htmlArr.push( "<ul class=\"children bb clr\">" );
				htmlArr.push( "<b class=\"tri tri-t\">所属分类</b>" );
				internal.constructMenuItem( item.children, htmlArr );
				htmlArr.push( "</ul>" );
			}
			else {
				htmlArr.push( " <span>(" + (item.count * 1) + ")</span>" );
			}
			htmlArr.push( "</li>" );
		});
	},
	
	// 构造文章/评论/标签列表的 HTML
	constructList: function( items, type, category ) {
		var html = new Array(),
			cats;
		
		if ( items && $.isArray(items) ) {
			$.each( items, function( idx, item ) {
				if ( type == "article" && !internal.articles.items[ "article-" + item.ID ] ) {
					internal.articles.items[ "article-" + item.ID ] = item;
					internal.articles.total++;
					
					cats = new Array();
					$.each( item.postCats, function( i, cat ) {
						cats.push( type + "-" + cat.slug );
					});
					
					html.push( "<li id=\"article-" + item.ID + "\" class=\"" + cats.join(" ") + "\"><a class=\"clr\" href=\"" + item.permalink + "\" title=\"阅读《" + item.postTitle + "》\"><h3 class=\"title\">" + item.postTitle + "<sup title=\"在新窗口中阅读《" + item.postTitle + "》\">在新窗口中阅读《" + item.postTitle + "》</sup></h3><span class=\"date\">" + item.postDate + "</span><span class=\"comments\" title=\"被吐槽 " + item.commentCount + " 次\">" + item.commentCount + "</span></a></li>" );
				}
				
				if ( type == "comment" ) {
					
				}
				
				if ( type == "tag" ) {
					
				}
			});
		}
		
		return html.join("");
	},
	
	// 文章内容区的 HTML
	constructContent: function( id, type ) {
		var html = new Array(), item;
		
		if ( type == "article" && internal.articles.items[ "article-" + id ] ) {
			var cats = new Array(), tags = new Array();
			
			item = internal.articles.items[ "article-" + id ];
			$.each( item.postCate, function( idx, cat ) { cats.push( "<a rel=\"category\" href=\"javascript:void(0);\">" + cat.name + "</a>" ); });
			$.each( item.postTags, function( idx, tag ) { tags.push( "<a rel=\"tag\" href=\"javascript:void(0);\">" + tag.name + "</a>" ); });
			
			html.push( "<div class=\"post-header bb\"><h2>" + item.postTitle + "</h2><div class=\"meta\">发表于&nbsp;" + item.postDate + "&nbsp;&nbsp;&nbsp;分类：&nbsp;" + (cats.length ? cats.join(",") : "暂未分类") + "&nbsp;&nbsp;&nbsp;标签：&nbsp;" + (tags.length ? tags.join(",") : "暂无标签") + "</div></div>" );
			html.push( "<div class=\"post-content bb\"><div class=\"entry\"><div class=\"entry-content\">" + item.postContent + "</div></div></div>" );
		}
		
		return html.join("");
	},
	
	// 对列表条目进行排序
	sort: function() { direction }
});

// 公有方法及属性
internal.prototype = {
	prepare: function() {
		internal.prepare();
	},
	
	ready: function() {
		internal.ready();
	},
	
	init: function() {
		internal.init();
	},
	
	// 生成文章/评论/标签列表
	list: function( items, type, category ) {
		return internal.constructList( items, type, category );
	},
	
	// 生成文章内容区
	write: function( id, type ) {
		return internal.constructContent( id, type );
	}
};

// 创建一个对象抛到全局环境中
window.Blog = new internal();
	
})();