<?php get_header(); ?>

<div id="profile" class="clearfix">
	<ul style="display: none;">
		<?php wp_list_authors('optioncount=1&hide_empty=0'); ?>
	</ul>
    <?php
		if(isset($_GET['author_name'])) {
			$curauth = get_userdatabylogin($author_name);
		}
		else {
			$curauth = get_userdata(intval($author));
		}
    ?>
	<div class="top clearfix">
		<a href="<?php bloginfo('url'); ?>/author/<?php echo $curauth->user_nicename; ?>" title="<?php echo $curauth->nickname; ?>"><?php echo get_avatar($curauth->user_email, 64); ?></a>
		<h2 class="nickname"><?php echo $curauth->nickname; ?></h2>
		<div class="user">ID: <?php echo $curauth->user_login; ?></div>
		<div class="date">于&nbsp;<?php echo date('M j, Y', get_the_time('U')); ?>&nbsp;加入</div>
	</div>
	<div class="center clearfix">
		<div class="profile-item intro">
			<div><?php if($curauth->user_description == "") : echo '这家伙是个谜！'; else : echo $curauth->user_description; endif; ?></div>
		</div>
		<div class="profile-item contact">
			<h3>联系方式</h3>
			<ul>
				<li><span>电子邮件：</span><a href="mailto:<?php echo $curauth->user_email; ?>" title="<?php echo "发送电子邮件给"; ?><?php echo $curauth->nickname; ?>"><?php echo $curauth->user_email; ?></a></li>
				<li><span>个人网站：</span><a href="<?php echo $curauth->user_url; ?>" target="_blank" title="点击查看<?php echo $curauth->nickname; ?>的网站"><?php echo $curauth->user_url; ?></a></li>
				<li><span>AIM：</span><?php echo $curauth->aim; ?></li>
				<li><span>Yahoo IM：</span><?php echo $curauth->yim; ?></li>
				<li><span>Google Talk：</span><?php echo $curauth->jabber; ?></li>
			</ul>
		</div>
		<div class="profile-item article">
			<h3>最新文章</h3>
			<?php if(have_posts()) : ?>
			<ul>
				<?php while(have_posts()) : the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>,&nbsp;<?php echo date('M j, Y', get_the_time('U')); ?>&nbsp;in&nbsp;<?php the_category('&');?>
				</li>
				<?php endwhile; ?>
			</ul>
			<div id="pagination" class="clearfix" style="display: none;">
			<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
				<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
				<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
			<?php endif; ?>
			</div>
			<?php else : ?>
			<div class="errorbox"><?php _e('该作者没发表任何文章。', 'inove'); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>