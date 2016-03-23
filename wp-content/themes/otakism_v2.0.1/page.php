<?php get_header(); ?>
<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>

	<div id="container">
		<div id="mainHead">
			<div id="logo"></div>
			<div id="toolbar" class="menu">
				<ul class="clearfix">
					<li class="first current"><a href="http://scfans.blogbus.com/" title="supercell Fan Site"><span>SCFans</span></a></li>
					<li><a href="http://wotahouse.blogbus.com/" title="宅男的部屋" target="_blank"><span>Blog</span></a></li>
					<li><a href="http://tieba.baidu.com/f?kw=supercell" title="百度贴吧 - supercell吧" target="_blank"><span>Tieba</span></a></li>
					<li><a href="http://weibo.com/ourairyu" title="新浪微博" target="_blank"><span>Sina</span></a></li>
					<li class="last"><a href="http://www.douban.com/people/ourai/" title="豆瓣" target="_blank"><span>Douban</span></a></li>
				</ul>
			</div>
			<div id="category" class="menu">
				<ul class="clearfix">
					<?php wp_list_pages('title_li=0&sort_column=menu_order'); ?>
				</ul>
			</div>
		</div>
		<div id="mainBody" class="clearfix">
			<div id="bodyCenter">
				<?php the_content(); the_ID(); ?>
				</div>
			</div>
		</div>
		<div id="mainFoot">
			<div>Copyright © <a href="http://www.supercell.sc/" target="_blank" title="supercell member blog">supercell</a> & <a href="http://wotahouse.blogbus.com/" target="_blank" title="宅男的部屋">Ourai</a> All Rights Reserved.</div>
		</div>
	</div>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>
<?php get_footer(); ?>