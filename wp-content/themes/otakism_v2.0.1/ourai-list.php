<?php
/*
	Template Name: List
*/

// 禁止直接访问该页面
if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
//	get_header();
//	var_dump( is_readable(ABSPATH . 'wp-content/themes/' . get_template() . '/func.php'));
//		$blog = new Blog();
//		$blog->get_list('menu');
//	exit( 'Forbidden!' );

//	get_footer();
}
else {
	if ( !empty($_POST['filter']) ) {
		$blog = new Blog();
		$blog->get_list($_POST['filter']);
	}
}

?>