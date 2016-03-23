<?php
/*
	Template Name: List
*/

// 禁止直接访问该页面
if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	header( 'Location: ' . get_site_url() . '/404' );
}
else {
	if ( !empty($_POST['filter']) ) {
		$blog = new Blog();
		$blog->get_list($_POST['filter']);
	}
}

?>