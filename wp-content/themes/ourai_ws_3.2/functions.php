<?php

/**
 * 增强文章搜索的相关性
 * 
 */
add_filter('posts_orderby_request', 'wpjam_search_orderby_filter');
function wpjam_search_orderby_filter($orderby = ''){
	if( is_search() ) {
		global $wpdb;
		$keyword = $wpdb->prepare($_REQUEST['s'],'');
		return "((CASE WHEN {$wpdb->posts}.post_title LIKE '%{$keyword}%' THEN 2 ELSE 0 END) + (CASE WHEN {$wpdb->posts}.post_content LIKE '%{$keyword}%' THEN 1 ELSE 0 END)) DESC, {$wpdb->posts}.post_modified DESC, {$wpdb->posts}.ID ASC";
	}else{
		return $orderby;
	}
}

/**
 * 相关文章
 *
 * @method	oc_related_posts
 * @param	{Array} posttags
 * @param	{Integer} postid
 * @return	{Array}
 */
function oc_related_posts($posttags = array(), $postid = 0) {
	$result = array();

	if ( is_array($posttags) && count($posttags) > 0 ) {
		$query = array(
			'orderby' => 'rand',
			'posts_per_page' => 10,
			'tag__in' => array(),
			'post__not_in' => array()
		);
		
		foreach( $posttags as $i ) {
			array_push($query['tag__in'], $i->term_id);
		}
		
		if ( is_int($postid) && $postid > 0 ) {
			array_push($query['post__not_in'], $postid);
		}
		
		$result = new WP_Query($query);
		$result = $result->posts;
	}

	return $result;
}

/**
 * 热评文章
 *
 * @method	oc_commented_posts
 * @param	{Integer} postnum
 * @param	{Array} cat_id
 * @return	{Array}
 */
function oc_commented_posts($postnum = 10, $cat_id = 0) {
	if ( (is_string($cat_id) && is_numeric($cat_id)) || (is_int($cat_id) && $cat_id !== 0) ) {
		$cat_id = array( $cat_id );
	}
	else if ( !is_array($cat_id) ) {
		$cat_id = array();
	}

	$child_cat = array();

	foreach( $cat_id as $c ) {
		$t = get_category_children($c);

		if ( $t !== '' ) {
			$t = explode('/', $t);

			array_shift($t);

			$child_cat = array_merge($child_cat, $t);
		}
	}

	$cat_id = array_merge($cat_id, $child_cat);

	$mcposts = get_posts(array(
		'posts_per_page' => -1,
		'numberposts' => $postnum,
		'category__in' => $cat_id,
		'orderby' => 'comment_count'
	));
	
	return $mcposts;
}

/**
 * 最近评论
 *
 * @method	oc_recent_comments
 * @param	{Integer} cmtnum
 * @return	{Array}
 */
function oc_recent_comments($cmtnum = 10) {
	$cmtnum = gettype($cmtnum) == 'integer' ? $cmtnum : gettype($cmtnum) == 'string' ? intval($cmtnum) : 10;
	$rctcomments = get_comments("status=approve&number=$cmtnum&parent=0&type=comment");

	return $rctcomments;
}

/**
 * 截取字符串
 * 
 * @method 	oc_ellipsis
 * @param 	{String} strs
 * @param 	{Integer} limit
 * @return 	{String}
 */
function oc_ellipsis( $strs = '', $limit = 0 ) {
	if ( !is_string($strs) ) {
		$strs = '';
	}

	if ( !is_int($limit) ) {
		$limit = 0;
	}

	$result = $strs;

	if ( $limit !== 0 && mb_strlen($strs) > $limit ) {
		$subex = mb_substr($strs, 0, $limit - 3);

		$result = $subex . '...';
	}

	return $result;
}

/**
 * 不显示在文章列表中的文章类别 HTML
 * 
 * @method 	oc_hide_cats_html
 * @param 	{Integer/Array} $cats
 * @return 	{Array}
 */
function oc_hide_cats_html( $cats = array() ) {
	if ( is_numeric($cats) ) {
		$cats = array($cats);
	}
	else if ( !is_array($cats) ) {
		$cats = array();
	}

	$html = array();

	foreach( $cats as $c ) {
		if ( is_numeric($c) ) {
			$c = get_category($c);

			if ( intval($c->count) > 0 ) {
				$c_name = $c->cat_name;

                array_push($html, ('<a href="' . esc_url(get_category_link($c->cat_ID)) . '" title="查看 ' . $c_name . ' 的全部文章">' . $c_name . '</a>'));
			}
		}
	}

	return $html;
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
 * @method	oc_display_articles
 * @param	{Integer} postsPerPage
 * @return	{Object}
 */
function oc_display_articles( $postsPerPage = 0 ) {
	global $oc_hide_cats;
	
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
	if ( !empty($oc_hide_cats) ) {
		$conditions['category__not_in'] = $oc_hide_cats;
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