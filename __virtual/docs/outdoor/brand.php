<?php

/*
  @Title: 户外品牌
  @Description: 比较靠谱的户外装备品牌
  @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$oc_siteinfo['title'] = '户外品牌';
$oc_siteinfo['keywords'] = '户外, 户外装备, 户外品牌, 品牌, outdoor';
$oc_siteinfo['desc'] = '介绍比较靠谱的户外装备品牌';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
      <a href="javascript:void(0);" class="catalog_title">目录</a>
      <ul id="year_catalog" class="catalog_section">
        <li>– <a href="#BrandList" title="品牌列表">品牌列表</a></li>
      </ul>
<?php
}

function template_doc_content() { ?>
      <h2 id="BrandList" class="n-rst"><span class="symbol">&#9798;</span> 品牌列表</h2>
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
            <tr>
              <td>LA SPORTIVA</td>
              <td>意大利</td>
              <td>户外鞋</td>
            </tr>
            <tr>
              <td>koflach</td>
              <td>德国</td>
              <td>高山靴</td>
            </tr>
            <tr>
              <td>LOWA</td>
              <td>德国</td>
              <td>户外鞋</td>
            </tr>
            <tr>
              <td>CRISPI</td>
              <td>意大利</td>
              <td>户外鞋</td>
            </tr>
            <tr>
              <td>AKU</td>
              <td>意大利</td>
              <td></td>
            </tr>
            <tr>
              <td>ASOLO</td>
              <td>意大利</td>
              <td></td>
            </tr>
            <tr>
              <td>Zamberlan</td>
              <td>意大利</td>
              <td></td>
            </tr>
            <tr>
              <td>GARMONT</td>
              <td>意大利</td>
              <td></td>
            </tr>
            <tr>
              <td>Raichle</td>
              <td>瑞士</td>
              <td></td>
            </tr>
            <tr>
              <td>MILLET</td>
              <td>法国</td>
              <td></td>
            </tr>
            <tr>
              <td>Salomon</td>
              <td>法国</td>
              <td></td>
            </tr>
            <tr>
              <td>Vasque</td>
              <td>美国</td>
              <td>户外鞋、背包</td>
            </tr>
            <tr>
              <td>MEINDL</td>
              <td>德国</td>
              <td></td>
            </tr>
            <tr>
              <td>KAYLAND</td>
              <td>意大利</td>
              <td></td>
            </tr>
            <tr>
              <td>KEEN</td>
              <td>美国</td>
              <td></td>
            </tr>
            <tr>
              <td>DANNER</td>
              <td>美国</td>
              <td></td>
            </tr>
            <tr>
              <td>Montrail</td>
              <td>美国</td>
              <td></td>
            </tr>
            <tr>
              <td>Dolomite</td>
              <td>意大利</td>
              <td></td>
            </tr>
            <tr>
              <td>Bestard</td>
              <td>西班牙</td>
              <td></td>
            </tr>
            <tr>
              <td>THE NORTH FACE</td>
              <td>美国</td>
              <td>户外用品</td>
            </tr>
            <tr>
              <td>Columbia</td>
              <td>美国</td>
              <td>户外用品</td>
            </tr>
            <tr>
              <td>SALEWA</td>
              <td>德国</td>
              <td></td>
            </tr>
            <tr>
              <td>TIMBERLAND</td>
              <td>美国</td>
              <td></td>
            </tr>
            <tr>
              <td>Jack Wolfskin</td>
              <td>德国</td>
              <td>户外用品</td>
            </tr>
            <tr>
              <td>BUFF</td>
              <td>西班牙</td>
              <td>魔术头巾</td>
            </tr>
            <tr>
              <td>ARC'TERYX</td>
              <td>加拿大</td>
              <td>户外用品</td>
            </tr>
            <tr>
              <td>OSPREY</td>
              <td>美国</td>
              <td>背包</td>
            </tr>
            <tr>
              <td>GREGORY</td>
              <td>美国</td>
              <td>背包</td>
            </tr>
          </tbody>
        </table>
      </div>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>
