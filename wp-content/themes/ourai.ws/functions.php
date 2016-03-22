<?php

if ( class_exists("Blog") ) {
	exit( 'Class Blog is already exists!' );
}
else {

class Blog {

public function get_list( $filter = null ) {
	$r = array( 'code' => 0, 'items' => array(), 'msg' => '' );
	$num = get_option( 'posts_per_page' );
	
	if ( !empty( $filter ) ) {
		switch( $filter ) {
			case 'article': 
			case 'all': 
				$r['items'] = $this->get_posts();
				$r['code'] = 1;
				break;
			case 'menu':
				$r['items'] = $this->get_categories();
				$r['code'] = 1;
				break;
//			case 'recent':
//				$r['items'] = ourai_recentposts( $num );
//				$r['code'] = 1;
//				break;
//			case 'popular':
//				$r['items'] = ourai_mostcmtedposts( $num );
//				$r['code'] = 1;
//				break;
//			case 'comment':
//				$r['items'] = ourai_recentcomments();
//				$r['code'] = 1;
//				break;
//			case 'tag':
//				$r['items'] = ourai_tags();
//				$r['code'] = 1;
//				break;
			default:
				$r['msg'] = '未知类型！';
		}
	}
	
	$this->json( $r );
}

private function get_categories() {
	$cats = get_categories();
	$result = array();
	
	foreach( $cats as $cat ) {
		$c = array( 'id'=>$cat->term_id, 'slug'=>$cat->slug, 'name'=>$cat->name,
					'desc'=>$cat->description, 'count'=>$cat->count, 'url'=>get_category_link($cat->term_id) );
		
		if ( $cat->parent == 0 ) {
			if ( empty($result['cat-' . $cat->term_id]) )
				$result['cat-' . $cat->term_id] = array();
			
			$result['cat-' . $cat->term_id] = array_merge( $result['cat-' . $cat->term_id], $c );
		}
		else {
			if ( empty($result['cat-' . $cat->parent]) )
				$result['cat-' . $cat->parent] = array( 'children'=>array() );
			
			array_push( $result['cat-' . $cat->parent]['children'], $c );
		}
	}
	
	return $result;
}

// 获取文章列表（参数为空则返回全部，为数字则返回数字对应分类）
private function get_posts( $cat_id = 0 ) {
	$re = new WP_Query( (empty($cat_id) ? '' : "cat=$cat_id&") . 'posts_per_page=-1&post_status=publish&post_type=post' );
	return $this->filter($re->posts, 'post');
}

// 条目过滤
private function filter( $items = array(), $type = '' ) {
	$result = $filter = array();
	
	switch ( $type ) {
		case 'post':
			$filter = array( 'post_date_gmt', 'post_status', 'post_author', 'post_modified', 'post_parent', 'post_excerpt', 'post_content', 'comment_status', 'ping_status', 'post_password', 'to_ping', 'pinged', 'post_modified_gmt', 'post_content_filtered', 'guid', 'menu_order', 'post_type', 'post_mime_type', 'filter' );
			break;
		case 'comment':
			$filter = array( 'comment_date_gmt' );
			break;
		case 'tag':
			$filter = array( 'taxonomy', 'term_taxonomy_id', 'term_group' );
			break;
	}
	
	foreach( $items as $item ) {
		$temp = array();
		foreach( $item as $key => $value ) {
			if ( !in_array( $key, $filter ) ) {
				$key = explode( '_', $key );
				foreach( $key as $k => $v ) {
					if ( $k > 0 )
						$key[$k] = strtoupper(substr($v, 0, 1)) . substr($v, 1);
				}
				$key = implode('', $key);
				$temp[$key] = $value;

				if ( $type == 'post' ) {
					if ( $key == 'ID' ) {
						$temp['postCats'] = $temp['postTags'] = array();
						$temp['permalink'] = get_permalink( $value );
											
						foreach( wp_get_post_categories( $value ) as $cat ) {
							$cat = get_category( $cat );
							array_push( $temp['postCats'], array(
								'ID' => $cat->term_id,
								'name' => $cat->name,
								'slug' => $cat->slug,
								'url' => get_category_link( $cat->term_id )
							));
							
							foreach( get_ancestors( $cat->term_id, 'category' ) as $a ) {
								$a = get_category( $a );
								
								foreach( $temp['postCats'] as $tt ) {
									if ( $tt['ID'] != $a->term_id ) {
										array_push( $temp['postCats'], array(
											'ID' => $a->term_id,
											'name' => $a->name,
											'slug' => $a->slug,
											'url' => get_category_link( $a->term_id )
										));
									}
								}
							}
						}
						
//						foreach( wp_get_post_tags( $value ) as $tag ) {
//							array_push( $temp['postTags'], array(
//								'ID' => $tag->term_id,
//								'name' => $tag->name,
//								'slug' => $tag->slug,
//								'url' => get_term_link( $tag )
//							));
//						}
					}
					
					if ( $key == 'postAuthor' ) {
						$author = get_userdata( $value );
						$temp[$key] = array( 'name' => $author->display_name, 'email' => $author-> user_email, 'url' => $author->user_url );
					}
				}
			}
		}
		array_push( $result, $temp );
	}

	return $result;
}

// 输出 JSON
private function json( $target = array() ) {
//	header( 'Cache-Control: no-cache, no-store, max-age=0, must-revalidate' );
//	header( 'Expires: -1' );
//	header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
//	header( 'Content-Type: application/json; charset=UTF-8' );
	echo json_encode( $target );
}

}

}

?>