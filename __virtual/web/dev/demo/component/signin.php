<?php

/*
	@Title: 登录框
	@Description: Sign in panel
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

$t_dirname = 'demo';
$t_pathname = $oc_project->pathname;
$t_dirdemo = $oc_project->root . substr($t_pathname, 0, (strpos($t_pathname, $t_dirname) + strlen($t_dirname))) . '/';
$t_dirpath = $oc_project->mainSite . 'common/javascript/';
$t_filename = array_pop(CLS_Utils::pathname());

$oc_siteinfo['title'] = '登录框';
$oc_res['css'] = array(
	$t_dirdemo . 'css/' . $t_filename . '.css'
);
$oc_res['js'] = array(
	$t_dirpath . 'library/jquery/jquery-1.6.1.min.js',
	$t_dirdemo . 'javascript/' . $t_filename . '.js'
);

$oc_project->html_header(); ?>
		<form action="#" method="get">
			<dl>
				<dt>用户名</dt>
				<dd><input type="text" placeholder="输入用户名"></dd>
				<dt><span>密</span>码</dt>
				<dd><input type="password" placeholder="输入密码"></dd>
				<dt>验证码</dt>
				<dd><input type="text" placeholder="输入验证码"></dd>
				<dt class="hide-text">登录</dt>
				<dd><input type="submit" value="登录"></dd>
			</dl>
		</form>
<?php

$oc_project->html_footer();

?>