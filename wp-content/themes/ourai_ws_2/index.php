<?php get_header(); if ( have_posts() ) : ?>
			<div id="main" class="clr vd">
				<div id="content">
					<ul id="articles">
					<?php $counter = 0; while ( have_posts() ) : the_post(); update_post_caches($post); $counter++; ?>
						<li id="article-<?php the_ID(); ?>"<?php if ( $counter == 1 ) { echo ' class="first"'; } elseif ( $counter == get_option( 'posts_per_page' ) ) { echo ' class="last"'; } ?>>
							<div class="article">
								<div class="article-header">
									<h3><a href="<?php the_permalink(); ?>" class="title" title="阅读《<?php the_title(); ?>》"><?php the_title(); ?></a></h3>
									发表于：<span class="date"><?php echo date('Y-m-d H:i:s', get_the_time('U')); ?></span>　分类：<?php count(get_the_category()) > 0 ? the_category(', ') : print('暂未分类'); ?>　标签：<?php count(get_the_tags()) > 0 ? the_tags('', ', ', '') : print('暂无标签'); ?>
								</div>
								<div class="article-body"><?php the_excerpt(); ?></div>
							</div>
						</li>
					<?php endwhile; unset($counter); ?>
					</ul>
					<div id="pagination" class="clr">
					<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
						<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
						<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
					<?php endif; ?>
					</div>
				</div>
			</div>
			<div id="sidebar" class="vd"><?php get_sidebar(); ?></div>
<?php endif; get_footer(); ?>