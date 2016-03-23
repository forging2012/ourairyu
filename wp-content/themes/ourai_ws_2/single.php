<?php get_header(); if ( have_posts() ) : the_post(); ?>
			<div id="main" class="clr vd">
				<div id="content">
					<div id="breadcrumb"><div class="bc-inner"><?php the_category('<span class="spt">&dArr;</span>', 'multiple'); ?><span class="spt">&dArr;</span><span class="title" title="<?php the_title(); ?>"><?php the_title(); ?></span></div></div>
					<div class="article">
						<div class="article-header">
							<h3><?php the_title(); ?></h3>
							发表于：<span class="date"><?php echo date('Y-m-d H:i:s', get_the_time('U')); ?></span>　分类：<?php count(get_the_category()) > 0 ? the_category(', ') : print('暂未分类'); ?>　标签：<?php count(get_the_tags()) > 0 ? the_tags('', ', ', '') : print('暂无标签'); ?>
						</div>
						<div class="article-body"><div class="article-inner lf"><?php the_content(); ?></div></div>
					</div>
				</div>
			</div>
			<div id="sidebar" class="vd"><?php get_sidebar(); ?></div>
<?php endif; get_footer(); ?>