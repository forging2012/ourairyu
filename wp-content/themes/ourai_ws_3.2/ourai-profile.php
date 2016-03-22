<?php
/*
	Template Name: Profile
*/

global $oc_module;

$oc_module = 'about';

$site = site_url('/');
$page = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];

if ( strpos($page, $site) !== false && preg_match('/([a-z]+)\//', substr($page, strlen($site)), $match) ) {
	$oc_module = $match[1];
}

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span><?php the_title(); ?><?php
}

function template_layout_main() {
	global $oc_module;
	global $oc_modules;
	global $oc_siteinfo;
	
	// 引入对应的 HTML
	require_once( get_template_directory() . '/ourai-profile-' . $oc_module . '.php' ); ?>
			<?php
}

get_header();
get_footer(); ?>