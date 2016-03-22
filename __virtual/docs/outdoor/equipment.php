<?php

/*
  @Title: 户外装备
  @Description: 
  @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$oc_siteinfo['title'] = '户外装备';
$oc_siteinfo['keywords'] = '户外, 户外装备, 装备, outdoor, 背包, 衣裤';
$oc_siteinfo['desc'] = '介绍比较靠谱的户外装备品牌';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
      <a href="javascript:void(0);" class="catalog_title">目录</a>
      <ul id="year_catalog" class="catalog_section">
        <li>– <a href="#" title="">背包</a></li>
        <li>– <a href="#" title="">上衣</a></li>
        <li>– <a href="#" title="">裤子</a></li>
        <li>– <a href="#" title="">鞋子</a></li>
      </ul>
<?php
}

function template_doc_content() { ?>
      <h2 id="CategoryList" class="n-rst"><span class="symbol">&#9798;</span> 品牌列表</h2>
      <div class="view-wrapper">
        <table class="view-list">
          <colgroup>
            <col style="width: 160px;">
            <col style="width: 120px;">
            <col>
          </colgroup>
          <thead>
            <tr>
              <th>名称</th>
              <th>国家</th>
              <th>侧重</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>SCARPA</td>
              <td>意大利</td>
              <td>户外鞋</td>
            </tr>
          </tbody>
        </table>
      </div>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>
