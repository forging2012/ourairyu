<?php

/*
	@Title: 双列表条目选择
	@Description: 双列表条目增删操作
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
$t_plugin = $t_dirpath . 'component/jquery-based/double-list/';
$t_filename = array_pop(CLS_Utils::pathname());

$oc_siteinfo['title'] = '双列表条目选择';
$oc_res['css'] = array(
	$t_plugin . $t_filename . '.css',
	$t_dirdemo . 'css/' . $t_filename . '.css'
);
$oc_res['js'] = array(
	$t_dirpath . 'library/jquery/jquery-1.6.1.min.js',
	$t_plugin . $t_filename . '.js',
	$t_dirdemo . 'javascript/' . $t_filename . '.js'
);

$oc_project->html_header(); ?>
		<div id="testList">
			<ul>
				<li>11111</li>
				<li>22222</li>
				<li>33333</li>
				<li><span>44444</span></li>
				<li><a>55555</a></li>
			</ul>
		</div>
<?php

$oc_project->html_footer();

?>