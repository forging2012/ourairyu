<?php

global $prj_module;
global $oc_project;

if ( is_readable($t_filepath = PRJ_PATH_CNT . $prj_module . '.php') ) {
	global $oc_siteinfo;
	global $oc_res;
	global $oc_module;
	
	global $page_title;
	global $prj_layer_allowed;
	
	// 各页面自行定义 template_layout_pad 函数
	require_once($t_filepath);
	unset($t_filepath);
		
	$oc_siteinfo['title'] = $page_title . ' - 宅男的部屋';
	$oc_siteinfo['keywords'] = '欧雷, 宅男, 部屋, 御宅族, 动漫, 游戏, 音乐, 同人, ACG, vocaloid';
	$oc_siteinfo['desc'] = '记录看过的动漫、玩过的游戏、听过的唱片以及参加过的宅活动';
	$oc_module = 'otakism';
	$t_template = $oc_project->theme_uri( OC_THEME );
	$oc_res['css'] = array(
		$t_template . 'css/global.css',
		$t_template . 'css/main.css',
		$t_template . 'css/otakism.css'
	);
	unset($t_template);
	
	$oc_project->theme_layout( OC_THEME );
}
else {
	require_once( dirname(__FILE__) . '/404.php' );
}

?>
