<?php
if(get_option('smc_weibo_options')==''){
	add_action('admin_notices', 'smc_warning');
	function smc_warning(){
		echo '<div class="error"><p>请到<a href="'.smc_menu_page_url('smc_bind_weibo_option',false).'">Social Medias Connect</a>更新插件设置</p></div>';
	}
}
add_action('init', 'smc_init');
function smc_init(){
	if (session_id() == "") {
		session_start();
	}
	if(!is_user_logged_in()) {
        if(isset($_GET['oauth_token'])){
			$weibo=$_SESSION["smc_weibo"];
			if(!$weibo){
				wp_die('您的主机配置不正确，请联系您的主机上将php.ini中的session.use_trans_sid一项设置为session.use_trans_sid=1');
			}
			switch($weibo){
				case 'sinaweibo':
						include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
						smc_user_register(smc_sina_verify_credentials());
						break;
				case 'qqweibo':
						include dirname(__FILE__).'/qqweibo/qqOAuth.php';
						smc_user_register(smc_qq_verify_credentials());
						break;
				case 'douban':
						include dirname(__FILE__).'/douban/doubanOAuth.php';
						smc_user_register(smc_douban_verify_credentials());
						break;
				case 'sohuweibo':
						include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
						smc_user_register(smc_sohu_verify_credentials());
						break;
				case '163weibo':
						include dirname(__FILE__).'/163weibo/163OAuth.php';
						smc_user_register(smc_163_verify_credentials());
						break;
				case 'twitter':
						include dirname(__FILE__).'/twitter/twitterOAuth.php';
						smc_user_register(smc_twitter_verify_credentials());
						break;
				case 'fanfou':
						include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
						smc_user_register(smc_fanfou_verify_credentials());
						break;
				case 'follow5':
						include dirname(__FILE__).'/follow5/follow5Auth.php';
						smc_user_register(smc_follow5_verify_credentials());
						break;
				case 'zuosa':
						include dirname(__FILE__).'/zuosa/zuosaAuth.php';
						smc_user_register(smc_zuosa_verify_credentials());
						break;
				case 'wbto':
						include dirname(__FILE__).'/wbto/wbtoAuth.php';
						smc_user_register(smc_wbto_verify_credentials());
						break;
				default:break;
			}
        }
		if($_GET['action']==='smcregister'){
			$r=$_SESSION['smc_temp_userdata'];
			if($_GET['username']){
				$r['user_login']=$_GET['username'];
				smc_user_register($r);
			}else{
				wp_die('注册信息不符合，请重试!');
			}
		}
    }
	$smc_opt=get_option('smc_weibo_options');
	if($smc_opt['smc_auto_connect']){
		add_action('comment_form', 'smc_connect');
		add_action("login_form", "smc_connect");
		add_action("comment_form_must_log_in_after", "smc_connect");
	}
}

add_action("wp_head", "smc_wp_head");
add_action("admin_head", "smc_wp_head");
add_action("admin_head", "smc_admin_header");
add_action("login_head", "smc_wp_head");
function smc_wp_head(){
	$weiboopt=get_option('smc_weibo_options');
    echo '<!-- Social Medias Connect '.SMC_VERSION.' by qiqiboy support SINA weibo, Tencent weibo, SOHU weibo, Douban, Twitter...connection with WordPress -->';
	if(is_user_logged_in()) {
        if(isset($_GET['oauth_token']) && $_GET['oauth_token'] !== $_SESSION["smc_weibo"]){
			echo '<script type="text/javascript">window.opener.smc_reload("");window.close();</script>';
		}
	}
	echo '<script type="text/javascript" src="'.(WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__))).'/js/social-medias-connect.js"></script>';
	smc_wp_css();
	echo '<!-- End Social Medias Connect '.SMC_VERSION.' -->';
}
function smc_admin_header(){
	wp_enqueue_script('jquery');
	echo '<script type="text/javascript" src="'.(WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__))).'/js/social-medias-connect-admin.js"></script>';
}
function smc_wp_css(){
	echo '<link rel="stylesheet" media="all" href="'.(WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__))).'/style.css" type="text/css" />';
}
$smc_loaded=0;
function smc_connect($args=""){
	$weiboopt=get_option('smc_weibo_options');
	global $smc_loaded;
	$defaults=array(
		"admin"=>"",
		"callback_url"=>"",
		"weibos"=>array(),
		"comment"=>0,
		"tips"=>1
	);
	$r = wp_parse_args( $args, $defaults );
	extract( $r );

	if(is_user_logged_in()){
		global $user_ID;
		$smcdata = get_user_meta($user_ID, 'smcdata',true);
		$weibotok=get_option('weibo_access_token');
		if($r['comment']){
			$user = wp_get_current_user();
			$display_name=$user->display_name;
			$_weibo=$smcdata['smcweibo']?$smcdata['smcweibo']:'noweibo';
	?>	<p><?php printf('您已经以 <a class="smc_user_login smc_%1s" href="%2$s"><b>%3$s</b></a> 登录。', $_weibo, get_option('siteurl') . '/wp-admin/profile.php', $display_name); ?> <a href="<?php if(is_front_page()||is_home()||is_archive())echo wp_logout_url(get_option('home'));else echo wp_logout_url(get_permalink()); ?>" title="退出登录">退出</a></p>
	<?php
		}elseif(($weibo=$smcdata['smcweibo'])&&is_singular()){
			$weibo=smc_get_weibo_name($weibo);
?>		<p id="smc_sync" class="smc_button smc_<?php echo $smcdata['smcweibo']; ?>"><input name="post_to_socialmedias" type="checkbox"<?php if(!($_COOKIE['post_to_socialmedias_' . COOKIEHASH] === 'no')) echo ' checked="checked"'; ?> id="post_to_socialmedias" value="1"  /><label for="post_to_socialmedias">同步到<?php echo $weibo; ?></label></p>
<?php	return;
		}
		if(!$r['admin'])return;
	}else{
		$allows=get_option('smc_allowed_weibo');
	}
	$smc_url = WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__));
	$callback=$r['callback_url']?"&callback_url=".urlencode($r['callback_url']):"";
?>
	<script type="text/javascript">
    window.smc_reload=function(url){
       if(!url)url=window.location.href.replace(/#.*|&delete.*/i,'')+'#smc_sync';
       window.location.href = url;
       setTimeout(function(){location.reload()},1300);
    }
	<?php if(!is_user_logged_in()&&(empty($weiboopt)||$weiboopt['smc_auto_js'])){ ?>
			if(window.smcJS){
				if(window.jQuery)jQuery(document).ready(function(){
					smcJS.smc("<?php echo addslashes(preg_replace("/[\n\s\t\r]+/",'',$weiboopt['smc_weibo_notice'])); ?>",<?php echo $smc_loaded; ?>);
				});
				else smcJS.documentReady(function(){
					smcJS.smc("<?php echo addslashes(preg_replace("/[\n\s\t\r]+/",'',$weiboopt['smc_weibo_notice'])); ?>",<?php echo $smc_loaded; ?>);
				});
			}
	<?php } ?>
    </script>
	<?php if($r['tips']&&$weiboopt['smc_weibotips']): ?>
	<p id="smc_connect_tips"><?php echo $weiboopt['smc_weibotips']; ?></p>
	<?php endif; ?>
	<ul id="smc_connect_area<?php if($smc_loaded)echo '_'.$smc_loaded; ?>" class="smc_connect_area smc_button"<?php if(!is_user_logged_in()&&(empty($weiboopt)||$weiboopt['smc_auto_js']))echo ' style="display:none;"'; ?>>
		<?php if((isset($weibotok)&&!$weibotok['sinaweibo'])||(isset($allows)&&(empty($allows)||$allows['sinaweibo']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=sinaweibo<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/sina_button.png" alt="使用新浪微博登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['qqweibo'])||(isset($allows)&&(empty($allows)||$allows['qqweibo']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=qqweibo<?php echo $callback; ?>", "","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/qq_button.png" alt="使用腾讯微博登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['sohuweibo'])||(isset($allows)&&(empty($allows)||$allows['sohuweibo']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=sohuweibo<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/sohu_button.png" alt="使用搜狐微博登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['163weibo'])||(isset($allows)&&(empty($allows)||$allows['163weibo']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=163weibo<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/163_button.png" alt="使用网易微博登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['douban'])||(isset($allows)&&(empty($allows)||$allows['douban']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=douban<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/douban_button.png" alt="使用豆瓣账号登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['twitter'])||(isset($allows)&&(empty($allows)||$allows['twitter']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=twitter<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/twitter_button.png" alt="Login with Twitter" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['fanfou'])||(isset($allows)&&(empty($allows)||$allows['fanfou']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=fanfou<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/fanfou_button.png" alt="使用饭否登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['follow5'])||(isset($allows)&&(empty($allows)||$allows['follow5']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=follow5<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/follow5_button.png" alt="使用Follow5登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['zuosa'])||(isset($allows)&&(empty($allows)||$allows['zuosa']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=zuosa<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/zuosa_button.png" alt="使用做啥账号登陆" /></li><?php endif; ?>
		<?php if((isset($weibotok)&&!$weibotok['wbto'])||(isset($allows)&&(empty($allows)||$allows['wbto']))): ?><li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=wbto<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/wbto_button.png" alt="使用微博通登陆" /></li><?php endif; ?>
		<?php if(!is_user_logged_in()&&!empty($weiboopt)&&!$weiboopt['smc_auto_js']): ?><li><a href="http://www.qiqiboy.com/plugins/social-medias-connect/" rel="bookmark">我也想要使用此服务</a></li><?php endif; ?>
	</ul>
	<?php if(!is_user_logged_in()&&(empty($weiboopt)||$weiboopt['smc_auto_js'])): ?>
		<a id="smc_weibo_start<?php if($smc_loaded)echo '_'.$smc_loaded; ?>" class="smc_weibo_start smc_btn_<?php echo $weiboopt['smc_btn_img']; ?>" title="绑定账号登陆" rel="nofollow" href="javascript:void(0);"></a>
	<?php endif; ?>
<?php
    $smc_loaded = mt_rand(1,999999999);
}

add_filter("get_avatar", "smc_get_avatar",10,4);
function smc_get_avatar($avatar, $id_or_email='',$size='32') { 
	if ( is_object($id_or_email) ) {
		if ( !empty($id_or_email->user_id) ) {
			$user_id = (int) $id_or_email->user_id;
		}
	} else if( is_numeric($id_or_email) ){
		$user_id = (int)$id_or_email;
	} else {
		$user = get_user_by('email', $id_or_email);
		$user_id = (int) $user->ID;
	}

	if($user_id && ($smcdata = get_usermeta($user_id, 'smcdata'))){
		if($smcdata['smcid']){
			$weibo=$smcdata['smcweibo'];
			switch($weibo){
				case 'sinaweibo':
						$out = 'http://tp3.sinaimg.cn/'.$smcdata['smcid'].'/50/1.jpg';
						break;
				case 'qqweibo':
						$out = 'http://app.qlogo.cn/mbloghead/'.$smcdata['smcid'].'/100';
						break;
				case 'douban':
						$out = 'http://img3.douban.com/icon/u'.$smcdata['smcid'].'.jpg';
						break;
				case 'sohuweibo':
						$out = $smcdata['smcid'];
						break;
				case '163weibo':
						$out = $smcdata['smcid'];
						break;
				default:return $avatar;
			}
		}else $out=$smcdata['avatar'];
		if(!$out)return $avatar;
		$avatar = "<img alt='' src='{$out}' class='avatar avatar-{$size}' height='{$size}' width='{$size}' />";
		return $avatar;
	}else {
		return $avatar;
	}
}
if(!function_exists('smc_user_register')){

function smc_user_register($r) {
	if(!(is_array($r)||$r['user_login'])){
		wp_die("An error occurred.");
	}
	if(!($wpuid=smc_get_user_by_meta('smc_weibo_bind',$r['weibo'].'|'.$r['user_login']))){
		if(!$r['user_email']){
			$r['user_email']=$r['user_login'].'@'.$r['emailendfix'];
		}
		$userdata = array(
			'user_pass' => wp_generate_password(),
			'user_login' => $r['user_login'],
			'display_name' => $r['display_name'],
			'user_url' => $r['user_url'],
			'user_email' => $r['user_email']
		);
		if(!is_email($userdata['user_email']))wp_die("Not an email! An error occurred. Please retry!");
		if(!function_exists('wp_insert_user')){
			include_once( ABSPATH . WPINC . '/registration.php' );
			include_once( ABSPATH . WPINC . '/user.php' );
		}
		$wpuid=smc_get_user_by_meta('smc_weibo_email_bind',$userdata['user_email']);
		if(!$wpuid)$wpuid = email_exists($userdata['user_email']);
		if(!$wpuid){
			if(validate_username($userdata['user_login'])){
				if($exists_wpuid=username_exists($userdata['user_login'])){
					$exists_email='***'.substr(get_user_option('user_email', $exists_wpuid),3);$_SESSION['smc_temp_userdata']=$r;
					wp_die('对不起，该账号('.$userdata['user_login'].')已经被<strong>'.$exists_email.'</strong>注册！<br/><br/>
						你现在可以<a href="javascript:window.close();">点此</a>关闭窗口，换个微博账号重新连接注册；或者<a href="javascript:window.opener.smc_reload(\''.site_url('wp-login.php?action=lostpassword', 'login').'\');window.close();">点击这里</a>用上面的邮箱找回密码。<br/><br/>
						如果你未使用<strong>'.$userdata['user_login'].'</strong>在本站注册，而又坚持使用此微博账号登陆，那么请<a href="javascript:document.getElementById(\'smc_new_user_name\').style.display=\'block\';">点此</a>输入一个新的用户名(仅能使用包含数字、字母、下划线等半角字符)。
						<div id="smc_new_user_name" style="display:none"><input id="smc_new_user_name_input" type="text" style="width:200px;height:18px;line-height:18px;"/> <a href="javascript:if(window.opener){window.opener.location.href=(window.opener.location.href.replace(/[?#].*/,\'\')+\'?action=smcregister&username=\'+document.getElementById(\'smc_new_user_name_input\').value);window.close();}else{window.location.href=(window.location.href.replace(/[?#].*/,\'\')+\'?action=smcregister&username=\'+document.getElementById(\'smc_new_user_name_input\').value);};">提交</a></div>
					','对不起，该账号已经被注册！');
				}else{
					$wpuid=smc_insert_new_user($userdata,$r);
				}
			}else{
				wp_die('对不起，用户名(<strong>'.$userdata['user_login'].'</strong>)不符合注册规范。<br/><br/>
						请<a href="javascript:document.getElementById(\'smc_new_user_name\').style.display=\'block\';">点此</a>输入一个新的用户名(仅能使用包含数字、字母、下划线等半角字符)。
						<div id="smc_new_user_name" style="display:none"><input id="smc_new_user_name_input" type="text" style="width:200px;height:18px;line-height:18px;"/> <a href="javascript:if(window.opener){window.opener.location.href=(window.opener.location.href.replace(/[?#].*/,\'\')+\'?action=smcregister&username=\'+document.getElementById(\'smc_new_user_name_input\').value);window.close();}else{window.location.href=(window.location.href.replace(/[?#].*/,\'\')+\'?action=smcregister&username=\'+document.getElementById(\'smc_new_user_name_input\').value);};">提交</a></div>
					','对不起，用户名填写不正确！');
			}
		}else{
			smc_update_smcdata($wpuid,$r);
		}
	}else{
		smc_update_smcdata($wpuid,$r);
	}
	
	if($wpuid) {
		$weiboopt = get_option('smc_weibo_options');
		$remember = (boolean)$weiboopt['smc_auto_remember']; 
		wp_set_auth_cookie($wpuid, $remember, false);
		wp_set_current_user($wpuid);
	}
}

function smc_insert_new_user($userdata,$r){
	$wpuid = wp_insert_user($userdata);
	if($wpuid){
		smc_new_user_email($userdata,$r['weibo']);
		smc_update_smcdata($wpuid,$r);
		return $wpuid;
	}else{
		wp_die('注册失败，请关闭窗口重试。', '注册失败');
	}
}

function smc_update_smcdata($wpuid,$r){
	$weibotok=get_option('weibo_access_token');
	$weibo=$r['weibo']?$r['weibo']:$_SESSION["smc_weibo"];
	if($weibo == 'fanfou' && $weibotok && $weibotok[$weibo]['account'] === $r['user_login']){
		$weibotok[$weibo]['oauth_token'] = $r['oauth_access_token'];
		$weibotok[$weibo]['oauth_token_secret'] = $r['oauth_access_token_secret'];
		update_option('weibo_access_token',$weibotok);
	}
	$smc_array = array (
		"avatar" => $r['profile_image_url'],
		"smcweibo" => $weibo,
		"username" => $r['user_login'],
		"oauth_access_token" => $r['oauth_access_token'],
		"oauth_access_token_secret" => $r['oauth_access_token_secret']
	);
	update_usermeta($wpuid, 'smcdata', $smc_array);
	update_usermeta($wpuid, 'smc_weibo_email_bind', $r['user_email']);
}

}
function smc_get_user_by_meta($meta_key, $meta_value) {
  global $wpdb;
  $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
  return $wpdb->get_var($wpdb->prepare($sql, $meta_key, $meta_value));
}

if(!function_exists('connect_login_form_login')){
	add_action("login_form_login", "connect_login_form_login");
	add_action("login_form_register", "connect_login_form_login");
	function connect_login_form_login(){
		if(is_user_logged_in()){
			$redirect_to = admin_url('profile.php');
			wp_safe_redirect($redirect_to);
		}
	}
}

add_action('admin_menu', 'smc_options_add_page');
function smc_options_add_page() {
	add_menu_page('社交媒体连接(Social Medias Connect)设置','社交媒体连接','administrator',__FILE__,'smc_bind_weibo_sync_posts');
	add_submenu_page(__FILE__, '文章同步微博绑定', '绑定微博同步文章', 'administrator', __FILE__, 'smc_bind_weibo_sync_posts');
	add_submenu_page(__FILE__, '文章同步设置', '社交媒体连接设置', 'administrator', 'smc_bind_weibo_option', 'smc_bind_weibo_option');
	if(!get_usermeta(get_current_user_id(), 'smcdata')||get_usermeta(get_current_user_id(), 'smc_weibo_bind')){
		add_submenu_page(__FILE__, '绑定微博到现有账号', '绑定微博到此账户', 0, 'smc_bind_weibo_acount', 'smc_bind_weibo_acount');
	}
	add_submenu_page(__FILE__, '帮助信息', '帮助', 0, 'smc_bind_weibo_help', 'smc_bind_weibo_help');
	add_submenu_page(__FILE__, '卸载插件', '卸载插件', 'administrator', 'smc_bind_weibo_uninstall', 'smc_bind_weibo_uninstall');
}
function smc_menu_page_url($pagename, $flag=false){
	return site_url('/wp-admin/admin.php?page='.$pagename);
}
function smc_bind_weibo_sync_posts(){
	if(isset($_GET['delete_all'])){
		delete_option('weibo_access_token');
		$info='你已经删除了所有绑定！';
	}elseif(isset($_GET['delete'])) {
		$weibotok=get_option('weibo_access_token');
		$weibo=trim($_GET['delete']);
		unset($weibotok[$weibo]);
		update_option('weibo_access_token',$weibotok);
		$info='你已经删除了'.$_GET['weiboname'].'的绑定！';
	}elseif(isset($_GET['oauth_token'])){
		switch($_SESSION["smc_weibo"]){
			case 'sinaweibo':
					include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
					$tok = smc_sina_getAccessToken($_REQUEST['oauth_verifier'],$_GET['oauth_token'],$_SESSION['smc_oauth_token_secret']);
					break;
			case 'qqweibo':
					include dirname(__FILE__).'/qqweibo/qqOAuth.php';
					$tok = smc_qq_getAccessToken($_REQUEST['oauth_verifier'],$_GET['oauth_token'],$_SESSION['smc_oauth_token_secret']);
					break;
			case 'douban':
					include dirname(__FILE__).'/douban/doubanOAuth.php';
					$tok = smc_douban_getAccessToken($_REQUEST['oauth_verifier'],$_GET['oauth_token'],$_SESSION['smc_oauth_token_secret']);
					break;
			case 'sohuweibo':
					include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
					$tok = smc_sohu_getAccessToken($_REQUEST['oauth_verifier'],$_GET['oauth_token'],$_SESSION['smc_oauth_token_secret']);
					break;
			case '163weibo':
					include dirname(__FILE__).'/163weibo/163OAuth.php';
					$tok = smc_163_getAccessToken($_REQUEST['oauth_verifier'],$_GET['oauth_token'],$_SESSION['smc_oauth_token_secret']);
					break;
			case 'twitter':
					include dirname(__FILE__).'/twitter/twitterOAuth.php';
					$tok = smc_twitter_getAccessToken($_REQUEST['oauth_verifier'],$_GET['oauth_token'],$_SESSION['smc_oauth_token_secret']);
					break;
			case 'fanfou':
					include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
					$r=smc_fanfou_verify_credentials();
					if($r){
						$tok = array('account'=>$r['user_login'],'oauth_token'=>$r['oauth_access_token'],'oauth_token_secret'=>$r['oauth_access_token_secret']);
					}
					break;
			case 'follow5':
					include dirname(__FILE__).'/follow5/follow5Auth.php';
					$tok = smc_follow5_getAccessToken();
					echo '<script type="text/javascript">window.opener.smc_reload("");window.close();</script>';
					break;
			case 'zuosa':
					include dirname(__FILE__).'/zuosa/zuosaAuth.php';
					$tok = smc_zuosa_getAccessToken();
					echo '<script type="text/javascript">window.opener.smc_reload("");window.close();</script>';
					break;
			case 'wbto':
					include dirname(__FILE__).'/wbto/wbtoAuth.php';
					$tok = smc_wbto_getAccessToken();
					echo '<script type="text/javascript">window.opener.smc_reload("");window.close();</script>';
					break;
			default:return;
		}
		if(is_array($tok)){
			$weibotok=get_option('weibo_access_token');
			$weibotok[$_SESSION["smc_weibo"]]=$tok;
			update_option('weibo_access_token',$weibotok);
		}
	}
	?>
	<div class="wrap" style="-webkit-text-size-adjust:none;">
		<div class="icon32" id="icon-options-general"><br></div>
			<h2>绑定社交媒体网站账号</h2>

            <?php 
				if(isset($info)){
					echo "<h3 class='info'>$info</h3>";
				}
				$tok = get_option('weibo_access_token');//print_r($tok);//die();
				$smc_url = WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__));
				if($tok){
					echo '<h3>您已经绑定以下网站: </h3>';
					echo '<div id="weibobind">';
					if($tok['sinaweibo'])echo '<img class="smc_img" src="'.$smc_url.'/images/sina.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=sinaweibo&weiboname=新浪微博"><input type="submit" class="button-primary" value="删除新浪微博绑定"></a>';
					if($tok['qqweibo'])echo '<img class="smc_img" src="'.$smc_url.'/images/qq.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=qqweibo&weiboname=腾讯微博"><input type="submit" class="button-primary" value="删除腾讯微博绑定"></a>';
					if($tok['sohuweibo'])echo '<img class="smc_img" src="'.$smc_url.'/images/sohu.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=sohuweibo&weiboname=搜狐微博"><input type="submit" class="button-primary" value="删除搜狐微博绑定"></a>';
					if($tok['163weibo'])echo '<img class="smc_img" src="'.$smc_url.'/images/163.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=163weibo&weiboname=网易微博"><input type="submit" class="button-primary" value="删除网易微博绑定"></a>';
					if($tok['douban'])echo '<img class="smc_img" src="'.$smc_url.'/images/douban.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=douban&weiboname=豆瓣微博"><input type="submit" class="button-primary" value="删除豆瓣绑定"></a>';
					if($tok['twitter'])echo '<img class="smc_img" src="'.$smc_url.'/images/twitter.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=twitter&weiboname=Twitter"><input type="submit" class="button-primary" value="remove twitter account"></a>';
					if($tok['fanfou'])echo '<img class="smc_img" src="'.$smc_url.'/images/fanfou.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=fanfou&weiboname=饭否"><input type="submit" class="button-primary" value="删除饭否绑定"></a>';
					if($tok['follow5'])echo '<img class="smc_img" src="'.$smc_url.'/images/follow5.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=follow5&weiboname=Follow5"><input type="submit" class="button-primary" value="删除follow5绑定"></a>';
					if($tok['zuosa'])echo '<img class="smc_img" src="'.$smc_url.'/images/zuosa.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=zuosa&weiboname=做啥"><input type="submit" class="button-primary" value="删除做啥账号绑定"></a>';
					if($tok['wbto'])echo '<img class="smc_img" src="'.$smc_url.'/images/wbto.png" /><a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'&delete=wbto&weiboname=微博通"><input type="submit" class="button-primary" value="删除微博通绑定"></a>';
					echo '</div>';
				}
				if(count($tok)>=10){
					echo '<p>你已经绑定了所有网站，点击下面按钮解除所有绑定</p>';
				}else{
					echo '<p>点击下面的图标，将你的帐号和你的博客绑定，当你的博客更新的时候，会同时更新到绑定的微博。</p>';
				}
				smc_connect(array('admin'=>1,'callback_url'=>smc_menu_page_url('social-medias-connect/function.php',false)));
				if($tok){
			?>
				<a href="<?php echo smc_menu_page_url('social-medias-connect/function.php',false); ?>&delete_all=1"><input type="submit" class="button-primary" value="删除所有绑定"></a>
			<?php
				}
			?>
			<br/><br/>注意：由于饭否OAuth对于回调地址的处理问题，导致此页面绑定时会出现“您没有足够的权限访问这个页面。”的提示。不用担心，你只需复制浏览器地址，然后将<code>social-medias-connect/function.php?oauth_token</code>中的<code>?</code>改成<code>&</code>，然后访问这个地址即可。如果还有疑问，请到我<a href="http://www.qiqiboy.com/products/plugins/social-medias-connect">博客留言</a>或者在<a href="http://weibo.com/qiqiboy">新浪微博</a>上向我提问，我会帮助你进行绑定。
	</div>
			<?php
}
function smc_bind_weibo_option() {
	?>
	<div class="wrap" style="-webkit-text-size-adjust:none;">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>社交媒体连接设置</h2>
		<?php $smc_url = WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__));
			if(isset($_POST['smc_allowed_weibo'])){
				$allows=get_option('smc_allowed_weibo');
				if($allows){
					foreach($allows as $key => $t){
						if(isset($_POST['smc_allowed_'.$key])){
							$allows[$key]='1';
						}else{
							$allows[$key]='0';
						}
					}
					$info1='设置成功！';
					update_option('smc_allowed_weibo',$allows);
				}else{
					$info1='设置失败，请刷新页面重试!';
				}
			}
			$allows = get_option('smc_allowed_weibo');
			if(!$allows||count($allows)<10){
				$_allows=array(
					'sinaweibo'=>'1',
					'qqweibo'=>'1',
					'sohuweibo'=>'1',
					'163weibo'=>'1',
					'douban'=>'1',
					'twitter'=>'0',
					'fanfou'=>'1',
					'follow5'=>'0',
					'zuosa'=>'0',
					'wbto'=>'0'
				);
				if($allows)$_allows=array_merge($_allows,$allows);
				update_option('smc_allowed_weibo',$_allows);
				$allows=get_option('smc_allowed_weibo');
			}
			/* 微博设置 */
			$opt=get_option('smc_weibo_options');
			$default_opt=array(
					'smc_auto_connect'=>'1',
					'smc_auto_js'=>'1',
					'smc_weibo_notice'=>'使用微博连接登陆后，请尽快到后台修改您的邮箱地址，以便接收在本站的一些通知及回复。',
					'smc_btn_img'=>'4',
					'smc_front_prefix'=>'【博客更新】',
					'smc_end_prefix'=>'【博文修改】',
					'smc_shorturl'=>'',
					'smc_use_short'=>'1',
					'smc_thumb'=>'1',
					'smc_post_format'=>'%%prefix%%%%title%% %%tags%% - %%url%%',
					'smc_comment_format'=>'我对《%%title%%》的观点: %%comment%% - %%url%%',
					'smc_shorturl_service'=>'sinaurl',
					'smc_auto_remember'=>'0',
					'smc_weibotips'=>'您也可以使用微博账号登陆'
				);
			if(empty($opt)||count($opt)<count($default_opt)){
				if($opt)$default_opt=array_merge($default_opt,$opt);
				update_option('smc_weibo_options',$default_opt);
				$opt=$default_opt;
			}
			if(isset($_POST['smc_weibo_option'])){
				foreach($opt as $key => $t){
					if(isset($_POST[$key])){
						$opt[$key]=stripslashes($_POST[$key]);
					}
				}
				update_option('smc_weibo_options',$opt);
			}
		?>
		<form action="<?php echo smc_menu_page_url('smc_bind_weibo_option',false); ?>" enctype="multipart/form-data" method="post">
			<?php if(isset($info1)){
					echo "<h3 class='info'>$info1</h3>";
				}
			?>
			<h3>勾选允许连接登陆的网站</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">允许的网站请打上勾<br/></th>
						<td>
							<ul id="smc_allow">
							<?php foreach($allows as $key => $t): ?>
								<li class="smc_<?php echo $key; ?>">
									<input type="checkbox" title="<?php echo smc_get_weibo_name($key); ?>" name="smc_allowed_<?php echo $key; ?>"<?php if($t)echo ' checked="checked"'; ?> value="1" />
								</li>
							<?php endforeach; ?>
							</ul>
							<input type="hidden" name="smc_allowed_weibo" value="1" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">自动插入社交媒体连接按钮<br/><br/><small>1.如果选择"是"，将会自动在评论表单、登陆界面处插入连接按钮</small><br/><small>2.如果你选择“否”，那么你需要手动在需要显示连接按钮的地方调用<code>&lt;?php if(function_exists('smc_connect'))smc_connect(); ?></code></small></th>
						<td>
							<input type="radio" name="smc_auto_connect"<?php if($opt['smc_auto_connect'])echo ' checked="checked"'; ?> value="1" /><label>是</label>
							<input type="radio" name="smc_auto_connect"<?php if(!$opt['smc_auto_connect'])echo ' checked="checked"'; ?> value="0" /><label>否</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">启用浮动面板<br/><br/><small>1.如果选择"是"，将会在一个浮动窗口中显示登陆连接按钮（节省页面空间）</small><br/><small>2.如果你选择“否”，登陆连接按钮将会全部列出（占地方）</small></th>
						<td>
							<input type="radio" name="smc_auto_js"<?php if($opt['smc_auto_js'])echo ' checked="checked"'; ?> value="1" /><label>是</label>
							<input type="radio" name="smc_auto_js"<?php if(!$opt['smc_auto_js'])echo ' checked="checked"'; ?> value="0" /><label>否</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">记住用户登录状态<br/><br/><small>1.如果选择"是"，下次访问网站时将自动登录</small><br/><small>2.如果你选择“否”，下次需要重新登陆</small></th>
						<td>
							<input type="radio" name="smc_auto_remember"<?php if($opt['smc_auto_remember'])echo ' checked="checked"'; ?> value="1" /><label>是</label>
							<input type="radio" name="smc_auto_remember"<?php if(!$opt['smc_auto_remember'])echo ' checked="checked"'; ?> value="0" /><label>否</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">登陆按钮的提示文字<br/><small>留空不显示</small></th>
						<td>
							<textarea name="smc_weibotips" cols="50" rows="1" id="smc_weibotips" style="width:500px;font-size:12px;" class="code"><?php echo htmlspecialchars($opt['smc_weibotips']); ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">选择按钮样式<br/><small>只有你选择了“启用浮动面板，这项选择才有效</small></th>
						<td>
							<input type="radio" name="smc_btn_img"<?php if($opt['smc_btn_img']=='1')echo ' checked="checked"'; ?> value="1" /><label><img alt="img 1" src="<?php echo $smc_url; ?>/images/smc_1.png"/></label>
							<input type="radio" name="smc_btn_img"<?php if($opt['smc_btn_img']=='2')echo ' checked="checked"'; ?> value="2" /><label><img alt="img 2" src="<?php echo $smc_url; ?>/images/smc_2.png"/></label>
							<input type="radio" name="smc_btn_img"<?php if($opt['smc_btn_img']=='3')echo ' checked="checked"'; ?> value="3" /><label><img alt="img 3" src="<?php echo $smc_url; ?>/images/smc_3.png"/></label>
							<input type="radio" name="smc_btn_img"<?php if($opt['smc_btn_img']=='4')echo ' checked="checked"'; ?> value="4" /><label><img alt="img 4" src="<?php echo $smc_url; ?>/images/smc_4.png"/></label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">浮动面板右边提示文字</th>
						<td>
							<textarea name="smc_weibo_notice" cols="50" rows="3" id="smc_weibo_notice" style="width:500px;font-size:12px;" class="code"><?php echo htmlspecialchars($opt['smc_weibo_notice']); ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<h3>同步到微博文字前缀</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">发布新文章时</th>
						<td>
							<input type="text" name="smc_front_prefix" class="regular-text" value="<?php echo htmlspecialchars($opt['smc_front_prefix']); ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">修改早期文章时</th>
						<td>
							<input type="text" name="smc_end_prefix" class="regular-text" value="<?php echo htmlspecialchars($opt['smc_end_prefix']); ?>" />
						</td>
					</tr>
				</tbody>
			</table>
			<h3>短链接api</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">启用url缩短功能<br/></th>
						<td>
							<input type="radio" name="smc_use_short"<?php if($opt['smc_use_short'])echo ' checked="checked"'; ?> value="1" /><label>启用</label>
							<input type="radio" name="smc_use_short"<?php if(!$opt['smc_use_short'])echo ' checked="checked"'; ?> value="0" /><label>关闭</label>
						</td>
					</tr>
					<?php 
						$shortsite=array(
							'sinaurl'=>'新浪微博短连接(推荐)',
							'bitly'=>'Bit.ly shortener',
							'wp_short'=>'wordpress短网址',
							'custom'=>'自定义短网址服务api'
						)
					?>
					<tr valign="top">
						<th scope="row">请选择短网址服务提供商<br/></th>
						<td>
							<select id="smc_shorturl_service" name="smc_shorturl_service">
						<?php 
							foreach($shortsite as $key => $desc){
						?>
								<option <?php if($opt['smc_shorturl_service']==$key)echo 'selected="selected" '; ?> value="<?php echo $key; ?>"><?php echo $desc; ?></option>
						<?php
							}
						?>
							</select>
						</td>
					</tr>
					<tr valign="top" id="smc_shorturl" style="<?php if($opt['smc_shorturl_service']!=='custom')echo 'display:none'; ?>">
						<th scope="row">输入短连接服务的api地址</th>
						<td>
							<input type="text" name="smc_shorturl" class="regular-text" value="<?php echo htmlspecialchars($opt['smc_shorturl']); ?>" /><label> 例如：<code>http://myshort.com/api.php?format=simple&action=shorturl&url=</code></label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="color:red;">向我推荐优秀的短网址服务</th>
						<td>
							<label>如果你正在经营着一家短网址服务网站，或者你知道一些优秀的短网址服务站点，欢迎向我推荐。<br/>微博FO我<a href="http://weibo.com/qiqiboy">@qiqiboy</a>，<a href="http://www.qiqiboy.com">我的博客</a>留言，或者邮件&Gtalk与我联系:imqiqiboy#gmail.com。</label>
						</td>
					</tr>
				</tbody>
			</table>
			<h3>文章同步</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">文章同步格式<br/><br/><small>%%prefix%%: 文章前缀<br/>%%title%%: 文章标题<br/>%%url%%: 文章链接<br/>%%tags%%: 文章标签<br/>%%excerpt%%: 文章摘要</small><br/></th>
						<td>
							<textarea name="smc_post_format" cols="50" rows="3" id="smc_post_format" style="width:500px;font-size:12px;" class="code"><?php echo htmlspecialchars($opt['smc_post_format']); ?></textarea><br/>你可以随意调整标题、链接、标签等的顺序，并且可以插入其他内容
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">同步文章缩略图<br/><small>如果没有设置文章缩略图，那么插件会提取文章中第一张图片进行同步。<br/><br/>如果开启缩略图同步时容易出现500错误或者页面显示不可用，那么请最好暂时停用缩略图同步。</small></th>
						<td>
							<input type="radio" name="smc_thumb"<?php if($opt['smc_thumb'])echo ' checked="checked"'; ?> value="1" /><label>同步文章缩略图</label>
							<input type="radio" name="smc_thumb"<?php if(!$opt['smc_thumb'])echo ' checked="checked"'; ?> value="0" /><label>不同步缩略图</label>
						</td>
					</tr>
				</tbody>
			</table>
			<h3>评论同步</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">评论同步格式<br/><br/><small>%%title%%: 文章标题<br/>%%url%%: 评论链接<br/>%%comment%%: 评论内容</small><br/></th>
						<td>
							<textarea name="smc_comment_format" cols="50" rows="3" id="smc_comment_format" style="width:500px;font-size:12px;" class="code"><?php echo htmlspecialchars($opt['smc_comment_format']); ?></textarea><br/>你可以随意调整标题、链接、标签等的顺序，并且可以插入其他内容
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="option_save" class="button-primary" value="保存设置" />
				<input type="hidden" name="smc_weibo_option" value="1" />
			</p>
		</form><br><br><br>
		<code>提示：请在文章编辑页面下部找到“同步文章状态”一栏，查看当前文章的同步状态，并选择文章是否同步。<br/> 草稿、私密文章、早期文章不同步。如果要同步，请选择“同步”(私密、草稿无效)。<br/> 有任何问题请与我联系(gtalk&gmail:imqiqiboy@gmail.com,也可博客与我交流:http://www.qiqiboy.com/)</code>
	</div>
	<?php
}
function smc_bind_weibo_help(){
	require_once 'help.php';
}
function smc_bind_weibo_acount(){
	require_once 'bind.php';
}
function smc_bind_weibo_uninstall(){
	require_once 'uninstall.php';
}
/* sync your entry to social media sites */
add_action('publish_post', 'smc_publish_post', 999);
function smc_publish_post($post_ID=""){
	if($_POST['smc_must_sync']==='no' || $_POST['action'] == "autosave" || $_POST['action'] == "inline-save" || $_POST['post_status'] == "draft" || $_POST['post_status'] == "private" || isset($_GET['bulk_edit']) || isset($_POST['_inline_edit'])){
		return false;
	}
	$weibotok = get_option('weibo_access_token');
	$weiboopt=get_option('smc_weibo_options');
	if(!$weibotok) return;
	$_post=get_post($post_ID);
	$thumb=$weiboopt['smc_thumb']?smc_post_thumb($_post):'';
	$prefix=$_POST['original_post_status'] == 'publish' || $_POST['original_post_status'] == 'private' ? $weiboopt['smc_end_prefix'] : $weiboopt['smc_front_prefix'];
	$url=get_permalink($post_ID);
	if($weiboopt['smc_use_short']){
		$url=smc_shorturl($weiboopt['smc_shorturl_service'],$url,$post_ID);
	}
	$excerpt=$_post->post_excerpt?strip_tags($_post->post_excerpt):strip_tags($_post->post_content);
	$content=array('prefix'=>$prefix,'text'=>$_post->post_title,'url'=>wp_urlencode($url),'tags'=>wp_get_post_tags($_post->ID),'excerpt'=>$excerpt);
	foreach($weibotok as $weibo => $tok){
		if((!$_POST['smc_must_sync'] || $_POST['smc_must_sync']==='only') && get_post_meta($post_ID, '_'.$weibo.'_sync', true)){
			continue;
		}
		switch($weibo){
			case 'sinaweibo':
					if(!class_exists('WeiboOAuth')){
						include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
					}
					$resp=smc_sina_weibo_update($content,$thumb,$tok);//print_r($resp);
					break;
			case 'qqweibo':
					if(!class_exists('MBOpenTOAuth')){
						include dirname(__FILE__).'/qqweibo/qqOAuth.php';
					}
					$resp=smc_qq_weibo_update($content,$thumb,$tok);//print_r($resp);
					break;
			case 'douban':
					if(!class_exists('doubanOAuth')){
						include dirname(__FILE__).'/douban/doubanOAuth.php';
					}
					$resp=smc_douban_weibo_update($content,$thumb,$tok);
					break;
			case 'sohuweibo':
					if(!class_exists('sohuOAuth')){
						include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
					}
					$resp=smc_sohu_weibo_update($content,$thumb,$tok);
					break;
			case '163weibo':
					if(!class_exists('Weibo163OAuth')){
						include dirname(__FILE__).'/163weibo/163OAuth.php';
					}
					$resp=smc_163_weibo_update($content,$thumb,$tok);
					break;
			case 'twitter':
					if(!class_exists('TwitterOAuth')){
						include dirname(__FILE__).'/twitter/twitterOAuth.php';
					}
					$resp=smc_twitter_weibo_update($content,$thumb,$tok);
					break;
			case 'fanfou':
					if(!class_exists('FanfouOAuth')){
						include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
					}
					$resp=smc_fanfou_weibo_update($content,$thumb,$tok);
					break;
			case 'follow5':
					if(!class_exists('follow5Auth')){
						include dirname(__FILE__).'/follow5/follow5Auth.php';
					}
					$resp=smc_follow5_weibo_update($content,$thumb,$tok);
					break;
			case 'zuosa':
					if(!class_exists('ZuosaAuth')){
						include dirname(__FILE__).'/zuosa/zuosaAuth.php';
					}
					$resp=smc_zuosa_weibo_update($content,$thumb,$tok);
					break;
			case 'wbto':
					if(!class_exists('WBToAuth')){
						include dirname(__FILE__).'/wbto/wbtoAuth.php';
					}
					$resp=smc_wbto_weibo_update($content,$thumb,$tok);
					break;
			default:continue;break;
		}
		if($resp){
			if(!update_post_meta($post_ID, '_'.$weibo.'_sync', 'true'))
				add_post_meta($post_ID, '_'.$weibo.'_sync', 'true', true);
			if(!update_post_meta($post_ID, '_'.$weibo.'_sync_id', $resp))
				add_post_meta($post_ID, '_'.$weibo.'_sync_id', $resp, true);//9105332181
		}
	}
}

/* sync comment to social media sites */
add_action('comment_post', 'smc_comment_post',999);
function smc_comment_post($id){
	$comment_post_id = $_POST['comment_post_ID'];
	if(empty($comment_post_id)){
		return;
	}
	$current_comment = get_comment($id);
	$current_post = get_post($comment_post_id);
	$smcdata = get_user_meta($current_comment->user_id, 'smcdata',true);
	$weibo=$smcdata['smcweibo'];
	if($smcdata){
		if($_POST['post_to_socialmedias']){
			$weiboopt=get_option('smc_weibo_options');
			$url=get_permalink($comment_post_id);
			if($weiboopt['smc_use_short']){
				$url=smc_shorturl($weiboopt['smc_shorturl_service'],$url,$comment_post_id);
			}
			$p=array(
				"title"=>get_the_title($comment_post_id),
				"url"=>wp_urlencode($url."#comment-".$id),
				"comment"=>strip_tags($current_comment->comment_content),
				"weibosync"=>get_post_meta($comment_post_id, '_'.$weibo.'_sync_id', true)
			);//print_r($p);die();
			switch($smcdata['smcweibo']){
				case 'sinaweibo':
						if(!class_exists('WeiboOAuth')){
							include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
						}
						smc_sina_weibo_repost($p,$smcdata);
						break;
				case 'qqweibo':
						if(!class_exists('MBOpenTOAuth')){
							include dirname(__FILE__).'/qqweibo/qqOAuth.php';
						}
						smc_qq_weibo_repost($p,$smcdata);
						break;
				case 'douban':
						if(!class_exists('doubanOAuth')){
							include dirname(__FILE__).'/douban/doubanOAuth.php';
						}
						smc_douban_weibo_repost($p,$smcdata);
						break;
				case 'sohuweibo':
						if(!class_exists('sohuOAuth')){
							include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
						}
						smc_sohu_weibo_repost($p,$smcdata);
						break;
				case '163weibo':
						if(!class_exists('Weibo163OAuth')){
							include dirname(__FILE__).'/163weibo/163OAuth.php';
						}
						smc_163_weibo_repost($p,$smcdata);
						break;
				case 'twitter':
						if(!class_exists('TwitterOAuth')){
							include dirname(__FILE__).'/twitter/twitterOAuth.php';
						}
						smc_twitter_weibo_repost($p,$smcdata);
						break;
				case 'fanfou':
						if(!class_exists('FanfouOAuth')){
							include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
						}
						smc_fanfou_weibo_repost($p,$smcdata);
						break;
				case 'follow5':
						if(!class_exists('follow5Auth')){
							include dirname(__FILE__).'/follow5/follow5Auth.php';
						}
						smc_follow5_weibo_repost($p,$smcdata);
						break;
				case 'zuosa':
						if(!class_exists('Zuosa5Auth')){
							include dirname(__FILE__).'/zuosa/zuosaAuth.php';
						}
						smc_zuosa_weibo_repost($p,$smcdata);
						break;
				case 'wbto':
						if(!class_exists('WBTo5Auth')){
							include dirname(__FILE__).'/wbto/wbtoAuth.php';
						}
						smc_wbto_weibo_repost($p,$smcdata);
						break;
				default:return false;
			}
			setcookie('post_to_socialmedias_' . COOKIEHASH, 'no', time(), COOKIEPATH, COOKIE_DOMAIN);
		}else{
			$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
			setcookie('post_to_socialmedias_' . COOKIEHASH, 'no', time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
		}
	}
}

function smc_weibo_must_sync(){
	global $post;
	$weiboarray=array('qqweibo','sinaweibo','sohuweibo','163weibo','douban','twitter','fanfou','follow5','zuosa','wbto');
	$weibotok=get_option('weibo_access_token');
	$weiboname='';$bindweibo='';
	if($weibotok){
		foreach($weibotok as $weibo => $tok){
			$bindweibo.=' '.($_weibo=smc_get_weibo_name($weibo));
		}
	}
	foreach($weiboarray as $weibo){
		$synced=get_post_meta($post->ID, '_'.$weibo.'_sync', true);
		if($synced){
			$weiboname.=' '.smc_get_weibo_name($weibo);
		}
	}
	$post_status=get_post_status($post->ID);
	switch($post_status){
		case 'publish':$status_info='这篇文章已经发布，默认不会同步。';$synced='true';
						break;
		case 'private':$status_info='这篇文章是私密文章，默认不会同步。';$synced='true';
						break;
		case 'auto-draft':$status_info='这篇文章是您新建的，点击“发布”将会同步到您的绑定微博。';
						break;
		case 'draft':$status_info='这篇文章是您之前保存的草稿，点击“发布”将会同步到您的绑定微博。';
						break;
		default:break;
	}
	echo '<div class="postbox">';
	echo	'<h3 class="hndle"><span>同步文章更新状态('.$status_info.')</span></h3>';
	echo		'<div class="inside">';
	if(!empty($bindweibo)) echo '<p>您已经绑定了{'.$bindweibo.' }。</p>';
	else     echo '<p>您还未绑定任何微博。如果要将文章同步到微博，请立即到<a href="'.smc_menu_page_url('social-medias-connect/function.php',false).'">Social Medias Connect</a>设置页面绑定您的微博账号。</p>';
	if(!empty($weiboname)) echo '<p>这篇文章已经同步到了{'.$weiboname.' }。如果你要再次进行同步，请确保选中“同步”状态。</p>';
	else 			echo '<p>这篇文章未同步到任何微博。如果你要进行同步，请确认以选中了“同步按钮。”</p>';
	echo			'<p><b>同步到社交网站: </b><input type="radio" name="smc_must_sync" value="no"';
	if(isset($synced)&&!empty($synced)) echo ' checked="checked"';
	echo 			'/><label>不同步</label> ';
	echo			'<input type="radio" name="smc_must_sync" value="yes"';
	if(!isset($synced)||empty($synced)) echo ' checked="checked"';
	echo 			'/><label>全部同步</label> ';
	echo			'<input type="radio" name="smc_must_sync" value="only"';
	echo 			'/><label>仅同步未同步过的微博</label> <label style="margin-left:30px;">注意，只有选中“同步”状态，才会将文章同步到微博。</label></p>';
	echo		'</div>';
	echo '</div>';
}
//add_action('save_post', 'smc_weibo_action');
add_action('edit_form_advanced', 'smc_weibo_must_sync');

function smc_post_thumb($post=false ){
    if(!$post)global $post;

	$timthumb_src='';
	if( smc_has_post_thumbnail($post->ID)){
		$timthumbs = wp_get_attachment_image_src(smc_get_post_thumbnail_id($post->ID),'full');
		$timthumb_src=$timthumbs[0];
	}else{
		preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $index_matches);
		$first_img_src = $index_matches [1];
		if($first_img_src){
			$timthumb_src=$first_img_src;
		}
	}
	return $timthumb_src;
}
if(!function_exists('smc_has_post_thumbnail')){
	function smc_has_post_thumbnail( $post_id = NULL ) {
		global $id;
		$post_id = ( NULL === $post_id ) ? $id : $post_id;
		return !! smc_get_post_thumbnail_id( $post_id );
	}
	function smc_get_post_thumbnail_id( $post_id = NULL ) {
		global $id;
		$post_id = ( NULL === $post_id ) ? $id : $post_id;
		return get_post_meta( $post_id, '_thumbnail_id', true );
	}
}
if(!function_exists('wp_urlencode')){
	function wp_urlencode($url) {
		$a = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D');
		$b = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]");
		$url = str_replace($a, $b, urlencode($url));
		return $url;
	}
}
function smc_get_client_ip(){
	if(getenv('HTTP_CLIENT_IP')){
		$client_ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
		$client_ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR')) {
		$client_ip = getenv('REMOTE_ADDR');
	} else {
		$client_ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	}
	return $client_ip;
}
function smc_get_weibo_name($weibo){
	switch($weibo){
		case 'sinaweibo':
				$weibo='新浪微博';
				break;
		case 'qqweibo':
				$weibo='腾讯微博';
				break;
		case 'douban':
				$weibo='豆瓣';
				break;
		case 'sohuweibo':
				$weibo='搜狐微博';
				break;
		case '163weibo':
				$weibo='网易微博';
				break;
		case 'twitter':
				$weibo='Twitter';
				break;
		case 'fanfou':
				$weibo='饭否';
				break;
		case 'follow5':
				$weibo='Follow5';
				break;
		case 'zuosa':
				$weibo='做啥';
				break;
		case 'wbto':
				$weibo='微博通';
				break;
		default:$weibo='XXX微博';
				break;
	}
	return $weibo;
}
function smc_new_user_email($userdata=array(),$weibo){
	$blogname = get_option('blogname');
	$name=smc_get_weibo_name($weibo);
	$uname=$userdata['display_name'];
	$ulogin=$userdata['user_login'];
	$uurl=$userdata['user_url'];
	$subj = "新的{$name}连接用户注册 - $blogname";
	$body = "在 $blogname 新注册用户信息：\r\n";
	$body.= "用户名：$ulogin\r\n";
	$body.= "昵称：$uname\r\n";
	$body.= "地址：$uurl\r\n";
	$body.= "\r\n";
	$body.= "-----------------------------------\r\n";
	$body.= "这是一封自动发送的邮件。 \r\n";
	$body.= "来自 {$blogname}。\r\n";
	$body.= "请不要回复本邮件。\r\n";
	$body.= "Powered by © Social Medias Connect。\r\n";
	$admin_email = get_option('admin_email');
	wp_mail($admin_email, $subj, $body, $headers = '');
}
function smc_strlen($str='',$twitter=false){//twitter和四大微博字数计数方式不一样
	$length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
    if($twitter){
		if ($length){
			return strlen($str) - $length + intval($length / 3) ;
		}else{
			return strlen($str);
		}
	}else{
		if ($length){
			return (strlen($str) - $length)/2 + intval($length / 3) ;
		}else{
			return strlen($str)/2;
		}
	}
}
/*
function smc_substr($str,$start,$length=false){
	$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	preg_match_all($pa, $str, $t_str);
	if(count($t_str[0]) > $length) {
		$str = join('', array_slice($t_str[0], $start, $length));
	}
	return $str;
}
*/
function smc_substr($str, $from=0, $length=false, $old='', $twitter=false){
	$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	if(is_array($str)){
		$t_str=$str;
	}else preg_match_all($pa, $str, $t_str);
	if(count($t_str[0]) > $length) {
		$_str = join('', array_slice($t_str[0], $from, $length));
		if(($_length=($length-smc_strlen($_str,$twitter)))>0){
			return smc_substr($t_str,intval($from+$length), intval($_length), $old.$_str, $twitter);
		}
		return $old.$_str;
	}
	return $old.$str;
}
function get_weibo_str_length($data='',$length=140,$twitter=false){
	$weiboopt=get_option('smc_weibo_options');
	$format=$weiboopt['smc_post_format'];
	if(is_array($data)){
		$title=$data['text'];$url=$data['url'];$prefix=$data['prefix'];
		$tags=$data['tags']?smc_convtags($data['tags'],$twitter):array();
		$excerpt=$data['excerpt'];
		if(($url_length=smc_strlen($url,$twitter))>$length)return false;
		$format=str_ireplace('%%title%%',$title,$format);
		$format=str_ireplace('%%prefix%%',$prefix,$format);
		$format=str_ireplace('%%url%%',$url,$format);
		$_format=$format;
		if(($prefix_title_url_length=smc_strlen(preg_replace('/%%tags%%|%%excerpt%%/','',$_format),$twitter))<$length){
			$t_count=0;$new_tags=array();
			if(stripos($format,'%%tags%%')>=0){
				foreach($tags as $tag){
					if($t_count+($_t_count=smc_strlen($tag,$twitter)+1)<$length-$prefix_title_url_length){
						$new_tags[]=$tag;
						$t_count+=$_t_count;
					}else break;
				}
				$format=str_ireplace('%%tags%%',join(' ',$new_tags),$format);
			}else{
				$format=preg_replace('/%%tags%%/','',$format);
			}
			if($excerpt&&($prefix_title_url_tags_length=$prefix_title_url_length+$t_count)<$length-3){
				$format=str_ireplace('%%excerpt%%',smc_substr($excerpt,0,$length-$prefix_title_url_tags_length,'',$twitter).'...',$format);
			}else{
				$format=preg_replace('/%%excerpt%%/','',$format);
			}
		}else{
			$format=smc_substr($prefix.$title,0,$length-$url_length-6).'... - '.$url;
		}
		$_temp=$format;
	}else{
		if(smc_strlen($data,$twitter)>=$length){
			$_temp=smc_substr($data,0,$length-3,'',$twitter).'...';
		}else $_temp=$data;
	}
	return $_temp;
}
function smc_convtags($tags,$twitter=false){
	$output=array();
	foreach($tags as $tag){
		$output[] = '#'. str_ireplace(' ','-',trim($tag->name)) .($twitter&&$twitter==='twitter'?'':'#');
	}
	return $output;
}
function get_comment_str_length($data,$length=140,$twitter=false){
	$weiboopt=get_option('smc_weibo_options');
	$format=$weiboopt['smc_comment_format'];
	$title=$data['title'];$url=$data['url'];$comment=$data['comment'];
	if(($url_length=smc_strlen($url,$twitter))>$length)return false;
	$_format=$format=str_ireplace('%%title%%',$title,$format);
	if(($_length=smc_strlen(preg_replace('/%%comment%%|%%url%%/','',$_format),$twitter)+$url_length-$length)>0){
		$_temp=smc_substr($_format,0,$length-6-$url_length,'',$twitter).'... - '.$url;
	}else{
		if(smc_strlen($comment,$twitter)>abs($_length)){
			$comment=smc_substr($comment,0,abs($_length)-3,'',$twitter).'...';
		}
		$format=str_ireplace('%%comment%%',$comment,$format);
		$format=str_ireplace('%%url%%',$url,$format);
		$_temp=$format;
	}
	return $_temp;
}
function smc_shorturl($t,$url,$post_id){
	$weiboopt=get_option('smc_weibo_options');
	$re=new WP_Http();
	$shorturl='';
	switch($t){
		case 'custom':
				if($weiboopt['smc_shorturl']){
					$response=$re->request($weiboopt['smc_shorturl'].$url);
					if(is_array($response)){
						$shorturl=$response['body'];
					}
				}
				break;
		case 'bitly':
				$response=$re->request('http://api.bitly.com/v3/shorten?login=qiqiboy&apiKey=R_580153ea12cdeedc598e81f486d10a14&format=json&longUrl='.$url);
				if(is_array($response)){
					$response=json_decode($response['body']);
					if($response->status_code=='200'){
						$shorturl=$response->data->url;
					}
				}
				break;
		case 'sinaurl':
				$response=$re->request('http://api.t.sina.com.cn/short_url/shorten.json?source=3033277072&url_long='.$url);
				if(is_array($response)){
					$response=json_decode($response['body']);
					if(!$response->error){
						$shorturl=$response[0]->url_short;
					}
				}
				break;
		case 'wp_short':
		default:$shorturl=get_option('home').'?p='.$post_id;break;
	}
	if(substr($shorturl,0,7)=="http://")return $shorturl;
	else return smc_shorturl('wp_short',$url,$post_id);
}
/******************************************/
/***********************/
/************/
function smc_weibo_timeline($args=array()){
	$defaults=array(
		"weibo"=>"",
		"number"=>5,
		"type"=>"user_timeline",
		"expire"=>5,
		"format"=>'',
		"length"=>200,
		"size"=>48,
		"retweet"=>1
	);
	$r = wp_parse_args( $args, $defaults );
	extract( $r );
	$weibotok = get_option('weibo_access_token');
	if(!$weibotok)$weibotok=array();
	$expire=(int)$expire<1?5:(int)$expire;
	if((!$cachedata = get_option( 'smc_'.$weibo.'_timeline_cache')) || time()-$cachedata['updatetime']>60*$expire || $cachedata['type'] !== $type || $cachedata['weibo'] !== $weibo || $cachedata['number'] !== $number || $cachedata['format'] !== $format){
		$weibos= array_keys($weibotok);
		if(in_array($weibo,$weibos)){
			$tok=$weibotok[$weibo];
			switch($weibo){
				case 'sinaweibo':
						if(!class_exists('WeiboOAuth')){
							include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
						}
						$data=smc_sina_weibo_timeline($r,$tok);
						break;
				case 'qqweibo':
						if(!class_exists('MBOpenTOAuth')){
							include dirname(__FILE__).'/qqweibo/qqOAuth.php';
						}
						$data=smc_qq_weibo_timeline($r,$tok);
						break;
				case 'sohuweibo':
						if(!class_exists('sohuOAuth')){
							include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
						}
						$data=smc_sohu_weibo_timeline($r,$tok);
						break;
				case '163weibo':
						if(!class_exists('Weibo163OAuth')){
							include dirname(__FILE__).'/163weibo/163OAuth.php';
						}
						$data=smc_163_weibo_timeline($r,$tok);
						break;
				case 'fanfou':
						if(!class_exists('FanfouOAuth')){
							include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
						}
						$data=smc_fanfou_weibo_timeline($r,$tok);
						break;
				case 'twitter':
						if(!class_exists('TwitterOAuth')){
							include dirname(__FILE__).'/twitter/twitterOAuth.php';
						}
						$data=smc_twitter_weibo_timeline($r,$tok);
						break;
				case 'douban':
						//include dirname(__FILE__).'/douban/doubanOAuth.php';smc_douban_weibo_timeline($r,$tok);break;
				default:echo '暂未提供相关功能，请等待插件更新。';return false;
			}
			if($data){
				update_option('smc_'.$weibo.'_timeline_cache', array('data'=>$data,'updatetime'=>time(),'type'=>$type,'weibo'=>$weibo,'number'=>$number,'format'=>$format));
			}else{
				echo '数据获取失败，请稍后再试';
				return false;
			}
		}else{
			echo '授权异常: 你未绑定你选择的微博或者授权失效，请到后台重新绑定微博';
			return false;
		}
	}else{
		$data=$cachedata['data'];
	}
	
	if($data){
		$random_num = mt_rand(1,999999999);
		$output = '<script type="text/javascript">if(window.smcJS){if(window.jQuery)jQuery(document).ready(function(){smcJS.smcpic("'.$random_num.'");});else smcJS.documentReady(function(){smcJS.smcpic("'.$random_num.'");});}</script>';
		$output .= '<ul id="smc-weibo-list-'.$random_num.'">';
		foreach($data as $w){
			smc_format_weibo_data(&$output,$r,$w);
		}
		$output .='</ul>';
	}
	echo $output;
}
function smc_format_weibo_data(&$output,$r,$w,$_c=''){
	extract( $r );
	$output .= '<li id="smc-'.$w['id'].'" class="smc-weibo'.$_c.' '.$weibo.'">';
	$text = $w['text']; $avatar = $w['avatar'] ? '<img width="'.$size.'" height="'.$size.'" class="avatar avatar-'.$size.'" src="'.$w['avatar'].'" alt="'.$w['author'].'" />':'';
	$replace = array($avatar,$w['author'],$text,$w['time'],$w['thumb'],$w['source'],$w['url']);
	$_format = array('%%avatar%%','%%author%%','%%excerpt%%','%%date%%','%%image%%','%%source%%','%%url%%');
	if($format){
		$output .= str_replace($_format,$replace,$format);
	}else{
		$output .= '<div class="smc-avatar"><img src="'.$w['avatar'].'" alt="'.$w['author'].'" /></div><div class="smc-author">'.$w['author'].'</div><div class="smc-excerpt">'.$text.'</div>';
	}
	if($retweet&&!empty($w['retweeted_status'])){
		$output .= '<ul class="smc-child smc-retweet-list">'; 
		smc_format_weibo_data(&$output,$r,$w['retweeted_status'],' smc-retweet-weibo');
		$output .= '</ul>'; 
	}
	$output .= '</li>';
}
function smc_time_since($timestamp) {
	$since = abs(time()-$timestamp); $gmt_offset = get_option('gmt_offset') * 3600;
	$timestamp += $gmt_offset; $current_time = mktime() + $gmt_offset;
	if(floor($since/3600)){
		if(gmdate('Y-m-d',$timestamp) == gmdate('Y-m-d',$current_time)){
			$output = '今天 ';
			$output.= gmdate('H:i',$timestamp);
		}else{
			if(gmdate('Y',$timestamp) == gmdate('Y',$current_time)){
				$output = gmdate('m月d日 H:i',$timestamp);
			}else{
				$output = gmdate('Y年m月d日 H:i',$timestamp);
			}
		}
	}else{
		if(($output=floor($since/60))){
			$output = $output.'分钟前';
		}else $output = '刚刚';
	}
	return $output;
}
function smc_to_html($text='',$weibo=''){
	$text = make_clickable($text);
	$text = preg_replace_callback('/@([\x{4e00}-\x{9fa5}0-9A-Za-z_\-]+)/iu', '_smc_'.$weibo.'_make_at_user', $text);
	$text = $weibo=='twitter'||$weibo=='163'?preg_replace_callback('/#([^#\s]+)#?/is', '_smc_'.$weibo.'_make_topic', $text):preg_replace_callback('/\#([^#]+?)#/is', '_smc_'.$weibo.'_make_topic', $text);
	return $text;
}