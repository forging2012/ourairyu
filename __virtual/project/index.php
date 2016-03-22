<?php

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$t_template = $oc_project->common . 'page/templates/ourai_ws_3/';

$oc_siteinfo['title'] = '项目';
$oc_siteinfo['keywords'] = '欧雷, 宅男, 部屋, 项目, ourai';
$oc_siteinfo['desc'] = '项目';
$oc_res['css'] = array(
	$t_template . 'css/global.css',
	$t_template . 'css/main.css'
);

unset($t_template);

$oc_project->html_header(); ?>
		<style>
			body { background-image: url("http://ourai.ws/common/page/templates/ourai_ws_3/image/bg-content-kai.png"); }
			
			#project_area .abs-ctr-cnt { font: bold 2.8em/1.5 Georgia; text-align: center; text-shadow: 0 1px #F5F5F5, 0 0 15px #FFF; }
			#project_area a { text-decoration: underline; }
		</style>
		<div id="project_area" class="abs-ctr">
			<div class="abs-ctr-wrp">
				<div class="abs-ctr-cnt">Projects &raquo; <a href="http://ourai.ws/">ourai.ws</a></div>
			</div>
		</div>
<?php
$oc_project->html_footer(); ?>