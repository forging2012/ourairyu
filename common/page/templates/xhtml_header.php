<?php

global $oc_project;
global $oc_siteinfo;
global $oc_res;
global $oc_env;

$temp_cssUri = $oc_project->common . 'css/';
$temp_siteinfo = array(
	'site' => $oc_project->root,
	'blog' => '',
	'title' => '',
	'keywords' => '',
	'desc' => '',
	'lang' => 'zh-CN',
	'charset' => 'UTF-8',
	'author' => array(
		'zh' => '欧雷',
		'en' => 'Ourai Lin'
	)
);
$temp_res = array( 'css' => array(
		$temp_cssUri . 'common.css',
		$temp_cssUri . 'folder.css'
	), 'js' => array() );
$temp_env = array( 'browser' => CLS_Utils::browser(), 'os' => CLS_Utils::OS() );
	
// 合并设置
$oc_siteinfo = mergeSettings($oc_siteinfo, $temp_siteinfo);
$oc_res = mergeSettings($oc_res, $temp_res);
$oc_env = mergeSettings($oc_env, $temp_env);

function mergeSettings( $target = array(), $source = array() ) {
	if ( empty($target) ) {
		$target = array_merge($source, array());
	}
	else {
		foreach( $source as $key => $val ) {
			if ( !array_key_exists($key, $target) ) {
				$target[$key] = $val;
			}
		}
	}
	
	return $target;
}

unset($temp_cssUri);
unset($temp_siteinfo);
unset($temp_res);
unset($temp_env);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $oc_siteinfo['title']; ?></title>
		<link rel="shortcut icon" href="<?php echo $oc_project->common; ?>image/favicon.ico">
		<?php foreach( $oc_res['css'] as $css ) { ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $css; ?>" />
		<?php } ?>
	</head>
	<body>
<?php if ( function_exists('content_callback') ) { content_callback(); } ?>