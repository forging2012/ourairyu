<?php

/*
	@Title: 标签页
	@Description: Tabs
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

$oc_siteinfo['title'] = '标签页';
$oc_res['css'] = array(
	$t_dirdemo . 'css/' . $t_filename . '.css'
);
$oc_res['js'] = array(
	$t_dirpath . 'library/jquery/jquery-1.6.1.min.js',
	$t_dirdemo . 'javascript/' . $t_filename . '.js'
);

$oc_project->html_header(); ?>
		<div class="tab-wrapper">
			<div class="tab-group">
				<a href="#" class="tab-trigger current" data-flag="tab_1">tab-1 title</a>
				<a href="#" class="tab-trigger" data-flag="tab_2">tab-2 title</a>
				<a href="#" class="tab-trigger" data-flag="tab_3">tab-3 title</a>
			</div>
			<div class="tab-content current" data-flag="tab_1">tab-1 content</div>
			<div class="tab-content" data-flag="tab_2">tab-2 content</div>
			<div class="tab-content" data-flag="tab_3">tab-3 content</div>
		</div>
<?php

$oc_project->html_footer();

?>