<?php
/*
	Template Name: Tags
*/

function template_layout_pad() {
	if ( have_posts() ) : ?>
			<div id="content">
				<div id="toolbar"><div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a> &raquo; 全部标签</div></div>
				<div id="tags"><?php wp_tag_cloud('order=RAND&smallest=8&largest=24');?></div>
			</div>
	<?php endif;
}

global $oc_module;

$oc_module = 'tags';
get_header();
get_footer(); ?>