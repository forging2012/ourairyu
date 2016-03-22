<?php

function template_variable_filter() {
	global $oc_modules;
	global $oc_siteinfo;
	global $oc_env;
	
	if ( $oc_env['browser']['alias'] === 'IE' ) {
		$oc_modules['album']['enabled'] = false;
	}
//	
//	$t_layers = CLS_Utils::pathname();
//	
//	// 控制台
//	if ( count($t_layers) > 1 && $t_layers[1] === 'console' ) {
//		$oc_modules = array_merge($oc_modules, array(
//			'console' => array(
//				'name' => array( 'zh' => '控制台', 'en' => 'console' ),
//				'alias' => 'csl',
//				'desc' => '',
//				'url' => $oc_siteinfo['site'] . 'wota/console/',
//				'index' => 5,
//				'enabled' => true
//			)
//		));
//	}
//	
//	unset($t_layers);
}

// 检测访问 URI 的合法性
function prj_check_access() {
	global $prj_layer_allowed;
	
	$result = '';
	$layers = CLS_Utils::pathname();
	
	if ( count($layers) > 1 ) {
		array_shift( $layers );
		$result = array_key_exists( $layers[0], $prj_layer_allowed ) ? $layers[0] : false;
	}
	
	return $result;
}

function prj_layout() {
	require_once( PRJ_PATH_CNT . 'layout.php' );
}

function prj_database() {
	require_once( OC_APATH_CLS . 'class-database.php' );
	
	$db = new CLS_Database;
	$db->select_db(PRJ_DB);
	
	return $db;
}

?>