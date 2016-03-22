<?php
/*
	Template Name: Tags
*/

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span><a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a><span class="separator">&raquo;</span>全部标签<?php
}

function template_layout_main() {
	if ( have_posts() ) : ?>
		<div id="tags"><?php wp_tag_cloud('order=RAND&smallest=8&largest=24');?></div>
	<?php endif;
}

global $oc_module;

$oc_module = 'tags';
get_header();
get_footer(); ?>