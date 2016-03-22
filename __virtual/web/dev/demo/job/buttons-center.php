<?php

/*
	@Title: 按钮组绝对居中
	@Description: 按钮组位置随着操作区域大小变化
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;

$oc_siteinfo['title'] = '按钮组绝对居中';
$oc_setting['limit_ie'] = false;

$oc_project->html_header(); ?>
		<style>
			.list { width: 600px; margin: 30px auto; background-color: whiteSmoke; }
			.item { position: relative; height: 80px; background-color: lightGray; }
			.area-display, .area-operation { text-align: center; height: 100%; }
			.area-display { background-color: pink; overflow: hidden; }
			.area-operation {
				width: 140px;
				padding: 0 1em;
				border-left: 1px solid #A6A6A6;
				background-color: lightBlue;
				position: relative;
				float: right;
			}
			.button-group { position: absolute; left: 1em; top: 50%; margin-top: -12px; }
			.button {
				float: left;
				margin-left: 10px;
				width: 40px; height: 24px;
				background-color: red;
			}
			.button:first-child { margin-left: 0; }
		</style>
		<ul class="list">
			<li class="item">
				<div class="area-operation">
					<span>Operation Area</span>
					<div class="button-group">
						<span class="button">A</span>
						<span class="button">B</span>
						<span class="button">C</span>
					</div>
				</div>
				<div class="area-display">Display Area</div>
			</li>
		</ul>
<?php

$oc_project->html_footer();

?>