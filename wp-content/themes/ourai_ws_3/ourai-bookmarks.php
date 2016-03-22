<?php
/*
	Template Name: Bookmarks
*/

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['urls'] ) {
	$urls = explode(',', urldecode($_POST['urls']));
	header( 'Content-Type: application/json; charset=UTF-8' );
	echo json_encode(multi_fetch_page($urls));
}
else {
	$ourai_cur_navi = 'bookmarks'; get_header(); ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; 全部书签</div>
				</div>
				<div><?php
//					$url = "http://css-tricks.com/,http://quirksmode.org/,http://lea.verou.me/,http://net.tutsplus.com/,http://webdesign.tutsplus.com/,http://tutsplus.com/,http://html5demos.com/,http://www.javascriptkit.com/,http://www.html5rocks.com/,http://alloyteam.github.com/,http://www.webpluz.org/,http://idc.wopus.org/,http://www.w3ctech.com/,http://hikejun.com/,http://aliceui.com/,http://www.tutorialspoint.com/,http://beforweb.com/,http://stblog.baidu-tech.com/?p=763,http://es5.github.com/,http://dict.cn/shh/";
//					$url = explode(',', urldecode($url));
//					$r = multi_fetch_page($url);
//					var_dump($r);
				?></div>
				<ul id="bookmarks"></ul>
				<div id="selector">
					<a id="tagPrev" href="javascript:void(0);" class="fl">向前</a>
					<a id="tagNext" href="javascript:void(0);" class="fr">向后</a>
					<div id="tagsContainer"><ul id="tags"></ul></div>
				</div>
			</div>
<?php get_footer(); } ?>