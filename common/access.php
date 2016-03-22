<?php

require_once( OC_APATH_CMN . 'function.php' );

global $dir_uri;
global $oc_siteinfo;
global $oc_res;
global $oc_project;

$layers = CLS_Utils::pathname();

if ( empty($_SERVER['OC_SUBDOMAIN']) ) {
	array_shift($layers);
}
	
if ( !empty($layers) && !empty($dir_uri) ) {
	$counter = 0;
	
	if ( $layers[count($layers)-1] === '' ) {
		array_pop($layers);
	}
	
	foreach( $layers as $lay ) {
		$uri = $dir_uri . $lay;
		$counter++;
		
		if ( count($layers) === $counter ) {
			if ( is_file( $uri . '.php' ) ) {
				require_once( $uri . '.php' );
				break;
			}
			else if ( is_dir( $uri ) && is_file( $uri . '/index.php' ) ) {
				require_once( $uri . '/index.php' );
				if ( function_exists('access_callback') ) {
					access_callback();
				}
				break;
			}
		}
		
		if ( !file_exists($uri) ) {
			die('你来到了一个不毛之地！');
		}
		
		$dir_uri = $uri . '/';
	}
}
else {
	if ( function_exists('access_callback') ) {
		access_callback();
	}
}

?>