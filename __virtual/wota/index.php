<?php

// 共通文件
require_once( OC_APATH_CMN . 'function.php' );

// 项目文件
require_once( dirname(__FILE__) . '/oc_include/setting.php' );
require_once( PRJ_PATH_INC . 'function.php' );
require_once( PRJ_PATH_INC . 'access.php' );

global $prj_module;

if ( ($t_dirname = prj_check_access()) !== false ) {
	$prj_module = !$t_dirname ? 'home' : $t_dirname;
	prj_layout();
	unset($t_dirname);
}
else {
	require_once( PRJ_PATH_CNT . '404.php' );
}

?>