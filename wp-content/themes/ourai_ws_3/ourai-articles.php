<?php
/*
	Template Name: Articles
*/

function template_layout_pad() {
	global $posts;
	
	if ( have_posts() ) : ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; 全部文章</div>
					<div id="pagination" class="fr">
					<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
						<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
						<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
					<?php endif; ?>
					</div>
				</div>
				<ul id="articles" class="view view-container view-mode-content">
				<?php
					$counter = 0;
					$postdate = 0;
					
					while ( have_posts() ) :
						the_post();
						update_post_caches($post);
						$counter++;
						$postdate = get_the_time('U'); ?>
					<li id="atc-<?php the_ID(); ?>" class="view-item<?php if ( $counter == 1 ) { echo ' first'; } if ( $counter == count($posts) ) { echo ' last'; } ?>">
						<div class="view-item-content">
							<div class="view-item-header">
								<div class="view-item-cal">
									<a class="cal-mon fl" href="<?php $calday = date('j', $postdate); $calyear = date('Y', $postdate); echo site_url('/archives/'.$calyear.'/'.date('m', $postdate)); ?>" title="<?php echo '查看'.$calyear.'年'.date('m', $postdate).'月的全部文章';?>"><?php echo date('M', $postdate); ?></a>
									<a class="cal-year" href="<?php echo site_url('/archives/'.$calyear.'/'); ?>" title="查看<?php echo $calyear;?>年的全部文章"><?php echo $calyear; ?></a>
									<b class="cal-day"><?php echo $calday; ?></b>
								</div>
								<h3><a href="<?php the_permalink(); ?>" class="title" title="阅读《<?php the_title(); ?>》"><?php the_title(); ?></a></h3>
								<?php count(get_the_tags()) > 0 ? the_tags('', '', '') : ''; ?>
							</div>
							<div class="view-item-body"><?php the_excerpt(); ?></div>
						</div>
					</li><?php
					endwhile;
					
					unset($counter);
					unset($postdate);
					unset($calday);
					unset($calyear); ?>
				</ul>
			</div>
	<?php
	endif;
}

global $oc_module;

$oc_module = 'article';
get_header();
get_footer(); ?>