<?php
include "../../../wp-config.php";
function smc_showErr($ErrMsg) {
    header('HTTP/1.0 500 Internal Server Error');
	header('Content-Type: text/plain;charset=UTF-8');
    echo $ErrMsg;
    exit;
}
$weibo=$_GET['socialmedia'];
$callback_url = $_GET['callback_url']? $_GET['callback_url']:get_option('home');
if(empty($weibo)){
	smc_showErr('Unknow request!');
}else{
	$weibo=trim($weibo);
	switch($weibo){
		case 'sinaweibo':
				if(!class_exists('WeiboOAuth')){
					include dirname(__FILE__).'/sinaweibo/sinaOAuth.php';
				}
				$to = new WeiboOAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeURL($tok['oauth_token'],true,$callback_url);
				wp_redirect($request_link);
				break;
		case 'qqweibo':
				if(!class_exists('MBOpenTOAuth')){
					include dirname(__FILE__).'/qqweibo/qqOAuth.php';
				}
				$to = new MBOpenTOAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);//print_r($tok);die();
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeURL($tok['oauth_token'],true,$callback_url);//print_r($request_link);die();
				wp_redirect($request_link);
				break;
		case 'douban':
				if(!class_exists('doubanOAuth')){
					include dirname(__FILE__).'/douban/doubanOAuth.php';
				}
				$to = new doubanOAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeURL($tok['oauth_token'],true,$callback_url);
				wp_redirect($request_link);
				break;
		case 'sohuweibo':
				if(!class_exists('sohuOAuth')){
					include dirname(__FILE__).'/sohuweibo/sohuOAuth.php';
				}
				$to = new SohuOAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);//print_r($tok);die();
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeUrl1($tok['oauth_token'],$callback_url);
				header('Location:'.$request_link);
				break;
		case '163weibo':
				if(!class_exists('Weibo163OAuth')){
					include dirname(__FILE__).'/163weibo/163OAuth.php';
				}
				$to = new Weibo163OAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);//print_r($tok);die();
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeURL($tok['oauth_token'],true,$callback_url);
				wp_redirect($request_link);
				break;
		case 'twitter':
				if(!class_exists('twitterOAuth')){
					include dirname(__FILE__).'/twitter/twitterOAuth.php';
				}
				$to = new TwitterOAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);//print_r($tok);die();
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeURL($tok['oauth_token'],true);
				wp_redirect($request_link);
				break;
		case 'fanfou':
				if(!class_exists('FanfouOAuth')){
					include dirname(__FILE__).'/fanfou/fanfouOAuth.php';
				}
				$to = new FanfouOAuth($APP_KEY, $APP_SECRET);
				$tok = $to->getRequestToken($callback_url);//print_r($tok);die();
				$_SESSION["smc_oauth_token_secret"] = $tok['oauth_token_secret'];
				$_SESSION["smc_weibo"] = $weibo;
				$request_link = $to->getAuthorizeURL($tok['oauth_token'],$callback_url);
				wp_redirect($request_link);
				break;
		case 'follow5':
				$_SESSION["smc_weibo"] = 'follow5';
				$split=stripos($callback_url,'?')===false?'?':'&';
				$_flag=is_user_logged_in()?'follow5':'_follow5';
				$request_link = $callback_url.$split.'oauth_token='.$_flag;
				wp_redirect($request_link);
				break;
		case 'zuosa':
				$_SESSION["smc_weibo"] = 'zuosa';
				$split=stripos($callback_url,'?')===false?'?':'&';
				$_flag=is_user_logged_in()?'zuosa':'_zuosa';
				$request_link = $callback_url.$split.'oauth_token='.$_flag;
				wp_redirect($request_link);
				break;
		case 'wbto':
				$_SESSION["smc_weibo"] = 'wbto';
				$split=stripos($callback_url,'?')===false?'?':'&';
				$_flag=is_user_logged_in()?'wbto':'_wbto';
				$request_link = $callback_url.$split.'oauth_token='.$_flag;
				wp_redirect($request_link);
				break;
		default:wp_die('<h2>Unknow request!</h2>');break;
	}
	exit;
}
?>
