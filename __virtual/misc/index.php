<?php

/*
$dir_uri = dirname(__FILE__) . '/';

function access_callback() {
	global $dir_uri;
	global $oc_title;
	
	$oc_title = '杂货铺';
	
	require_once( OC_PATH_CMN . 'class/class-file.php' );
	get_global_header();
	
	$cf = new File;
	$files = $cf->traverse($dir_uri);
?>
		<ul><?php
			foreach( $files['files'] as $file ) {
				$info = $cf->info(iconv(mb_detect_encoding($file), 'UTF-8', $dir_uri . '/' . $file));
				
				if ( $info['privacy'] === 'public' ) {
					echo '<li><a href="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $info['name'] . '/">' . $info['title'] . '</a></li>';
				}
			} ?>
		</ul>
<?php	
	get_global_footer();
}

require_once( dirname(dirname(__FILE__)) . '/common/access.php' );
*/

?>
