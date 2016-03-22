<!DOCTYPE html> 
<html> 
	<head> 
		<meta charset="UTF-8" />
		<meta http-equiv="Content-Language" content="zh-CN" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="keywords" content="宅文化, 御宅族, 宅男, otaku, wota, 动漫, acg, 二次元, nico, vocaloid" />
		<meta name="description" content="致力于推广宅文化" />
		<meta name="author" content="欧雷" />
		<meta name="copyright" content="宅文化发展推进会 版权所有" />

		<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="shortcut icon" href="http://www.ourai.ws/common/images/favicon.ico" />
		
		<link rel="stylesheet" media="screen" href="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/styles/shCoreDefault.css" />
		<link rel="stylesheet" media="screen" href="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/styles/shThemeDefault.css" />
		<!--
		<link rel="stylesheet" media="screen" href="http://www.ourai.ws/common/javascript/plugin/shadowbox/ShadowBox.css" />
		-->
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/css/class.css" />
		<!--
		<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Trade+Winds|Ruslan+Display|Mate+SC|Metamorphous|Medula+One|Voltaire|Smythe" />
		-->
		<link rel="stylesheet" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<?php if ( is_home() ) : ?>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/css/home.css" />
		<?php elseif ( is_single() ) : ?>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/css/post.css" />
		<?php endif; ?>
		<script src="<?php bloginfo('template_url'); ?>/javascript/jquery-1.7.1.min.js"></script>
		<script src="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/scripts/shCore.js"></script>
		<script src="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/scripts/shBrushXml.js"></script>
		<script src="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/scripts/shBrushCss.js"></script>
		<script src="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/scripts/shBrushJScript.js"></script>
		<script src="http://www.ourai.ws/common/javascript/plugin/syntaxhighlighter/scripts/shBrushPhp.js"></script>
		<!--
		<script src="http://www.ourai.ws/common/javascript/plugin/shadowbox/ShadowBox.js"></script>
		<script src="http://www.ourai.ws/common/javascript/sharebutton.js"></script>
		<script src="http://www.ourai.ws/common/javascript/return-to-top.js"></script>
		-->
		
		<?php if ( is_home() ) : ?>
		<script src="<?php bloginfo('template_url'); ?>/javascript/blog.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/javascript/main.js"></script>
		<?php elseif ( is_single() ) : ?>
		<script>
			// 初始化语法高亮
			SyntaxHighlighter.defaults["class-name"] = "syntaxhighlighter-ourai";
			SyntaxHighlighter.defaults["toolbar"] = false;
			SyntaxHighlighter.all();
		</script>
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>
	<body>
		<div id="wrapper">
