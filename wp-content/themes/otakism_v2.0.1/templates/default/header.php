<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php if(is_home()) { echo 'class="home"'; } ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta http-equiv="Content-Language" content="<?php bloginfo('language'); ?>" />
		<!-- <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> -->
		<meta name="keywords" content="宅文化, 御宅族, 宅男, otaku, wota, 动漫, acg, 二次元, nico, vocaloid, web前端, javascript, js, html, xhtml, css, php, 生活, life, diary, 技术, 研究" />
		<meta name="description" content="<?php bloginfo('name'); echo ' - '; if(is_single()) { single_post_title('', true); } else { bloginfo("description"); } ?>" />
		<meta name="author" content="欧雷" />
		<meta name="copyright" content="宅男的部屋 版权所有" />

		<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
		<link rel="shortcut icon" href="http://www.ourai.ws/common/images/favicon.ico" />
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="" />
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style>
		<link rel="stylesheet" media="screen" href="<?php echo $ourai_wpurl; ?>/common/css/reset.css" />
		<link rel="stylesheet" media="screen" href="<?php echo $ourai_wpurl; ?>/common/css/global.css" />
		<link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_directory'); ?>/css/skin/default.css" />
		<link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_directory'); ?>/detail.css" />
		<link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_directory'); ?>/plugin.css" />
		<!--[if IE]>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie-fix.css" />
		<![endif]-->
		<link rel="stylesheet" media="screen" href="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/styles/shCoreDefault.css" />
		<link rel="stylesheet" media="screen" href="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/styles/shThemeDefault.css" />
		<link rel="stylesheet" media="screen" href="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/shadowbox/ShadowBox.css" />
		
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/scripts/shCore.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/scripts/shBrushXml.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/scripts/shBrushCss.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/scripts/shBrushJScript.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/syntaxhighlighter/scripts/shBrushPhp.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/plugin/shadowbox/ShadowBox.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/sharebutton.js"></script>
		<script type="text/javascript" src="<?php echo $ourai_wpurl; ?>/common/javascript/return-to-top.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/javascript/base.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/javascript/menu.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/javascript/index.js"></script>

		<?php wp_head(); ?>
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-11832370-2']);
		  _gaq.push(['_setDomainName', '.otakism.com']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</head>
	<?php 
		/*
		参考网站：
		http://www.saintjohnsbible.org/
		http://kilianmuster.com/
		http://crushlovely.is/
		http://designinformer.com/
		*/
	?>
	<body>
		<?php
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/msie\s*(\d*)/i', $userAgent, $matchArray) && intval($matchArray[1]) < 7) :
				require_once('kill-ie6.php');
		?>
		<div id="forbid" class="absolutecenter">
			<div class="absolutecenter-wrapper">
				<div class="absolutecenter-content" style="color: #FFF; text-align: center; font-size: 26px;">系统检测到您的IE浏览器版本太低，<br />请升级浏览器或者更换其他标准浏览器，<br />谢谢！</div>
			</div>
		</div>
		<script>
			document.documentElement.style.overflow = "hidden";
		</script>
		<?php endif; ?>
		<div id="wrapper">
			<div id="header">
				<div class="top clearfix">
					<ul id="navigationGlobal">
						<li><a href="http://www.ourai.ws/" title="聚合各站信息">引导页</a></li>
						<li class="current"><a href="http://blog.ourai.ws/" title="记录我的生活琐事">网络志</a></li>
						<li><a href="http://www.otakism.com/" title="致力于推广宅文化" target="_blank">多田酱</a></li>
						<li><a href="http://ourai.taobao.com/" title="代购日本正版音像制品" target="_blank">淘宝店</a></li>
					</ul>
					<ul id="toolbar">
						<li>asdasd</li>
						<li>asdasd</li>
						<li>asdasd</li>
						<li>asdasd</li>
					</ul>
				</div>
				<div class="middle clearfix"><img src="<?php bloginfo('stylesheet_directory') ?>/images/logo.png" alt="宅男的部屋" /></div>
				<div class="bottom clearfix">
					<ul id="navigationLocal">
						<li<?php if(is_home()) echo ' class=\'current_page_item\''; ?>><a href="<?php bloginfo('url'); ?>" title="博客首页">博客首页</a></li>
						<?php wp_list_categories('title_li=0&orderby=name'); ?>
					</ul>
				</div>
			</div>
			<!--[if lte IE 7]><div></div><![endif]-->
			<div id="main" class="clearfix">
				<div id="content">
