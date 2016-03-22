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

		<title><?php echo (is_home() ? get_bloginfo('name') : wp_title('', false) . ' &raquo; ' . get_bloginfo('name')); ?></title>
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="shortcut icon" href="http://www.ourai.ws/common/images/favicon.ico" />
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/css/class.css" />
		<link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
		<?php if ( is_single() ) : ?>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/css/post.css" />
		<?php elseif ( is_404() ) : ?>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/css/404.css" />
		<?php endif; ?>
	</head>
	<body>
		<div id="header">
			<div id="pad">
				<div id="siteInfo">
					<a id="title" href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
					<span id="tagline"><?php bloginfo( 'description' ); ?></span>
				</div>
				<!--<ul id="toolbar"></ul>-->
			</div>
			<ul id="navigator" class="clr"><?php global $ourai_cur_navi; if ( empty($ourai_cur_navi) ) { $ourai_cur_navi = 'home'; } ?>
				<li class="first<?php if ( is_home() ) { echo ' current'; } ?>"><a href="<?php bloginfo( 'url' ); ?>" title="首页">Home</a></li>
				<!--
				<li<?php if ( $ourai_cur_navi == 'categories' ) { echo ' class="current"'; } ?>><a href="<?php bloginfo( 'url' ); ?>/categories" title="类别">Categories</a></li>
				<li><a href="javascript:void(0);" title="演示">Demo</a></li>
				<li class="last"><a href="javascript:void(0);" title="教程">Tutorial</a></li>
				-->
			</ul>
			<!--
			<?php wp_list_categories('title_li=0&orderby=name'); ?>
			-->
		</div>
		<div id="wrapper" class="clr">
