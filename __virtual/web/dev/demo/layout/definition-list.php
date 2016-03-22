<?php

/*
    @Title: 信息介绍列表
    @Description: 用 dl 实现的信息介绍类“表格”
    @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

$oc_setting['limit_ie'] = false;

$t_dirname = 'demo';
$t_pathname = $oc_project->pathname;
$t_dirdemo = $oc_project->root . substr($t_pathname, 0, (strpos($t_pathname, $t_dirname) + strlen($t_dirname))) . '/';
$t_pathnameArray = CLS_Utils::pathname();
$t_filename = array_pop($t_pathnameArray);

$oc_siteinfo['title'] = '信息介绍列表';
$oc_res['css'] = array(
    $oc_project->common . 'css/base.css',
    $t_dirdemo . 'css/' . $t_filename . '.css'
);

$oc_project->html_header(); ?>
        <div id="content">
            <pre>dl, dd { overflow: hidden; *zoom: 1; }
dt { width: 10em; float: left; text-align: right; padding-right: 1.5em; }
dd { margin-bottom: 1.5em; padding-left: .5em; }</pre>
            <dl class="overview-list">
                <dt>价格</dt>
                <dd class="price"><small>￥</small><b>1599.00 - 1999.00</b></dd>
                <dt>配送</dt>
                <dd>北京 至 杭州 快递：10.00 EMS：20.00</dd>
                <dt>月销量</dt>
                <dd>11 件</dd>
                <dt>颜色分类</dt>
                <dd class="dib-wrap group-style">
                    <label class="dib selected"><input type="radio" name="stype" checked="checked">柜台展示机 特价机 马里奥红</label>
                    <label class="dib"><input type="radio" name="stype">柜台展示机 特价机 马里奥白</label>
                    <label class="dib"><input type="radio" name="stype">单机标配全新机建议购买套餐一</label>
                    <label class="dib"><input type="radio" name="stype">发顺丰马里奥银色+2款中文游戏</label>
                    <label class="dib"><input type="radio" name="stype">发顺丰马里奥红色+2款中文游戏</label>
                    <label class="dib"><input type="radio" name="stype">发顺丰马里奥白色+2款中文游戏</label>
                </dd>
                <dt>游戏机套餐</dt>
                <dd class="dib-wrap group-price">
                    <label class="dib"><input type="radio" name="plan">单机标配</label>
                    <label class="dib"><input type="radio" name="plan">套餐一</label>
                    <label class="dib"><input type="radio" name="plan">套餐二</label>
                    <label class="dib selected"><input type="radio" name="plan" checked="checked">套餐三</label>
                    <label class="dib"><input type="radio" name="plan">套餐四</label>
                    <label class="dib"><input type="radio" name="plan">套餐五</label>
                </dd>
                <dt>数量</dt>
                <dd><input type="text" value="1"></dd>
            </dl>
        </div>
<?php

$oc_project->html_footer();

?>