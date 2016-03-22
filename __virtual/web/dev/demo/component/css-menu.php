<?php

/*
	@Title: CSS 菜单
	@Description: 只用 HTML 和 CSS 做的菜单
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

$t_pathname = CLS_Utils::pathname();

$oc_siteinfo['title'] = 'CSS 菜单';
$oc_res['css'] = array($oc_project->root . array_shift($t_pathname) . '/css/' . array_pop($t_pathname) . '.css');

$oc_project->html_header(); ?>
		<div id="header">
			<div class="layout-content">
				<span id="logo">Static Menu</span>
				<ul id="navigator">
					<li><a href="javascript:void(0);" title="首页">Home</a></li>
					<li><a href="javascript:void(0);" title="博客">Blog</a></li>
					<li><a href="javascript:void(0);" title="相册">Album</a></li>
					<li><a href="javascript:void(0);" title="项目">Projects</a></li>
				</ul>
				<dl id="account">
					<dt>
						<img class="avatar_32" src="http://0.gravatar.com/avatar/0565b1df14e0b4a1a9cdecb3f085cdba?s=128&d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D128&r=G" alt="头像">
						<span><?php echo $oc_siteinfo['author']['zh']; ?></span>
						<i>arrow</i>
					</dt>
					<dd>
						<ul>
							<li><a href="javascript:void(0);" title="帐号设置">Account settings</a></li>
							<li><a href="javascript:void(0);" title="退出系统">Sign out</a></li>
						</ul>
					</dd>
				</dl>
			</div>
		</div>
		<div id="container" class="layout-content">
			<ul id="menu">
				<li class="menu-item"><a href="javascript:void(0);" title="">Life style</a></li>
				<li class="menu-item"><a href="javascript:void(0);" title="">Three-outlooks</a></li>
				<li class="menu-item">
					<a href="javascript:void(0);" title="">Web developement</a>
					<ul class="submenu">
						<li><a href="javascript:void(0);" title="">Front-end Development</a></li>
						<li><a href="javascript:void(0);" title="">Back-end Development</a></li>
					</ul>
				</li>
				<li class="menu-item"><a href="javascript:void(0);" title="">Methodology</a></li>
				<li class="menu-item"><a href="javascript:void(0);" title="">Woolgather</a></li>
			</ul>
			<div id="content">
				<input type="text" class="fr" placeholder="搜索">
			</div>
		</div>
<?php

$oc_project->html_footer();

?>