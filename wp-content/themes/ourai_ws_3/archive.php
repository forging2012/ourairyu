<?php

function template_layout_pad() {
	$is_need_login = false;
	
	// 非超级管理员登录状态时过滤掉禁止浏览目录的文章
	if ( ourai_hide_categories() ) {
		global $query_string;
		global $oc_category_forbidden;
	
		$posts = query_posts($query_string . "&category__not_in=" . implode(',', $oc_category_forbidden));
	}	?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <?php
						echo '<a href="'.site_url('/articles/').'" title="查看全部文章">全部文章</a> &raquo; ';
						if ( is_category() ) {
							$is_need_login = ourai_hide_posts(get_category(get_cat_ID(single_cat_title('', false))));
							
							echo '<a rel="category" href="' . site_url('/categories/') . '" title="查看全部文章分类">全部类别</a>';
							$parentcats = get_ancestors(get_cat_ID(single_cat_title('', false)), 'category');
							if (count($parentcats) > 0) {
								foreach($parentcats as $i) {
									echo ' &raquo; ';
									$cat = get_category($i);
									echo '<a href=\''.get_category_link($i).'\' title=\'查看&nbsp;'.$cat->cat_name.'&nbsp;的全部文章\'>'.$cat->cat_name.'</a>';
								}
							}
							echo ' &raquo; '; unset($parentcats);
							single_cat_title('', true);
						}
						elseif ( is_tag() ) {
							echo '<a rel="tag" href="' . site_url('/tags/') . '" title="查看全部文章标签">全部标签</a> &raquo; ';
							single_tag_title('', true);
						}
						elseif ( is_archive() ) {
							echo '<a href="' . site_url('/archives/') . '" title="查看全部文章存档">全部存档</a> &raquo; ';
							$pd = get_the_time('U');
							if ( is_year() )
								echo date('Y', $pd).'年';
							elseif ( is_month() ) {
								echo '<a href="' . site_url('/archives/'.date('Y', $pd).'/') . '" title="查看 '.date('Y', $pd).'年 的全部文章">'.date('Y', $pd).'年</a> &raquo; ';
								echo date('Y', $pd).'年'.date('m', $pd).'月';
							}
							unset($pd);
						}
					?></div>
					<div id="pagination" class="fr">
					<?php
						if ( !$is_need_login ) {
							if( function_exists('wp_pagenavi') ) {
								wp_pagenavi();
							}
							else { ?>
						<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
						<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
					<?php
							}
						}
					?>
					</div>
				</div>
				<?php
				if ( have_posts() ) {
					if ( $is_need_login ) {
						echo '您所查看内容为非公开内容，请先登录后再来查看，谢谢合作！';
					}
					else {
				?>
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
									<a class="cal-mon fl" href="<?php $calday = date('j', $postdate); $calyear = date('Y', $postdate); echo site_url('/archives/'.$calyear.'/'.date('m', $postdate).'/'); ?>" title="<?php echo '查看 '.$calyear.'年'.date('m', $postdate).'月 的全部文章';?>"><?php echo date('M', $postdate); ?></a>
									<a class="cal-year" href="<?php echo site_url('/archives/'.$calyear.'/'); ?>" title="查看 <?php echo $calyear;?>年 的全部文章"><?php echo $calyear; ?></a>
									<strong class="cal-day"><?php echo $calday; ?></strong>
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
				<?php	
					}
				}
				else {
					echo '<b>恭喜你来到了荒原</b>';
				}	?>
			</div><?php
}

global $oc_module;

$oc_module = is_category() ? 'categories' : (is_date() ? 'date' : 'home');
get_header();
get_footer(); ?>