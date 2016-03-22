<?php
/*
	Template Name: Photos
*/

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once( './common/class/fetch-flickr/FetchFlickr.php' );
	
	$ff = new FetchFlickr;
	$only = "y";
	if ( !empty($_POST['only']) )	$only = $_POST['only'];
	$setinfo = $ff->getPhotosets($only);

	header( 'Content-Type: application/json; charset=UTF-8' );
	echo json_encode($setinfo);
}
else {
	$ourai_cur_navi = 'photos'; get_header(); ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; 全部相片</div>
				</div>
				<ul id="photosets"></ul>
			</div>
<?php get_footer(); } ?>