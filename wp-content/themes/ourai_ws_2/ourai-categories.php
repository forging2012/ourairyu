<?php
/*
	Template Name: Categories
*/

$ourai_cur_navi = 'categories';
get_header(); if ( have_posts() ) : the_post(); ?>
			<div id="main" class="clr vd">
				<div id="content">
					<div id="breadcrumb"><div class="bc-inner"><span class="title" title="<?php the_title(); ?>"><?php the_title(); ?></span></div></div>
					<ul id="categories">
					<?php wp_list_categories('title_li=0&orderby=name'); ?>
					</ul>
				</div>
			</div>
			<div id="sidebar" class="vd"><?php get_sidebar(); ?></div>
<?php endif; get_footer(); ?>