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
			echo '<ul>';
			foreach($result->posts as $i) {
				echo '<li><a href=\''.get_permalink($i->ID).'\' title=\''.get_userdata($i->post_author)->nickname.'&nbsp;发表于&nbsp;'.date('Y-m-d H:i:s', get_the_time(strtotime($i->post_date))).'\' rel=\'bookmark\'>'.$i->post_title.'</a></li>';
			}
			echo '</ul>';
		}
		else {
			echo '<span>没有其他相关文章</span>';
		}
	}
}

/** Most commented posts **/
function ourai_mostcmtedposts($postnum = 10, $showavatar = false) {
	$postnum = gettype($postnum) == 'integer' ? $postnum : gettype($postnum) == 'string' ? intval($postnum) : 10;
	$mcposts = get_posts("numberposts=$postnum&orderby=comment_count");
	
	if(count($mcposts) > 0) {
		echo '<ul>';
		foreach($mcposts as $i) {
			echo '<li';
			if ($showavatar) {
				$userdata = get_userdata($i->post_author);
				echo ' class=\'clr\'><div class=\'img left\'>';
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
		echo '<span>暂时没有任何文章</span>';
	}
}

/** Recent comments **/
function ourai_recentcomments($cmtnum = 10) {
	$cmtnum = gettype($cmtnum) == 'integer' ? $cmtnum : gettype($cmtnum) == 'string' ? intval($cmtnum) : 10;
	$rctcomments = get_comments("status=approve&number=$cmtnum");

	if ($rctcomments > 0) {
		echo '<ul>';
		foreach ($rctcomments as $i) {
			$cmtAuthorUrl = $i->comment_author_url;
			$cmtAuthorAvatar = get_avatar( $i->comment_author_email, 32, '', $i->comment_author);
			
			echo '<li class="clr">';
			echo ($cmtAuthorUrl == '' ? $cmtAuthorAvatar : '<a class="cmt-avt" title="'.$i->comment_author.'" href="'. $cmtAuthorUrl .'" target="_blank">'.$cmtAuthorAvatar.'</a>');
			echo '<a class="cmt-atr" href="'. get_permalink($i->comment_post_ID).'#comment-'.$i->comment_ID .'" title="'.get_the_title($i->comment_post_ID).'">' . $i->comment_author . '</a>';
			echo '<div class="cmt-cnt">'. $i->comment_content .'</div>';
			echo '</li>';
		}
		echo '</ul>';
	}
	else {
		echo '<span>暂时没有任何评论</span>';
	}
}

function ourai_commentlist($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$cmt = $comment; $cmtid = $cmt->comment_ID; ?>
	<li id="comment-<?php echo $cmtid; ?>" class="cmt">
	<?php echo get_avatar($cmt->comment_author_email, 48, '', $cmt->comment_author);?>
		<div class="cmt-cnt">
			<div class="cmt-act">
				<a href="#respond" class="cmt-qot" title="引用<?php echo $cmt->comment_author; ?>的评论内容" rel="nofollow">引用</a>
				<a href="#respond" class="cmt-rpl" title="回复<?php echo $cmt->comment_author; ?>的评论" rel="nofollow">回复</a>
			</div>
		<?php if ( empty($cmt->comment_author_url) ) {
			echo '<span id="reviewer-'.$cmtid.'" class="cmt-atr">'.$cmt->comment_author.'</span>';
		} else {
			echo '<a id="reviewer-'.$cmtid.'" class="cmt-atr" href="'.$cmt->comment_author_url.'" rel="external nofollow" title="浏览'.$cmt->comment_author.'的网站">'.$cmt->comment_author.'</a>';
		} ?>
		| <a href="#comment-<?php echo $cmtid; ?>" rel="nofollow" title="Commented on <?php echo date('Y-m-d H:i:s', get_comment_time('U')); ?>"><?php
			date_default_timezone_set( 'Etc/GMT-8' );
			
			$cmttime = get_comment_time('U');
			$deftime = time() - $cmttime;
			$unit = null;
			$divisor = 0;
			
			if ( $deftime < 60 ) {
				$unit = '秒';
				$divisor = 1;
			}
			elseif ( $deftime < 3600 ) {
				$unit = '分钟';
				$divisor = 60;
			}
			elseif ( $deftime < 3600 * 24 ) {
				$unit = '小时';
				$divisor = 3600;
			}
			elseif ( $deftime < 3600 * 24 * 15 ) {
				$unit = '天';
				$divisor = 3600 * 24;
			}
			
			echo empty($unit) ? date('Y-m-d H:i:s', $cmttime) : floor($deftime/$divisor).$unit.'前';
			unset($cmttime); unset($deftime); unset($unit); unset($divisor);
		?></a>
			<div id="commentbody-<?php echo $cmtid; ?>" class="cmt-bd"><?php echo $cmt->comment_content;?></div>
		</div>
	</li><?php unset($cmt); unset($cmtid);
}

function get_deliciouss() {
	$cache = dirname(__FILE__) . '/caches/delicious';
//	if( filemtime($cache) < (time() - 300) ) {
//		@mkdir(dirname(__FILE__) . '/caches', 0777);
		$url = 'https://api.del.icio.us/v1/tags/get';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// add delicious.com username and password below
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_USERPWD, 'ourailin:19880222genius');
		$data = curl_exec($ch);
		var_dump(curl_error($ch));
		var_dump($data);
		curl_close($ch);
//		$cachefile = fopen($cache, 'wb');
//		fwrite($cachefile, $data);
//		fclose($cachefile);
//	}
//	else
//	{
//		$data = file_get_contents($cache);
//	}
	$xml = simplexml_load_string($data);
 
	$html = '<ul>';
//	foreach($xml as $item)
//	{
//		$html .= '<li><a href="' . $item['href'] . '">' . $item['description'] . '</a> ' . $item['extended'] . '</li>';
//	}
//	$html .= '<li><a href="http://delicious.com/briancray">More of Brian Cray\'s delicious bookmarks&hellip;</a></li>';
//	$html .= '</ul>';
//	echo $html;
}

function get_delicious() {
	$file = './delicious-brownies/DeliciousBrownies.php';
	require_once( $file );
	
	$file = dirname(__FILE__).'/caches';
	if ( !file_exists($file) )	@mkdir( $file, 0777 );
	$file .= '/delicious';
	if ( !file_exists($file) || filemtime($file) < (time() - 1800) ) {
		$re = new DeliciousBrownies;
		$re->setUsername('ourailin');
		$re->setPassword('19880222genius');
		$bkms = $re->getRecentPosts();
		
		$cachefile = fopen( $file, 'wb' );
		fwrite( $cachefile, json_encode($bkms) );
		fclose( $cachefile );
	}
	else {
		$bkms = json_decode(file_get_contents( $file ), true);
	}
	
	return $bkms;
}

function get_delicious_page( $url = '' ) {
	$result = array();
	
	if (!empty($url)) {
		if ( gettype($url) != 'array' )
			$url = (array)$url;
		
		foreach( $url as $u ) {
			array_push( $result, fetch_page($u) );
		}
	}
	
	return $result;
}

function fetch_page( $data = '' ) {
	$result = array( 'title'=>'', 'description'=>'', 'image'=>'' );
	
//	if ( !empty($url) ) {
//		$ch = curl_init();
//		
//		curl_setopt($ch, CURLOPT_URL, $url);
//		curl_setopt($ch, CURLOPT_POST, 0);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//		$data = curl_exec($ch);
//		curl_close($ch);
//		
//		if ( $data ) {
			if ( preg_match( '/<title>(.*)<\/title>/i', $data, $match ) )
				$result['title'] = $match[1];
			
			if ( preg_match_all( '/<img\s+src=.?(.*\.(jpg|gif|png))/i', $data, $match ) )
				$result['image'] = gettype($match[1]) == 'array' ? $match[1][rand(0, count($match[1])-1)] : $match[1];
			
			if ( preg_match_all( '/<p>(.*)\<\/p>/i', $data, $match ) ) {
				$result['description'] = gettype($match[1]) == 'array' ? strip_tags($match[1][rand(0, count($match[1])-1)]) : strip_tags($match[1]);
			}
//		}
//	}
	
	return $result;
}

function multi_fetch_page( $urls = '' ) {
	$result = array();
	
	if (!empty($urls)) {
		$sleep = 0;
		$running = 0;
		
		if ( gettype($urls) != 'array' )
			$urls = (array)$urls;
			
		$mh = curl_multi_init();
		$count = 0;
		$handle = array();
		
		foreach( $urls as $u ) {
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $u);
//			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 7);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//			curl_setopt($ch, CURLOPT_USERPWD, 'ourailin:19880222genius');
			
			curl_multi_add_handle($mh, $ch);
			$handle[$count++] = $ch;
		}
		
		do {
			curl_multi_exec($mh, $running);
			
			if ( $sleep > 0 ) {
				usleep( $sleep );
			}
		} while ( $running > 0 );
		
		foreach( $handle as $i=>$ch ) {
			$content = curl_multi_getcontent($ch);
			$result[$i] = (curl_errno($ch) == 0) ? fetch_page($content) : false;
		}
		
		foreach( $handle as $ch ) {
			curl_multi_remove_handle($mh, $ch);
		}
		
		curl_multi_close($mh);
	}
	
	return $result;
}

/**
 * 获取需要显示的文章
 * 
 * @method	ourai_display_articles
 * @param	{Integer} postsPerPage
 * @return	{Object}
 */
function ourai_display_articles( $postsPerPage = 0 ) {
	global $oc_category_forbidden;
	
	if ( !is_int($postsPerPage) || $postsPerPage === 0 ) {
		$postsPerPage = get_option('posts_per_page');
	}
	
	$categories = array();
	// 文章查询条件
	$conditions = array(
		'paged' => ((get_query_var('paged')) ? get_query_var('paged') : 1),
		'posts_per_page' => $postsPerPage,
		'post_status' => 'publish',
		'post_type' => 'post'
	);
	// 禁止显示的目录
	if ( !empty($oc_category_forbidden) && ourai_hide_categories() ) {
		$conditions['category__not_in'] = $oc_category_forbidden;
	}
	
	return query_posts( $conditions );
}

/**
 * 对文章分类重新排序
 * 
 * @method	ourai_sort_categories
 * @param	{Array} cats	文章分类对象数组
 * @return	{Array}
 */
function ourai_sort_categories( $cats = array() ) {
	global $oc_category_order;
	global $oc_category_private;
	
	
	$result = array();
	$rlt = array();

	// 将文章类别对象转换为数组
	foreach( $cats as $cat ) {
		$c = array( 'id'=>$cat->term_id, 'slug'=>$cat->slug, 'name'=>$cat->name,
					'desc'=>$cat->description, 'count'=>$cat->count, 'url'=>get_category_link($cat->term_id) );
		
		if ( $cat->parent == 0 ) {
			$c_key = 'cat-' . $cat->term_id;
			
			if ( empty($rlt[$c_key]) ) {
				$rlt[$c_key] = array();
			}
			
			$rlt[$c_key] = array_merge( $rlt[$c_key], $c );
		}
		else {
			$c_key = 'cat-' . $cat->parent;
			
			if ( empty($rlt[$c_key]) ) {
				$rlt[$c_key] = array( 'children'=>array() );
			}
		
			if ( !is_array($rlt[$c_key]['children']) ) {
				$rlt[$c_key]['children'] = array();
			}
			
			array_push( $rlt[$c_key]['children'], $c );
		}
	}
	
	$cats = $rlt;
	unset($rlt);
	
//	$cats = removeForbiddenCategories( $cats );
	
	// 排序文章类别
	if ( is_array($oc_category_order) ) {
		$reseted = array();
		$category_keys = array_keys( $cats );
		
		foreach( $oc_category_order as $idx => $val ) {
			$key = 'cat-' . $val;
			$key_idx = array_search($key, $category_keys);
			
			if ( $key_idx !== false ) {
				$reseted[$key] = $cats[$key];
				array_splice( $cats, $key_idx, 1 );
				array_splice( $category_keys, $key_idx, 1 );
			}
		}
		
		$cats = array_merge( $reseted, $cats );
	}
	
	// 将私密的文章类别排后
	if ( !empty($oc_category_private) ) {
		$publics = array();
		$privates = array();
		
		foreach( $cats as $key=>$val ) {
			if ( in_array(intval($val['id']), $oc_category_private) ) {
				$privates[$key] = $val;
			}
			else {
				$publics[$key] = $val;
			}
		}
		
		if ( !empty($publics) ) {
			$result['public'] = array( 'flag'=>'public', 'items'=>$publics );
		}
		
		if ( !empty($privates) ) {
			$result['private'] = array( 'flag'=>'private', 'items'=>$privates );
		}
	}
	else {
		$result['public'] = array( 'flag'=>'public', 'items'=>$cats );
	}
	
	return $result;
}

/**
 * 是否隐藏被禁止显示分类下的文章
 * 
 * @method	ourai_hide_categories
 * @return	{Boolean}
 */
function ourai_hide_categories() {
	return !is_user_logged_in() || !is_super_admin(wp_get_current_user()->data->ID);
}

function ourai_hide_posts( $cats = null ) {
	return !is_user_logged_in() && ourai_is_private_category($cats);
}

function ourai_is_private_category( $cats = null ) {
	global $oc_category_private;
	
	$result = false;
	
	if ( is_array($cats) ) {
		foreach ( $cats as $cat ) {
			$result = ourai_is_private_category( $cat );
			
			if ( $result ) {
				break;
			}
		}
	}
	else if ( is_object($cats) ) {
		if ( in_array(intval($cats->cat_ID), $oc_category_private) ) {
			$result = true;
		}
		else if ( $cats->parent != 0 ) {
			$result = ourai_is_private_category(get_category($cats->parent));
		}
	}
	
	return $result;
}

?>