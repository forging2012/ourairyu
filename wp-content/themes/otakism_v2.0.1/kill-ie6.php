<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="zh-CN" />

		<title>宅男的部屋 &raquo; IE6再见！</title>
		
		<link rel="shortcut icon" href="<?php bloginfo('wpurl'); ?>/common/images/favicon.ico" />
		<link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_directory'); ?>/kill-ie6.css" />
		
		<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/common/javascript/jquery-1.6.1.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".tab").click(function() {
					$(".tab").removeClass("current");
					$(this).addClass("current");
				});
			});
		</script>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<img src="<?php bloginfo('template_url'); ?>/images/ie6-trash-small.jpg" alt="Kill IE6" />
				<h1>再见！IE6</h1>
				<p>您正在使用 Internet Explorer 6，它是<strong>一个巨大的安全隐患</strong>！请进行<a href="http://windows.microsoft.com/zh-CN/internet-explorer/downloads/ie" target="_blank">版本升级</a>或者更换一个更好、更快并且更安全的浏览器：Firefox，Chrome或者Safari。</p>
			</div>
			<div id="main">
				<ul id="navigator">
					<li class="tab current">
						<a href="javascript:void(0);" class="title" hidefocus="true">Home</a>
						<div class="description">
							<h2>为什么要对IE6说“再见”？</h2>
							<p>随着互联网的飞速发展，Web技术对浏览器的渲染能力要求越来越高，IE6这个出生于2000年初的昔日“皇者”，现在也不得不面临进坟墓的命运。<strong>为了您能够有更佳的浏览体验，请您对IE6说“再见”！</strong></p>
							<p>经过了10多年的磨砺，骇客的攻击技术更先进、手段更丰富，IE6的安全性和稳定性已经远远无法达到让您放心的标准。<strong>为了您电脑上的重要资料以及帐号安全，请您对IE6说“再见”！</strong></p>
						</div>
					</li>
					<li class="tab">
						<a href="javascript:void(0);" class="title" hidefocus="true">Download</a>
						<dl class="description">
							<dt><h3>Google Chrome</h3></dt>
							<dd>
								<img src="<?php bloginfo('template_url'); ?>/images/browser_chrome.jpg" alt="Chrome" />
								<p>由Google开发的一款设计简单、高效的Web浏览工具。其特点是简洁、快速。支持多标签浏览，每个标签页面都在独立的“沙箱”内运行，在提高安全性的同时，一个标签页面的崩溃也不会导致其他标签页面被关闭。此外，Google Chrome基于更强大的JavaScript V8引擎，这是当前Web浏览器所无法实现的。</p>
								<a href="http://www.google.cn/chrome" target="_blank">Download &raquo;</a>
							</dd>
							<dt><h3>Mozilla Firefox</h3></dt>
							<dd>
								<img src="<?php bloginfo('template_url'); ?>/images/browser_firefox.jpg" alt="Firefox" />
								<p>Mozilla Firefox是一个自由的，开放源码的浏览器，适用于Windows、Linux和Mac OS X平台。它体积小速度快，还有其它一些高级特征。主要特性有：标签式浏览，使上网冲浪更快；可以禁止弹出式窗口；自定制工具栏；扩展管理；更好的搜索特性；快速而方便的侧栏。</p>
								<a href="http://www.firefox.com.cn/download/" target="_blank">Download &raquo;</a>
							</dd>
							<dt><h3>Apple Safari</h3></dt>
							<dd class="last">
								<img src="<?php bloginfo('template_url'); ?>/images/browser_safari.jpg" alt="Safari" />
								<p>苹果计算机的最新作业系统Mac OS X中新的浏览器，用来取代之前的Internet Explorer for Mac。Safari使用了KDE的KHTML作为浏览器的运算核心。目前该浏览器已支持Windows平台，但是与运行在Mac OS X上的safari相比，有些功能出现丢失。</p>
								<a href="http://www.apple.com.cn/safari/" target="_blank">Download &raquo;</a>
							</dd>
						</dl>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>