<?php

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	remove_action('wp_head', _admin_bar_bump_cb);
	remove_action('wp_head', wp_admin_bar_header);
	get_header();
	
	if ( have_posts() ) {
		the_post();
		update_post_caches( $posts );

?>
<div id="header">
	<?php echo get_avatar(get_the_author_meta( 'user_email', 1 ), 96, '', '欧雷'); ?>
	<h2><?php the_title(); ?></h2>
	<div class="meta"><?php
		echo '发表于&nbsp;' . date('Y-m-d', get_the_time('U'));
		echo '&nbsp;&nbsp;&nbsp;分类：';	count(get_the_category()) > 0 ? the_category(', ') : print('暂未分类');
		echo '&nbsp;&nbsp;&nbsp;标签：';	count(get_the_tags()) > 0 ? the_tags('', ', ', '') : print('暂无标签');
	?></div>
	<a id="home" href="<?php echo site_url(); ?>" tile="返回到主页"><img src="<?php bloginfo('template_url'); ?>/image/icon-home-16-2.png" title="返回到主页" alt="返回到主页" /></a>
</div>
<div id="content" class="bb"><div class="entry"><?php the_content(); ?></div></div>
<div id="footer"></div>
<?php
	}
	
	get_footer();
}
else {
	$r = array( 'postTags'=>array() );
	$p = wp_get_single_post( get_the_ID(), 'ARRAY_A' );
	
	foreach( $p as $key=>$val ) {
		if ( !in_array($key, array( 'ancestors', 'tags_input', 'post_date_gmt', 'post_status', 'post_author', 'post_name', 'post_parent', 'post_excerpt', 'comment_status', 'ping_status', 'post_password', 'to_ping', 'pinged', 'post_modified_gmt', 'post_content_filtered', 'guid', 'menu_order', 'post_type', 'post_mime_type', 'filter' )) ) {
			$key = explode('_', $key);
			foreach( $key as $i=>$v ) {
				if ( $i>0 )
					$key[$i] = strtoupper(substr($v, 0, 1)) . substr($v, 1);
			}
			$key = implode('', $key);
			
			if ( $key == 'ID' ) {
				foreach( wp_get_post_tags( $val ) as $tag ) {
					array_push( $r['postTags'], array(
						'ID' => $tag->term_id,
						'name' => $tag->name,
						'slug' => $tag->slug,
						'url' => get_term_link( $tag )
					));
				}
			}
			
			if ( $key == 'postCategory' ) {
				$temp = array();
				foreach( $val as $cat ) {
					$cat = get_category( $cat );
					array_push( $temp, array(
						'ID' => $cat->term_id,
						'name' => $cat->name,
						'slug' => $cat->slug,
						'url' => get_category_link( $cat->term_id )
					));
				}
				$val = $temp;
				unset($temp);
			}
			
			if ( $key == 'postAuthor' ) {
				$author = get_userdata( $val );
				$val = array( 'name' => $author->display_name, 'email' => $author-> user_email, 'url' => $author->user_url );
				unset($author);
			}
			
			if ($key != 'ID')
				$r[$key] = $val;
		}
	}
	
	echo json_encode($r);
} ?>