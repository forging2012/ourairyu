<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Ourai.WS
 * @since Ourai.WS 3.2
 */

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php echo bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span><a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a><span class="separator">&raquo;</span>搜索结果<?php get_search_query();
}

function template_layout_main() {
   get_template_part('content');
}

if ( $wp_query->found_posts > 0 ) {

function template_layout_sidebar() {
	global $wp_query; ?>
            <div class="module">
                <p style="margin: 0; padding: 0;"><span style="vertical-align: text-bottom;">共找到 <b style="text-decoration: underline;"><?php echo $wp_query->found_posts; ?></b> 条与</span><b class="larger" style="vertical-align: text-bottom; margin: 0 .3em;"><?php echo $_GET['s']; ?></b><span style="vertical-align: text-bottom;">有关的记录</span></p>
            </div><?php
}

}

global $oc_module;

$oc_module = 'search';

get_header();
get_footer(); ?>