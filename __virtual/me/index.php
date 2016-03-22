<?php

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$oc_siteinfo['title'] = '欧雷';

$oc_project->html_header(); ?>
    <h1>欧雷</h1>
    <img class="avatar" itemprop="image" src="http://www.gravatar.com/avatar/<?php echo md5('ourairyu@hotmail.com'); ?>?s=128">
    <section>
      <h2>兴趣·爱好</h2>
      <ul>
        <li>动画·漫画·游戏</li>
        <li>音乐</li>
        <li>户外运动·旅游</li>
        <li>美食·烹饪</li>
        <li>电影</li>
        <li>摄影</li>
        <li>绘画</li>
        <li>哲学</li>
        <li>科学</li>
        <li>语言/方言</li>
      </ul>
    </section>
    <section>
      <h2>语言·方言</h2>
      <ul>
        <li>
          <span>汉语</span>
          <ul>
            <li>普通话</li>
            <li>东北话</li>
          </ul>
        </li>
        <li>英语</li>
        <li>
          <span>日语</span>
          <ul>
            <li>标准语</li>
          </ul>
        </li>
      </ul>
    </section>
    <section>
      <h2>足迹</h2>
      <ul>
        <li>
          <span>辽宁省</span>
          <ul>
            <li><span>抚顺市</span></li>
            <li>
              <span>沈阳市</span>
              <ul>
                <li><span>沈阳世博园</span></li>
              </ul>
            </li>
            <li><span>铁岭市</span></li>
            <li>
              <span>大连市</span>
              <ul>
                <li><span>大连发现王国主题公园</span></li>
                <li><span>星海广场</span></li>
                <li><span>星海公园</span></li>
              </ul>
            </li>
            <li><span>锦州市</span></li>
          </ul>
        </li>
        <li>
          <span>浙江省</span>
          <ul>
            <li>
              <span>杭州市</span>
              <ul>
                <li><span>西湖景区</span></li>
                <li><span>西溪国家湿地公园</span></li>
                <li><span>龙井八景</span></li>
                <li><span>杭州西山森林公园</span></li>
              </ul>
            </li>
            <li>
              <span>宁波市</span>
              <ul>
                <li><span>象山县</span></li>
              </ul>
            </li>
            <li>
              <span>嘉兴市</span>
              <ul>
                <li><span>乌镇西栅（桐乡市）</span></li>
                <li><span>西塘古镇（嘉善县）</span></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <span>上海市</span>
          <ul>
            <li><span>城隍庙</span></li>
          </ul>
        </li>
        <li>
          <span>安徽省</span>
          <ul>
            <li>
              <span>黄山市</span>
              <ul>
                <li><span>翡翠谷景区</span></li>
                <li><span>黄山风景区</span></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <div style="display: none;"><?php
      if ( !empty($_SERVER['HTTP_REFERER']) ) {
        echo $_SERVER['HTTP_REFERER'];
      }
    ?></div>
<?php
$oc_project->html_footer();

?>
