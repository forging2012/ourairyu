<?php

/*
    @Title: 信息流列表
    @Description: 信息流
    @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

$t_dirname = 'demo';
$t_pathname = $oc_project->pathname;
$t_dirdemo = $oc_project->root . substr($t_pathname, 0, (strpos($t_pathname, $t_dirname) + strlen($t_dirname))) . '/';
$t_filename = array_pop(CLS_Utils::pathname());

$oc_siteinfo['title'] = '信息流列表';
$oc_res['css'] = array(
    $t_dirdemo . 'css/' . $t_filename . '.css'
);

$oc_project->html_header(); ?>
        <div id="content">
            <h2 id="infoTitle">最新动态</h2>
            <ul id="infoList">
                <li class="item">
                    <a class="author" href="#" title="欧雷"><img class="avatar" src="http://0.gravatar.com/avatar/0565b1df14e0b4a1a9cdecb3f085cdba?s=128&d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D128&r=G" alt="头像" title="欧雷">欧雷</a>
                    <span class="action">回答了该问题</span>
                    <h3 class="title"><a href="#" title="查看问题《欧雷是谁？》">欧雷是谁？</a></h3>
                    <p class="description">年幼时就接触日本动画，年少时痴迷于日本游戏。一直很喜欢日本的一切，目前正学习并研究日本国的语言及文化。我相信通过了解，能够更加全面地进行思考，更加客观地看待事情。终有一天，我会踏入那片樱花之国的土地！</p>
                    <div class="meta">
                        <a class="date" href="#">2013-05-02 23:47:30</a>
                        <span class="client">来自 <a href="#" title="啊哦，小霸王其乐无穷啊！">小霸王</a></span>
                    </div>
                </li>
                <li class="item">
                    <a class="author" href="#" title="欧雷"><img class="avatar" src="http://0.gravatar.com/avatar/0565b1df14e0b4a1a9cdecb3f085cdba?s=128&d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D128&r=G" alt="头像" title="欧雷">欧雷</a>
                    <span class="action">回答了该问题</span>
                    <h3 class="title"><a href="#" title="查看问题《欧雷是谁？》">欧雷是谁？</a></h3>
                    <p class="description">年幼时就接触日本动画，年少时痴迷于日本游戏。一直很喜欢日本的一切，目前正学习并研究日本国的语言及文化。我相信通过了解，能够更加全面地进行思考，更加客观地看待事情。终有一天，我会踏入那片樱花之国的土地！</p>
                    <div class="meta">
                        <a class="date" href="#">2013-05-02 23:47:30</a>
                        <span class="client">来自 <a href="#" title="啊哦，小霸王其乐无穷啊！">小霸王</a></span>
                    </div>
                </li>
                <li class="item">
                    <a class="author" href="#" title="欧雷"><img class="avatar" src="http://0.gravatar.com/avatar/0565b1df14e0b4a1a9cdecb3f085cdba?s=128&d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D128&r=G" alt="头像" title="欧雷">欧雷</a>
                    <span class="action">回答了该问题</span>
                    <h3 class="title"><a href="#" title="查看问题《欧雷是谁？》">欧雷是谁？</a></h3>
                    <p class="description">年幼时就接触日本动画，年少时痴迷于日本游戏。一直很喜欢日本的一切，目前正学习并研究日本国的语言及文化。我相信通过了解，能够更加全面地进行思考，更加客观地看待事情。终有一天，我会踏入那片樱花之国的土地！</p>
                    <div class="meta">
                        <a class="date" href="#">2013-05-02 23:47:30</a>
                        <span class="client">来自 <a href="#" title="啊哦，小霸王其乐无穷啊！">小霸王</a></span>
                    </div>
                </li>
            </ul>
        </div>
<?php

$oc_project->html_footer();

?>