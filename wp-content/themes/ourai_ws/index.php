<?php get_header(); $targetSite = get_site_url(2, '/'); if ( $targetSite == '/' ) $targetSite = get_site_url(1, '/'); ?>
			<div id="panel">
				<div id="info">
					<div id="tinyProfile">
						<h3><a href="javascript:void(0);" title="欧雷"><?php echo get_avatar(get_the_author_meta( 'user_email', 1 ), 96, '', '欧雷'); ?>欧雷</a></h3>
						<ul id="toolbar">
							<li class="item-article current"><a href="javascript:void(0);" title="查看文章">文章</a><b class="tri tri-t">当前条目</b></li>
							<!--<li class="item-demo"><a href="javascript:void(0);" title="查看示例">示例</a><b class="tri tri-t">当前条目</b></li>-->
						</ul>
						<div id="popProfile">
							<b class="tri tri-t">箭头</b>
							<p>差点成为90后的80后双鱼男，自由主义＋完美主义者，为人随和；对自己热爱的事物具有极大的热情，兴趣是我做事的动力并且成正比。目前在「人间天堂」的某家公司做前端开发工作。</p>
							<p>喜欢看热血、运动、恋爱、惊悚等类型的动漫，对傲娇、三无、弱气属性的女性角色没什么抵抗力，很容易被一击必杀！对ACT及ARPG类型的游戏爱不释手，尤其是《塞尔达传说》、《马里奥》和《恶魔城》，这三个系列是我最最喜欢的游戏！</p>
							<p>曾经疯狂地迷恋过Berryz工房和℃-ute，虽然现在也还在听她们的歌曲，但如今对渡り廊下走り隊、supercell和VOCALOID更为关注。电脑上已经存了好几十G的VOCALOID歌曲，但是只听了不到10%……</p>
						</div>
					</div>
				</div>
				<div id="filter" class="bb clr">
					<dl id="selector" blog-role="selector-wrapper">
						<dt><span blog-role="pointer"><b>选择类别</b><a href="javascript:void(0);"><b class="tri tri-r">箭头</b></a></span></dt>
						<dd class="bb">
							<b class="tri tri-l">箭头</b>
							<ul id="navi" class="clr">
								<li class="bb first last"><a href="<?php echo $targetSite; ?>list" blog-role="selector" blog-filter="article" blog-category="all" title="查看全部文章">全部文章</a></li>
								<!--<li class="bb"><a href="<?php echo $targetSite; ?>list" filter="popular">TOP15</a></li>
								<li class="bb"><a href="<?php echo $targetSite; ?>list" filter="comment">吐槽</a></li>
								<li class="bb last"><a href="<?php echo $targetSite; ?>list" filter="tag">标签</a></li>-->
							</ul>
							<ul id="menu" blog-url="<?php echo $targetSite; ?>"></ul>
						</dd>
					</dl>
				</div>
				<div id="list" class="bb" blog-role="list-wrapper">
					<div id="loader" blog-role="loader"><img src="<?php bloginfo('template_url'); ?>/image/ajax-loader-trans.gif" /><span>正在加载内容</span></div>
				</div>
			</div>
			<div id="page" class="bb" blog-role="page"><ul id="articles" blog-role="content-wrapper"></ul></div>
			<div id="board" class="bb"></div>
<?php get_footer(); ?>