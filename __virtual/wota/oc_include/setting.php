<?php

global $oc_project;
global $prj_layer_allowed;

$prj_layer_allowed = array(
	'anime'	=> array(
			'name' => array( 'zh' => '动画记录', 'en' => 'anime' )
		)/*,
	'event' => array(
			'name' => array( 'zh' => '活动记录', 'en' => 'event' )
		)*/
);

define( 'PRJ_PATH_ROOT', dirname(dirname(__FILE__)) . '/' );
define( 'PRJ_PATH_INC', PRJ_PATH_ROOT . 'oc_include/' );
define( 'PRJ_PATH_CNT', PRJ_PATH_ROOT . 'oc_content/' );

define( 'PRJ_NAME', '宅生活' );
define( 'PRJ_DB', ($oc_project->debug ? 'wota' : 'ourai_wota') );

?>