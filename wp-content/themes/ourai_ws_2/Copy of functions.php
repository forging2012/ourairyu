<?php

/* --- List Filter --- */

function ourai_listfilter( $filter = null ) {
	$r = array( 'code' => 0, 'items' => array(), 'msg' => '' );
	$num = get_option( 'posts_per_page' );
	
	if ( !empty( $filter ) ) {
		switch( $filter ) {
			case 'article': 
			case 'all': 
				$r['items'] = ourai_posts();
				$r['code'] = 1;
				break;
			case 'recent':
				$r['items'] = ourai_recentposts( $num );
				$r['code'] = 1;
				break;
			case 'popular':
				$r['items'] = ourai_mostcmtedposts( $num );
				$r['code'] = 1;
				break;
			case 'comment':
				$r['items'] = ourai_recentcomments();
				$r['code'] = 1;
				break;
			case 'tag':
				$r['items'] = ourai_tags();
				$r['code'] = 1;
				break;
			default:
				$r['msg'] = '未知类型！';
		}
	}
	
	ourai_json( $r );
}


function ourai_json( $resutl = array() ) {
//	header( 'Cache-Control: no-cache, no-store, max-age=0, must-revalidate' );
//	header( 'Expires: -1' );
//	header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
	header( 'Content-Type: application/json; charset=UTF-8' );
	echo json_encode( $resutl );
}


/* --- Post Filter --- */

function ourai_postfilter( $posts = array() ) {
	return ourai_filter( $posts, 'post' );
}


/* --- Filter --- */

function ourai_filter( $items = array(), $type = '' ) {
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


//function ourai_postcatinfo( $cat_id = 0, $cats = array() ) {
//	$cat = get_category( $cat_id );
//	$ances = get_ancestors( $cat->term_id, 'category' );
//	
//	array_push( $cats, array(
//		'ID' => $cat->term_id,
//		'name' => $cat->name,
//		'slug' => $cat->slug,
//		'url' => get_category_link( $cat->term_id )
//	));
//	
//	if ( !empty($ances) ) {
//		foreach( $ances as $a ) {
//			ourai_postcatinfo( $a, $cats );
//		}
//	}
//	else {
//		return $cats;
//	}
//}


/* --- Recent Posts --- */

function ourai_recentposts( $postnum = 10, $showavatar = false, $echo = false ) {
	$postnum = is_numeric($postnum) ? intval($postnum) : 10;
	$rctposts = wp_get_recent_posts($postnum);
	
	if(count($rctposts) > 0) {
		if ( $echo == true ) {
			echo '<ul>';
			foreach($rctposts as $i) {
				echo '<li';
				if ($showavatar) {
					$userdata = get_userdata($i['post_author']);
					echo ' class=\'clearfix\'><div class=\'img left\'>';
					echo '<a title=\'' . $userdata->nickname . '\' href=\''.get_author_posts_url($userdata->ID).'\'>';
					echo get_avatar($userdata->user_email, 32);
					echo '</a></div>';
					echo '<div class=\'txt left\'>';
					echo '<a href="'. get_permalink($i['ID']) .'" title="'.$i['post_title'].'">'.$i['post_title'].'</a>';
					echo '<span>Posted on '. date('M j, Y', get_the_time(strtotime($i['post_date']))) .'</span>';
					echo '</div>';
				}
				else {
					echo '><a href="'. get_permalink($i['ID']) .'" title="'.$i['post_title'].'">'.$i['post_title'].'</a>';
				}
				echo '</li>';
			}
			echo '</ul>';
		}
		else {
			return ourai_postfilter( $rctposts );
		}
	}
//	else {
//		echo '<span>暂时没有任何文章</span>';
//	}
}


/* --- Most Commented Posts --- */

function ourai_mostcmtedposts( $postnum = 10, $showavatar = false, $echo = false ) {
	$postnum = gettype($postnum) == 'integer' ? $postnum : gettype($postnum) == 'string' ? intval($postnum) : 10;
	$mcposts = get_posts("numberposts=$postnum&orderby=comment_count");
	
	if(count($mcposts) > 0) {
		if ( $echo == true ) {
			echo '<ul>';
			foreach($mcposts as $i) {
				echo '<li';
				if ($showavatar) {
					$userdata = get_userdata($i->post_author);
					echo ' class=\'clearfix\'><div class=\'img left\'>';
					echo '<a title=\'' . $userdata->nickname . '\' href=\''.get_author_posts_url($userdata->ID).'\'>';
					echo get_avatar($userdata->user_email, 32);
					echo '</a></div>';
					echo '<div class=\'txt left\'>';
					echo '<a href="'. get_permalink($i->ID) .'" title="'.$i->post_title.'">'.$i->post_title.'</a>';
					echo '<span>Posted on '. date('M j, Y', get_the_time(strtotime($i->post_date))) .'</span>';
					echo '</div>';
				}
				else {
					echo '><a href="'. get_permalink($i->ID) .'" title="'.$i->post_title.'">'.$i->post_title.'</a>';
				}
				echo '</li>';
			}
			echo '</ul>';
		}
		else {
			return ourai_postfilter( $mcposts );
		}
	}
//	else {
//		echo '<span>暂时没有任何文章</span>';
//	}
}


/* --- Recent Comments --- */

function ourai_recentcomments( $cmtnum = 10, $echo = false ) {
	$cmtnum = gettype($cmtnum) == 'integer' ? $cmtnum : gettype($cmtnum) == 'string' ? intval($cmtnum) : 10;
	$rctcomments = get_comments("status=approve&number=$cmtnum");

	if ($rctcomments > 0) {
		if ( $echo == true ) {
			echo '<ul>';
			foreach ($rctcomments as $i) {
				$cmtAuthorUrl = $i->comment_author_url;
				
				echo '<li class=\'clearfix\'>';
				echo '<div class=\'img left\'>';
				if ($cmtAuthorUrl == '') {
					echo '<span title=\''.$i->comment_author.'\'>'.get_avatar( $i->comment_author_email, 32).'</span>';
				}
				else {
					echo '<a title=\''.$i->comment_author.'\' href=\''. $cmtAuthorUrl .'\' target=\'_blank\'>'.get_avatar( $i->comment_author_email, 32).'</a>';
				}
				echo '</div>';
				echo '<div class=\'txt left\'>';
				echo '<a href="'. get_permalink($i->comment_post_ID).'#comment-'.$i->comment_ID .'" title="'.get_the_title($i->comment_post_ID).'">';
				echo $i->comment_author;
				echo '</a><span>'. $i->comment_content .'</span>';
				echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
		}
		else {
			return ourai_filter( $rctcomments, 'comment' );
		}
	}
//	else {
//		echo '<span>暂时没有任何评论</span>';
//	}
}


/* --- Related Posts --- */

function ourai_relatedposts($posttags = '', $postid = 0) {
	if(gettype($posttags) == 'array' && count($posttags) > 0) {
		$query = array(
			'orderby' => 'rand',
			'posts_per_page' => 10,
			'tag__in' => array(),
			'post__not_in' => array()
		);
		
		foreach($posttags as $i){
			array_push($query['tag__in'], $i->term_id);
		}
		
		if($postid > 0) {
			array_push($query['post__not_in'], $postid);
		}
		
		$result = new WP_Query($query);
		if(count($result->posts) > 0) {
			echo '<ul class=\'clearfix\'>';
			foreach($result->posts as $i) {
				echo '<li><a href=\''.get_permalink($i->ID).'\' title=\''.get_userdata($i->post_author)->nickname.'&nbsp;posted&nbsp;on&nbsp;'.date('M j, Y', get_the_time(strtotime($i->post_date))).'\' rel=\'bookmark\'>'.$i->post_title.'</a></li>';
			}
			echo '</ul>';
		}
		else {
			echo '<span>没有其他相关文章</span>';
		}
	}
}



function ourai_posts() {
	$re = new WP_Query( "posts_per_page=-1&post_status=publish&post_type=post" );
	return ourai_postfilter( $re->posts, 'post' );
}



/* --- Tags --- */

function ourai_tags() {
	return ourai_filter( get_tags(), 'tag' );
}



function ourai_postsbycat( $cat_id = 0 ) {
	$re = new WP_Query( "cat=$cat_id&posts_per_page=-1&post_status=publish&post_type=post" );
	return ourai_postfilter($re->posts, 'post');
}


function ourai_categories() {
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
	
	ourai_createcatlist($result);
}

function ourai_createcatlist( $data = array() ) {
	foreach( $data as $c ) {
		echo '<li class="cat-item cat-item-'.$c['id'].(empty($c['children']) ? '' : ' has-children').'">';
		echo '<a href="'.$c['url'].'" title="'.(empty($c['desc']) ? ('查看 '.$c['name'].' 下的所有文章') : $c['desc']).'" blog-role="selector" blog-filter="article" blog-category="'.$c['slug'].'">'.$c['name'].'</a>';
		echo ' <span>('.($c['count'] + (empty($c['children']) ? 0 : count($c['children']))).')</span>';
		if ( !empty($c['children']) ) {
			echo '<ul class="children bb clr">';
			echo '<b class="tri tri-t">所属分类</b>';
			ourai_createcatlist( $c['children'] );
			echo '</ul>';
		}
		echo '</li>';
	}
}


/** Status **/
//function ourai_status() {
//	echo '<ul>';
//	echo '<li>文章总数：&nbsp;'.count(get_posts('numberposts=-1')).'篇</li>';
//	echo '<li>评论总数：&nbsp;'.count(get_comments()).'次</li>';
//	echo '<li>用户总数：&nbsp;'.count(get_users()).'个</li>';
//	echo '<li>网站运行：&nbsp;'.floor((time() - strtotime('2009-05-01'))/86400).'天</li>';
//	echo '<li>最后更新：&nbsp;'.date('Y年m月d日', strtotime(get_lastpostmodified('blog'))).'</li>';
//	if(is_user_logged_in()) {
//		echo '<li>加载时间：&nbsp;'.timer_stop(0,3).'</li>';
//		echo '<li>查询次数：&nbsp;'.get_num_queries().'</li>';
//	}
//	echo '</ul>';
//}

?>