<?php

/*
  @Title: 徒步基本知识
  @Description: 在进行徒步穿越之前必须了解的事情
  @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$oc_siteinfo['title'] = '徒步基本知识';
$oc_siteinfo['keywords'] = '户外, outdoor, 徒步, 远足, 健行, 爬山, trekking, hiking';
$oc_siteinfo['desc'] = '';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
      <a href="javascript:void(0);" class="catalog_title">目录</a>
      <ul id="year_catalog" class="catalog_section">
        <li>– <a href="#TK_equipments" title="装备">装备</a></li>
        <li>– <a href="#TK_notices" title="注意事项">注意事项</a></li>
      </ul>
<?php
}

function template_doc_content() { ?>
      <h2 id="TK_equipments" class="n-rst"><span class="symbol">&#9798;</span> 装备</h2>
      <ol class="n-rst">
        <li>
          <b>徒步鞋</b>
          <p class="first">有效保护脚在越野过程中将伤害减到最低。</p>
        </li>
        <li>
          <b>背包（带防雨罩）</b>
          <p class="first">一个好的背包会将重量分散到整个背部，可以大大减轻在长时间行走时双肩的负担。</p>
        </li>
        <li>
          <b>偏光太阳镜</b>
          <p class="first">过滤掉多余的反射光等对眼睛有害以及对视力产生障碍的光线。</p>
        </li>
        <li>
          <b>护膝</b>
          <p class="first">保护膝盖，主要减轻下山时给膝盖带来的巨大冲击力。膝盖已经受伤的更要佩戴了！</p>
        </li>
        <li>
          <b>登山杖/行走杖</b>
          <p class="first">减轻膝盖的负担、探路、打草惊蛇、当作武器与野兽搏斗。</p>
        </li>
        <li>指北针</li>
        <li>地图</li>
        <li>
          <b>头灯</b>
          <p class="first">夜爬必备！虽然用手电也可以照明，不过会占用一只手。解放双手，方便与野兽和坏蛋搏斗！</p>
        </li>
        <li>护踝</li>
        <li>急救箱</li>
        <li>硬壳夹克</li>
        <li>防水裤</li>
        <li>GPS</li>
      </ol>
      <h2 id="TK_notices" class="n-rst"><span class="symbol">&#9798;</span> 注意事项</h2>
      <ul class="n-rst">
        <li>
          <b>防止蚊虫叮咬</b>
          <p class="first">山上蚊子很多，草丛里也不一定有什么虫子，为了防止被叮咬或吸血，需要“全副武装”：穿长筒厚袜子，不仅防蚊虫还能避免鞋磨脚；穿裤腿可系紧的长裤，防止虫子之类的沿裤管爬进去；根据气温和喜好来穿长袖衣服或短袖配手臂护套（套袖）。</p>
        </li>
        <li>了解常见危险野生动物应对方法</li>
        <li>掌握户外求生（求救）知识</li>
        <li>为了防止滑倒尽量不要走在落叶上</li>
        <li>离不长叶子并且树干看起来发糟的树木远点，树已被蛀死随时会倒</li>
      </ul>
      <!--
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
      -->
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>
