<?php

global $oc_modules;
global $oc_siteinfo;

$t_url = $oc_siteinfo['home'];

// 当前模块
if ( empty($oc_module) ) {
	$oc_module = 'home';
}

// 模块数组
$oc_modules = array(
	'article' => array( 
			'name' => array( 'zh' => '文章', 'en' => 'article' ),
			'alias' => 'atc',
			'desc' => '',
			'url' => $t_url . 'articles/',
			'index' => 0,
			'enabled' => true
		),
	'album' => array( 
			'name' => array( 'zh' => '相册', 'en' => 'album' ),
			'alias' => 'alb',
			'desc' => '',
			'url' => $t_url . 'albums/',
			'index' => 1,
			'enabled' => false
		),
	'bookmark' => array(
			'name' => array( 'zh' => '书签', 'en' => 'bookmark' ),
			'alias' => 'bkm',
			'desc' => '',
			'url' => $t_url . 'bookmarks/',
			'index' => 7,
			'enabled' => false
		),
	'document' => array(
			'name' => array( 'zh' => '文档', 'en' => 'document' ),
			'alias' => 'doc',
			'desc' => '',
			'url' => $t_url . 'docs/',
			'index' => 5,
			'enabled' => false
		),
	'about' => array(
			'name' => array( 'zh' => '关于', 'en' => 'about' ),
			'alias' => 'prf',
			'desc' => '',
			'url' => $t_url . 'about/',
			'index' => 6,
			'enabled' => true
		),
	'otakism' => array(
			'name' => array( 'zh' => '宅生活', 'en' => 'otakism' ),
			'alias' => 'otk',
			'desc' => '',
			'url' => $t_url . 'wota/',
			'index' => 2,
			'enabled' => false
		),
	'works' => array(
			'name' => array( 'zh' => '作品', 'en' => 'works' ),
			'alias' => 'wrk',
			'desc' => '',
			'url' => $t_url . 'works/',
			'index' => 3,
			'enabled' => false
		)
);

unset($t_url);

?>
