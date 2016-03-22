<?php

/*
	@Title: 关于停止使用 QQ 空间服务
	@Description: 关于 QQ 空间关闭的说明
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$root = $oc_project->root;

$temp_dir = CLS_Utils::pathname();
$temp_dir = $oc_project->root . array_shift($temp_dir) . '/';

$oc_siteinfo['title'] = '关于停止使用 QQ 空间服务';
$oc_siteinfo['blog'] = 'http://blog.ourai.ws/';
$oc_res['css'] = array($temp_dir . 'notice.css');

$oc_project->html_header();

$temp_author = $oc_siteinfo['author']['zh']; ?>
		<div id="content">
			<h1><?php echo $oc_siteinfo['title']; ?></h1>
			<p>因为决定停止使用 QQ 空间服务，于是在 2013 年 2 月 28 日那天将其关闭了。对于给您造成的不便表示深深的歉意和愧疚……希望能够得到您的谅解。</p>
			<p>若您愿意继续关注本人所写的与日常生活、心情状态及人生感悟相关的文章的话，请<a href="<?php echo $oc_siteinfo['blog']; ?>" title="访问<?php echo $temp_author; ?>的博客">移步到本人的博客</a>。需要注册帐号的话请查看<a href="<?php echo $oc_siteinfo['site']; ?>guide/signup/" title="手把手教您办理通行证">帐号注册向导</a>。</p>
			<p>由于目前帐号功能是用 WordPress 提供的，所以用户体验欠佳，例如：</p>
			<ul class="n-rst">
				<li>用户名只能输入字母和数字</li>
				<li>登录进系统后基本没什么东西</li>
				<li>...</li>
			</ul>
			<p>现阶段暂且这样，请您忍耐，之后会陆续对各方面进行优化，包括：</p>
			<ul class="n-rst">
				<li>针对智能手机、平板电脑等移动设备（操作系统为 iOS、Android 等）用户做出相应的界面调整</li>
				<li>用户控制台中信息展示</li>
				<li>...</li>
			</ul>
			<p>除了以上提到的关于个人的文章之外，有时还会发表关于网络开发、文化及语言等方面的文章。如果您有兴趣，可到<a href="<?php echo $oc_siteinfo['site']; ?>categories/" title="查看文章分类">文章分类页面</a>选择。</p>
			<p id="signature"><span><?php echo $temp_author; ?></span><span>2013.03.05 01:35</span></p>
		</div>
<?php

$oc_project->html_footer();

?>