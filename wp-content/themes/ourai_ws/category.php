<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
//	get_header();



//	get_footer();
}
else {
	if ( !empty($_POST['filter']) ) {
		ourai_json(array( 'code' => 1, 'items' => ourai_postsbycat(get_cat_ID(single_cat_title('', false))), 'msg' => '' ));
	}
}
 
?>
