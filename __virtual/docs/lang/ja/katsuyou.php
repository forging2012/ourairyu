<?php

/*
	@Title: 日语活用形相关
	@Description: 日语活用形相关
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$oc_siteinfo['title'] = '日语活用形相关';
$oc_siteinfo['keywords'] = '日语, 日本文化, 学习, 活用形, 敬语';
$oc_siteinfo['desc'] = '统计动画收藏情况';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
			<a href="javascript:void(0);" class="catalog_title">目录</a>
			<ul id="year_catalog" class="catalog_section">
				<li>– <a href="#Doushi_Katsuyou" title="动词活用形对照">动词活用形对照</a></li>
				<li>– <a href="#Keigou" title="敬语">敬语</a></li>
			</ul>
<?php
}

function template_doc_content() { ?>
			<h2 id="Doushi_Katsuyou" class="n-rst"><span class="symbol">&#9798;</span> 动词活用形对照</h2>
			<div class="view-wrapper">
				<table class="view-list">
					<colgroup>
						<col style="width: 200px;">
						<col style="width: 250px;">
						<col>
					</colgroup>
					<thead>
						<tr>
							<th>日语教育</th>
							<th>学校教育</th>
							<th>例</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>否定形</td>
							<td>未然形＋助动词ナイ</td>
							<td>書かない</td>
						</tr>
						<tr>
							<td>意志形</td>
							<td>未然形＋助动词ウ／ヨウ</td>
							<td>書こう</td>
						</tr>
						<tr>
							<td>被动形</td>
							<td>未然形＋助动词レル／ラレル</td>
							<td>書かれる</td>
						</tr>
						<tr>
							<td>使役形</td>
							<td>未然形＋助动词セル／サセル</td>
							<td>書かせる</td>
						</tr>
						<tr>
							<td>マス形</td>
							<td>连用形＋助动词マス</td>
							<td>書きます</td>
						</tr>
						<tr>
							<td>テ形</td>
							<td>连用形＋接续动词テ</td>
							<td>書いて</td>
						</tr>
						<tr>
							<td>タ形</td>
							<td>连用形＋助动词タ</td>
							<td>書いた</td>
						</tr>
						<tr>
							<td>タリ形・タラ形</td>
							<td>连用形＋助动词タリ以及该活用形</td>
							<td>書いたり</td>
						</tr>
						<tr>
							<td>词典形</td>
							<td>终止形、连体形</td>
							<td>書く</td>
						</tr>
						<tr>
							<td>バ形</td>
							<td>假定形＋接续助词バ</td>
							<td>書けば</td>
						</tr>
						<tr>
							<td rowspan="2">可能形</td>
							<td>五段动词：可能动词</td>
							<td>書ける</td>
						</tr>
						<tr>
							<td>一段动词：未然形＋助动词ラレル</td>
							<td>食べられる</td>
						</tr>
						<tr>
							<td>命令形</td>
							<td>命令形</td>
							<td><span>書け</td>
						</tr>
					</tbody>
				</table>
			</div>
			<h2 id="Keigou" class="n-rst" ><span class="symbol">&#9798;</span> 敬语</h2>
			<div class="view-wrapper">
				<table class="view-list">
					<colgroup>
						<col style="width: 100px;">
						<col style="width: 100px;">
						<col style="width: 120px;">
						<col>
					</colgroup>
					<thead>
						<tr>
							<th>三分类</th>
							<th>五分类</th>
							<th colspan="2">特征</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>尊敬語</td>
							<td>尊敬語</td>
							<td rowspan="2">素材敬語</td>
							<td>話題中の動作の主体が話し手よりも上位であることを表す語</td>
						</tr>
						<tr>
							<td rowspan="2">謙譲語</td>
							<td>謙譲語</td>
							<td>話題中の動作の客体が話題中の動作の主体よりも上位であることを表す語</td>
						</tr>
						<tr>
							<td>丁重語</td>
							<td rowspan="2">対者敬語</td>
							<td>聞き手が話し手よりも上位であることを表す語</td>
						</tr>
						<tr>
							<td rowspan="2">丁寧語</td>
							<td>丁寧語</td>
							<td>聞き手が話し手よりも上位であることを表す語尾の「です」「ます」「ございます」など</td>
						</tr>
						<tr>
							<td>美化語</td>
							<td>-</td>
							<td>上品とされる言い回し・言葉遣い</td>
						</tr>
					</tbody>
				</table>
			</div>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>