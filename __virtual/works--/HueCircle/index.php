<?php

/*
	@Title: 色相环
	@Description: 用 SVG/VML 绘制色相环
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$root = $oc_project->root;

$temp_dir = $oc_project->root . $oc_project->pathname;

$oc_siteinfo['title'] = '色相环';
$oc_res['css'] = array(
	$oc_project->common . 'css/doc.css',
	$temp_dir . 'HueCircle.css'
);
$oc_res['js'] = array(
	($oc_project->common . 'javascript/library/jquery/jquery-1.7.1.min.js'),
//	($oc_project->common . 'javascript/library/regular-polygon.js'),
	($temp_dir . 'regular-polygon-min.js'),
	($temp_dir . 'HueCircle.js')
);

$oc_project->html_header(); ?>
		<form id="consoleArea" class="catalog">
			<h3><span>设置色相环参数</span></h3>
			<dl>
				<dt style="display: none;">色相环半径</dt>
				<dd style="display: none;"><input type="text" name="h_radius" value="150"> 像素</dd>
				<dt>颜色点半径</dt>
				<dd><input type="text" name="p_radius" value="20"> 像素</dd>
				<dt>颜色点数量</dt>
				<dd><input type="text" name="p_count" value="24"> 个</dd>
			</dl>
			<input id="submit" type="submit" value="确定">
		</form>
		<div id="displayArea" class="page">
			<div id="content"></div>
		</div>
<?php

$oc_project->html_footer();

?>