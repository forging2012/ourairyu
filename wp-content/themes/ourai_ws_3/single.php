<?php

function template_layout_pad() {
	global $oc_project;
	
	$postdate = 0;
	$temp_pass = true;
	
	if ( OC_MOBILE || $oc_project->lowerIE ) {
		$temp_pass = false;
	}
	
	if ( have_posts() ) {
		the_post();
		$postdate = get_the_time('U'); ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a> &raquo; <a rel="category" href="<?php echo site_url('/categories/'); ?>" title="查看全部文章分类">全部类别</a> &raquo; <?php the_category(' &raquo; ', 'multiple'); echo ' &raquo; '; the_title(); ?></div>
					<div id="pagination" class="fr">
					<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
						<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
						<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
					<?php endif; ?>
					</div>
				</div>
				<div class="atc">
					<div class="atc-hd">
						<div class="atc-cal">
							<a class="cal-mon fl" href="<?php $calday = date('j', $postdate); $calyear = date('Y', $postdate); echo site_url('/archives/'.$calyear.'/'.date('m', $postdate).'/'); ?>" title="<?php echo '查看 '.$calyear.'年'.date('m', $postdate).'月 的全部文章';?>"><?php echo date('M', $postdate); ?></a>
							<a class="cal-year" href="<?php echo site_url('/archives/'.$calyear.'/'); ?>" title="查看 <?php echo $calyear;?>年 的全部文章"><?php echo $calyear; ?></a>
							<strong class="cal-day"><?php echo $calday; ?></strong>
						</div>
						<h3><?php the_title(); ?></h3>
						<?php /*count(get_the_category()) > 0 ? the_category(' ') : ''; */count(get_the_tags()) > 0 ? the_tags('', '', '') : ''; ?>
						<input type="hidden" value="<?php echo site_url('/?p='.get_the_ID()); ?>" />
					</div>
					<div class="atc-bd cnt"><?php
						if ( ourai_hide_posts(get_the_category()) ) {
							echo '您所查看内容为非公开内容，请先登录后再来查看，谢谢合作！';
						}
						else {
							the_content();
						}
					?></div>
				</div><?php
				if ( $temp_pass ) {
					comments_template('', true);
				} ?>
			</div>
<?php
	}
	
	unset($postdate);
	unset($calday);
	unset($calyear);
}

get_header();
get_footer(); ?>