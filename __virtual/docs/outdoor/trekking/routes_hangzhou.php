<?php

/*
  @Title: 杭州徒步路线
  @Description: 杭州的一些徒步路线
  @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$oc_siteinfo['title'] = '杭州徒步路线';
$oc_siteinfo['keywords'] = '户外, outdoor, 徒步, 远足, 健行, 爬山, trekking, hiking, 杭州, 路线, route, Hangzhou';
$oc_siteinfo['desc'] = '';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
      <a href="javascript:void(0);" class="catalog_title">目录</a>
      <ul id="year_catalog" class="catalog_section">
        <li>– <a href="#" title="环西湖群山毅行">环西湖群山毅行</a></li>
        <li>– <a href="#" title="杭州西山森林公园——十里龙脊">杭州西山森林公园——十里龙脊</a></li>
        <li>– <a href="#" title="万林背山">万林背山</a></li>
      </ul>
<?php
}

function template_doc_content() { ?>
      <p>暂无内容，请稍候...</p>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>
