<div class="wrap" style="-webkit-text-size-adjust:none;">
	<div class="icon32" id="icon-options-general"><br></div>
	<h2>将微博绑定到你的当前账户</h2><br/><br/>
<?php
	$wpuid=get_current_user_id(); $smc_url = WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__));
	$callback="&callback_url=".smc_menu_page_url('smc_bind_weibo_acount');
	if(isset($_GET['oauth_token']) && $_GET['oauth_token'] !==''){
		$weibo=$_SESSION["smc_weibo"];
		if($weibo){
			switch($weibo){
				case 'sinaweibo':
						include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
						$r = smc_sina_verify_credentials();
						break;
				case 'qqweibo':
						include dirname(__FILE__).'/qqweibo/qqOAuth.php';
						$r = smc_qq_verify_credentials();
						break;
				case 'douban':
						include dirname(__FILE__).'/douban/doubanOAuth.php';
						$r = smc_douban_verify_credentials();
						break;
				case 'sohuweibo':
						include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
						$r = smc_sohu_verify_credentials();
						break;
				case '163weibo':
						include dirname(__FILE__).'/163weibo/163OAuth.php';
						$r = smc_163_verify_credentials();
						break;
				case 'twitter':
						include dirname(__FILE__).'/twitter/twitterOAuth.php';
						$r = smc_twitter_verify_credentials();
						break;
				case 'fanfou':
						include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
						$r = smc_fanfou_verify_credentials();
						break;
				default:break;
			}
			if(!(is_array($r)||$r['user_login'])){
				wp_die("An error occurred.");
			}
			if($__wpuid=smc_get_user_by_meta('smc_weibo_bind',$r['weibo'].'|'.$r['user_login'])){
				$_user=get_user_by('id',$__wpuid);
				wp_die('此微博已经绑定了账号(<b>'.$_user->user_login.'</b>)，如果要绑定到此账户，请先解除与<b>'.$_user->user_login.'</b>的绑定。<br/><br/><a href="javascript:window.close();">点击这里关闭窗口</a>');
			}else{
				$smc_array = array (
					"avatar" => $r['profile_image_url'],
					"smcweibo" => $r['weibo'],
					"username" => $r['user_login'],
					"oauth_access_token" => $r['oauth_access_token'],
					"oauth_access_token_secret" => $r['oauth_access_token_secret']
				);
				update_usermeta($wpuid, 'smcdata', $smc_array);
				update_usermeta($wpuid, 'smc_weibo_bind' , $weibo.'|'.$r['user_login']);
			}
		}
	}
	if($_GET['delete']){
		delete_usermeta($wpuid, 'smc_weibo_bind');
		delete_usermeta($wpuid, 'smcdata');
	}
	$weibo_bind=get_usermeta($wpuid, 'smc_weibo_bind');
	if($weibo_bind){
		$weibo_bind=explode('|',$weibo_bind);
		$_weibo=$weibo_bind[0];$_weiboname=smc_get_weibo_name($_weibo);
		echo '<div id="weibobind"><img class="smc_img" src="'.$smc_url.'/images/'.$_weibo.'.png" /><a href="'.smc_menu_page_url('smc_bind_weibo_acount',false).'&delete='.$_weibo.'&weiboname='.$_weiboname.'"><input type="submit" class="button-primary" value="删除'.$_weiboname.'绑定"></a><br/>微博账号: '.$weibo_bind[1].'</div>';
	}else{
?> 你只能绑定一个微博账号到当前账号<br/><br/>
	<ul class="smc_connect_area smc_button">
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=sinaweibo<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/sina_button.png" alt="使用新浪微博登陆" /></li>
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=qqweibo<?php echo $callback; ?>", "","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/qq_button.png" alt="使用腾讯微博登陆" /></li>
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=sohuweibo<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/sohu_button.png" alt="使用搜狐微博登陆" /></li>
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=163weibo<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/163_button.png" alt="使用网易微博登陆" /></li>
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=douban<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/douban_button.png" alt="使用豆瓣账号登陆" /></li>
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=twitter<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/twitter_button.png" alt="Login with Twitter" /></li>
		<li><img class="smc_img" onclick='window.open("<?php echo $smc_url; ?>/start-connect.php?socialmedia=fanfou<?php echo $callback; ?>", "smcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $smc_url; ?>/images/fanfou_button.png" alt="使用饭否账号登陆" /></li>
	</ul>
	<script type="text/javascript">
		window.smc_reload=function(url){
		   if(!url)url=location.href.replace(/#.*|&delete.*/i,'');
		   window.location.href = url;
		  // setTimeout(function(){location.reload()},1300);
		}
    </script>
<?php
	}
?>
	<br/><br/><p><strong style="color:red;">注意：</strong>绑定后你可以使用此微博连接登陆你的现在的账号。如果你绑定的微博此前在本站连接登陆过，那么此次绑定将会暂时屏蔽原来的微博账号，解除绑定后原来的微博账号也可继续使用。</p>
</div>
