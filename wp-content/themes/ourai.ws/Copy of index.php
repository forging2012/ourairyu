<?php get_header(); ?>
			<div id="panel">
				<div id="info">
					<div id="tinyProfile">
						<h3><a href="javascript:void(0);" title="欧雷"><?php echo get_avatar(get_the_author_meta( 'user_email', 1 ), 96, '', '欧雷'); ?>欧雷</a></h3>
						<p>ｴｯ(ﾟДﾟ≡ﾟДﾟ)ﾏｼﾞ?</p>
						<div id="popProfile">
							<b class="arrow_top">箭头</b>
							<p>Otakism.com 站长／2.5 次元住民／任天堂铁杆粉</p>
						</div>
					</div>
					<div id="toolbar" class="clearfix">
						<dl id="menu">
							<dt><a href="javascript:void(0);"><b>图标</b>Menu</a></dt>
							<dd>
								<b class="arrow_left">箭头</b>
								<ul><?php wp_list_categories('title_li=0&orderby=name'); ?></ul>
							</dd>
						</dl>
					</div>
				</div>
				<!--
				<ul id="navbar" class="clearfix">
					<li class="first current"><a href="javascript:void(0);">HTML</a></li>
					<li><a href="javascript:void(0);">CSS</a></li>
					<li class="last"><a href="javascript:void(0);">JavaScript</a></li>
				</ul>
				-->
				<div id="filter" class="clearfix">
					<ul id="selector">
						<li class="first current"><a href="javascript:void(0);">最近</a></li>
						<li><a href="javascript:void(0);">热评</a></li>
						<li><a href="javascript:void(0);">吐槽</a></li>
						<li class="last"><a href="javascript:void(0);">标签</a></li>
					</ul>
				</div>
				<!--
				<ul id="articles"></ul>
				-->
				<?php if (have_posts()) : ?>
				<!--
				<ul id="articles">
					<?php while (have_posts()) : the_post(); update_post_caches($posts); $cmtCount = get_comments_number(get_the_ID()); ?>
					<li id="article-<?php the_ID(); ?>" class="separator">
						<a class="clearfix" href="javascript:void(0);" data-href="<?php the_permalink(); ?>">
							<h3 class="title"><?php the_title(); ?></h3>
							<span class="date"><?php echo date('M j, Y H:i:s', get_the_time('U')); ?></span>
							<span class="comments" title="被吐槽 <?php echo $cmtCount; ?> 次"><?php echo $cmtCount; ?></span>
						</a>
					</li>
					<?php endwhile; ?>
				</ul>
				-->
				<?php else : ?>
				<div class="errorbox">
					<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
				</div>
				<?php endif; ?>
			</div>
			<div id="content"></div>
<?php get_footer(); ?>