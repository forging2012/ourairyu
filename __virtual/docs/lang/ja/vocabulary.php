<?php

/*
    @Title: 词汇分类
    @Description: 
    @Privacy: public
*/

global $oc_siteinfo;
global $oc_project;

$oc_siteinfo['title'] = '词汇分类';
$oc_siteinfo['keywords'] = '词汇, 单词, 分类';
$oc_siteinfo['desc'] = '日语词汇分类';
//$oc_cmn_url = 'http://'.$_SERVER['HTTP_HOST'].'/common/';
//$temp_res = oc_get_siteurl() . 'docs/res/';
//$oc_res['css'] = array( $oc_cmn_url . 'css/doc.css', $temp_res . 'css/view.css' );
$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
            <a href="javascript:void(0);" class="catalog_title">目录</a>
            <ul id="year_catalog" class="catalog_section">
                <li>– <a href="#" title="">体</a></li>
            </ul>
<?php
}

function template_doc_content() { ?>
            <h2 id="Doushi_Katsuyou" class="n-rst"><span class="symbol">&#9798;</span> <ruby><rb>体</rb><rp>（</rp><rt>からだ</rt><rp>）</rp></ruby></h2>
            <ul>
                <li><ruby><rb>頭部</rb><rp>（</rp><rt>とうぶ</rt><rp>）</rp></ruby>
                    <ul>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </li>
                <li><ruby><rb>手</rb><rp>（</rp><rt>て</rt><rp>）</rp></ruby>
                    <ul>
                        <li><ruby><rb>親指</rb><rp>（</rp><rt>おやゆび</rt><rp>）</rp></ruby></li>
                        <li><ruby><rb>人差し指</rb><rp>（</rp><rt>ひとさしゆび</rt><rp>）</rp></ruby></li>
                        <li><ruby><rb>中指</rb><rp>（</rp><rt>なかゆび</rt><rp>）</rp></ruby></li>
                        <li><ruby><rb>薬指</rb><rp>（</rp><rt>くすりゆび</rt><rp>）</rp></ruby></li>
                        <li><ruby><rb>小指</rb><rp>（</rp><rt>こゆび</rt><rp>）</rp></ruby></li>
                    </ul>
                </li>
            </ul>
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
