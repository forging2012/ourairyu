<?php

/*
    @Title: 模拟表格
    @Description: 像表格单元格一样等高
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

$oc_siteinfo['title'] = '模拟表格';
$oc_res['css'] = array(
    $oc_project->common . 'css/base.css',
    $t_dirdemo . 'css/' . $t_filename . '.css'
);

$oc_project->html_header(); ?>
        <ul class="list lang_zh">
            <li class="item">
                <div class="table">
                    <div class="extra"><img class="avatar" src="http://ww4.sinaimg.cn/bmiddle/6204ece1gw1e56152zrfcj20c80dogn1.jpg"></div>
                    <div class="display">
                        <h3>强奸猥亵儿童多人 禽兽教师被处死</h3>
                        <p>最高人民法院29日公布三起侵犯未成年人权益犯罪案例。案例1：1966年出生的鲍某某利用教师身份猥亵小学女生7人数十次，将其中6人奸淫数十次，拍摄6名幼女裸照及被奸淫照片视频。法院判处被告人鲍某某死刑剥夺政治权利终身，鲍某某已被执行死刑。<a href="http://t.cn/zH6fHfH" target="_blank">http://t.cn/zH6fHfH</a></p>
                        <div><span>来源：南方都市报</span><span>日期：2013年5月30日 08:43</span></div>
                    </div>
                    <div class="operation">
                        <div class="dib-wrap">
                            <button class="dib" type="button">查看</button>
                            <button class="dib" type="button">修改</button>
                            <button class="dib" type="button">删除</button>
                        </div>
                    </div>
                </div>
            </li>
            <li class="item">
                <div class="table">
                    <div class="extra"><img class="avatar" src="http://ww1.sinaimg.cn/bmiddle/6c6b0dc7tw1e52wk5v6rsj20fa0m8gmx.jpg"></div>
                    <div class="display">
                        <h3 class="lang_jp">キャラクター・ボーカル・シリーズ イヤホンジャックアクセサリー</h3>
                        <p class="lang_jp">『キャラクター・ボーカル・シリーズ』より、「初音ミク」「鏡音リン」「鏡音レン」の３人がイヤホンジャックアクセサリーに登場です。人気イラストレーターのYおじ氏、ソウノ氏、ぷちでびる氏のイラストを元に立体化。スマートフォン器機に乗っかったり、しがみついたりするミクさん達の可愛らしさは必見です！イヤホンジャックホルダーも付属するので、使用しない時は飾って置くことも可能です。全種集めて、飾ったり持ち歩いたりしてお楽しみ下さい♪</p>
                        <div><span>来源：GoodSmile Company</span><span>日期：2013年4月23日 12:00</span></div>
                    </div>
                    <div class="operation">
                        <div class="dib-wrap">
                            <button class="dib" type="button">查看</button>
                            <button class="dib" type="button">修改</button>
                            <button class="dib" type="button">删除</button>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
<?php

$oc_project->html_footer();

?>