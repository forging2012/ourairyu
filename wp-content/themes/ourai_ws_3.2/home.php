<?php

// wp_redirect(home_url() . '/articles/');
// exit;

function template_layout_page() { ?>
        <header class="layout-header">
            <div id="pane">
                <div id="profile" itemscope itemtype="http://schema.org/Person">
                    <img class="avatar" itemprop="image" src="http://0.gravatar.com/avatar/<?php echo md5('ourairyu@hotmail.com'); ?>?s=128">
                    <h3 itemprop="name">Ourai Lin</h3>
                    <ul>
                        <li class="prof"><i class="txt-hide">Profession:</i><span itemprop="jobTitle">Front-end Engineer</span></li>
                        <li class="org"><i class="txt-hide">Organization:</i><abbr itemprop="memberOf" title="Otakism Promotion Association&#13;宅文化发展推进会">O.P.A.</abbr></li>
                        <li class="loc"><i class="txt-hide">Location:</i><span itemprop="homeLocation">Earth</span></li>
                    </ul>
                </div>
                <div id="social" class="module">
                    <h3 class="module_title">Find me</h3>
                    <ul class="module_content"><?php
                        $t_sns = array(
                            array( 'name_en' => 'Weibo', 'name_zh' => '新浪微博', 'url' => 'http://weibo.com/ourairyu' ),
                            array( 'name_en' => 'Zhihu', 'name_zh' => '知乎', 'url' => 'http://www.zhihu.com/people/ourai' ),
                            array( 'name_en' => 'bgm', 'name_zh' => 'Bangumi 番组计划', 'url' => 'http://bangumi.tv/user/ourai' ),
                            array( 'name_en' => 'Pinterest', 'name_zh' => '', 'url' => 'http://pinterest.com/ourai/' ),
                            array( 'name_en' => 'Pixiv', 'name_zh' => '', 'url' => 'http://www.pixiv.net/member.php?id=1419195' )
                        );
                        
                        foreach( $t_sns as $sns ) {
                            $n_e = $sns['name_en'];
                            $n_z = $sns['name_zh'];
                            $n_z = ($n_z === '' ? $n_e : $n_z); ?>
                        <li class="sns-<?php echo strtolower($n_e); ?>"><a class="txt-elp" href="<?php echo $sns['url']; ?>" title="<?php echo $n_z; ?>" rel="external nofollow"><?php echo $n_z; ?></a></li>
                <?php   } ?>
                    </ul>
                </div>
            </div>
        </header>
        <div class="layout-container layout-column-two clr">
            <div class="layout-main tab-wrapper">
                <nav class="tab-group">
                    <a class="tab-trigger current" href="javascript:void(0);" data-flag="activity" title="动态" rel="nofollow">Activity</a>
                    <a class="tab-trigger" href="javascript:void(0);" data-flag="profile" title="欧雷的一些事情" rel="nofollow">Profile</a>
                    <?php
                        global $oc_modules;
                        
                        foreach ( $oc_modules as $key => $mod ) {
                            if ( $mod['enabled'] && $key !== 'about' ) {
                                $t_name = $mod['name']; ?>
                    <a class="tab-trigger" href="<?php echo $mod['url']; ?>" data-flag="<?php echo $t_name['en']; ?>" data-jump="true" title="<?php echo $t_name['zh']; ?>"><?php echo ucfirst($t_name['en']); ?></a>
                    <?php   }
                        }
                    ?>
                </nav>
                <div class="tab-content current" data-flag="activity">
                    <?php
                        global $oc_project;
                        global $oc_hide_cats;

                        $t_has_avoid = !empty($oc_hide_cats);
                        $t_filter = array('numberposts' => 30, 'orderby' => 'date');

                        if ( $t_has_avoid ) {
                            $t_filter['category__not_in'] = $oc_hide_cats;
                        }

                        $t_activities = get_posts( $t_filter );
                        
                        if ( !empty($t_activities) ) : ?>
                    <h2 class="title fl txt-hide" title="文章相关动态信息"><img src="<?php echo $oc_project->theme_uri(OC_THEME); ?>image/activity-article.png"><span>文章动态</span></h2>
                    <?php
                        if ( $t_has_avoid ) {
                            $t_cat_html = oc_hide_cats_html($oc_hide_cats); ?>
                    <p class="desc lf txt-elp">不包含 <?php echo implode(' ', $t_cat_html) . (count($t_cat_html) === 1 ? ' ' : ' 等'); ?>类别的文章动态</p>
                <?php   } ?>
                    <ul class="activities clr-b">
                    <?php
                        $t_display_modified = false;  // 是否区分文章的「新发布」和「修改」

                        $t_a_count = 0;
                        $t_a_total = count($t_activities);

                        foreach ( $t_activities as $a ) {
                            $t_a_count++;
                            $t_a_class = array('activity');
                            $t_a_time = mysql2date('U', $a->post_date);

                            if ( $t_a_count === 1 ) {
                                array_push($t_a_class, 'first');
                            }

                            if ( $t_a_count === $t_a_total ) {
                                array_push($t_a_class, 'last');
                            } ?>
                        <li class="<?php echo implode(' ', $t_a_class); ?>">
                    <?php   if ( $t_display_modified === false || $a->post_modified_gmt === $a->post_date_gmt ) { ?>
                            <div class="activity_meta"><i class="txt-hide">文章</i></div>
                            <div class="activity_content">
                                <div class="desc">
                                    <span>发表了</span><a href="<?php echo get_permalink($a->ID); ?>"><?php echo $a->post_title; ?></a>
                                </div>
                                <time class="date smaller" datetime="<?php echo date('Y-m-d H:m:s', $t_a_time); ?>"><?php echo date('M jS, Y', $t_a_time); ?></time>
                                <p><i class="tri txt-hide">文章摘要</i><?php echo oc_ellipsis( strip_tags($a->post_content), 150 ); ?></p>
                            </div>
                    <?php   }
                            else { ?>
                            <div class="activity_meta"><i class="txt-hide">文章</i></div>
                            <div class="activity_content">
                                <div class="desc">
                                    <span>修改了</span><a href="<?php echo get_permalink($a->ID); ?>"><?php echo $a->post_title; ?></a>
                                </div>
                                <time class="date smaller" datetime="<?php echo date('Y-m-d H:m:s', $t_a_time); ?>"><?php echo date('M jS, Y', $t_a_time); ?></time>
                            </div>
                    <?php   } ?>
                        </li>
                <?php   } ?>
                    </ul>
                <?php   endif;
                    ?>
                </div>
                <div class="tab-content" data-flag="profile">
                  <p>哈喽～我就是<ruby lang="zh"><rb>欧</rb><rp>（</rp><rt>ōu</rt><rp>）</rp></ruby><ruby lang="zh"><rb>雷</rb><rp>（</rp><rt>léi</rt><rp>）</rp></ruby>，曾用过「<ruby lang="ja" class="lang_jp"><rb>飛鳥</rb><rp>（</rp><rt>あすか</rt><rp>）</rp></ruby><ruby lang="ja" class="lang_jp"><rb>修羅丸</rb><rp>（</rp><rt>しゅらまる</rt><rp>）</rp></ruby>」作为网名。</p>
                  <p>年幼时就接触日本动画，年少时痴迷于日本游戏。一直很喜欢日本的一切，目前正学习并研究日本国的语言及文化。我相信通过了解，能够更加全面地进行思考，更加客观地看待事情。终有一天，我会踏入那片樱花之国的土地！</p>
                  <ul class="n-rst info-list" style="display: none;">
                    <li><strong>动漫</strong>——喜欢具备“校园”“爱情”“战斗”“冒险”“推理”“恐怖”“搞笑”等要素的，例如《银魂》、<span class="lang_en">key</span> 社三部曲、《死亡笔记》、《叛逆的鲁鲁修》等。</li>
                    <li><strong>游戏</strong>——喜欢日式游戏，对 <span class="lang_en">Action</span> 和 <span class="lang_en">Role-playing</span> 类型的游戏很是感兴趣！最喜欢的游戏为《马里奥》系列、《塞尔达传说》系列、《恶魔城》系列、《热血高校》系列。</li>
                    <li><strong>音乐</strong>——<span class="lang_en">VOCALOID</span> 具备其独特的魅力，一般人无法理解！自从听了 <span class="lang_en">JPOP</span> 之后，再听中国音乐感觉完全不对味！<span class="lang_en">ROCK</span> 也让我如痴如醉，震撼的鼓声及狂乱的吉他、贝司声让我疯狂！</li>
                    <li><strong>电影</strong>——恐怖片来挑战自己的神经，惊悚片来增加自己的抗性，悬疑片来满足自己的好奇。</li>
                    <li><strong>运动</strong>——骑行，感受与风同行的快感；游泳，欣赏美女身材的最好方式；棒球，只能在二次元中体会喜悦。</li>
                  </ul>
                  <section>
                    <h3 class="heading">兴趣/爱好</h3>
                    <ul class="n-rst">
                      <li>动画、漫画、游戏</li>
                      <li>音乐</li>
                      <li>徒步、骑行、旅行</li>
                      <li>美食</li>
                      <li>电影</li>
                      <li>摄影、绘画</li>
                      <li>哲学、科学、宗教、神话</li>
                    </ul>
                  </section>
                  <section>
                    <h3 class="heading">语言/方言</h3>
                    <ul class="n-rst">
                      <li>
                        <span>汉语</span>
                        <ul class="n-rst">
                          <li>普通话</li>
                          <li>东北话</li>
                        </ul>
                      </li>
                      <li>英语</li>
                      <li>
                        <span>日语</span>
                        <ul class="n-rst">
                          <li>标准语</li>
                        </ul>
                      </li>
                    </ul>
                  </section>
                  <section>
                    <h3 class="heading">足迹</h3>
                    <ul class="n-rst">
                      <li>
                        <span>辽宁省</span>
                        <ul class="n-rst">
                          <li><span>抚顺市</span></li>
                          <li>
                            <span>沈阳市</span>
                            <ul class="n-rst">
                              <li><span>沈阳世博园</span></li>
                              <li><span>清·沈阳故宫</span></li>
                              <li><span>清·昭陵</span></li>
                              <li><span>清·福陵</span></li>
                            </ul>
                          </li>
                          <li><span>铁岭市</span></li>
                          <li>
                            <span>大连市</span>
                            <ul class="n-rst">
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
                        <ul class="n-rst">
                          <li>
                            <span>杭州市</span>
                            <ul class="n-rst">
                              <li><span>西湖景区</span></li>
                              <li><span>龙井八景</span></li>
                              <li><span>西溪国家湿地公园</span></li>
                              <li><span>杭州西山森林公园</span></li>
                              <li><span>城隍阁</span></li>
                              <li><span>塘栖古镇</span></li>
                              <li><span>岳庙</span></li>
                            </ul>
                          </li>
                          <li>
                            <span>宁波市</span>
                            <ul class="n-rst">
                              <li><span>象山县</span></li>
                            </ul>
                          </li>
                          <li>
                            <span>嘉兴市</span>
                            <ul class="n-rst">
                              <li><span>乌镇西栅（桐乡市）</span></li>
                              <li><span>西塘古镇（嘉善县）</span></li>
                              <li><span>乌镇东栅（桐乡市）</span></li>
                            </ul>
                          </li>
                          <li>
                            <span>绍兴市</span>
                            <ul class="n-rst">
                              <li><span>鲁迅故里</span></li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span>上海市</span>
                        <ul class="n-rst">
                          <li><span>城隍庙</span></li>
                          <li><span>鲁迅故居</span></li>
                          <li><span>鲁迅公园</span></li>
                        </ul>
                      </li>
                      <li>
                        <span>安徽省</span>
                        <ul class="n-rst">
                          <li>
                            <span>黄山市</span>
                            <ul class="n-rst">
                              <li><span>翡翠谷景区</span></li>
                              <li><span>黄山风景区</span></li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span>江苏省</span>
                        <ul class="n-rst">
                          <li>
                            <span>扬州市</span>
                            <ul class="n-rst">
                              <li><span>何园</span></li>
                              <li><span>瘦西湖风景区</span></li>
                            </ul>
                          </li>
                          <li>
                            <span>南京市</span>
                            <ul class="n-rst">
                              <li><span>夫子庙-秦淮风光带</span></li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </section>
                </div>
            </div>
            <aside class="layout-sub">
              <?php if ( OC_MOBILE === false ) { ?>
              <div id="wechart" class="module">
                <h3 class="module_title">微信公众号</h3>
                <div class="module_content"><img class="qr_code" alt="ourairyuu" title="拿起你的爪机，打开微信扫一扫吧～" src="<?php echo $oc_project->common . 'image/wc_ourairyuu.jpg'; ?>"></div>
              </div>
              <?php } ?>
              <div id="friends" class="module">
                <h3 class="module_title">Friends</h3>
                <ul class="module_content">
                <?php
                    $t_links = get_bookmarks(array('category_name' => '友情链接'));

                    foreach ( $t_links as $link ) {
                        $t_info = str_replace('\20', '', $link->link_notes);
                        $t_name = $link->link_name;

                        if ( preg_match_all('/[a-z_-]+\:[^\r\n]*/i', $t_info, $t_match) ) {
                            $t_info = array();

                            foreach ( $t_match[0] as $m ) {
                                $m = explode( ':', $m );
                                $t_info[ $m[0] ] = $m[1];
                            }
                        }
                        else {
                            $t_info = null;
                        } ?>
                    <li>
                        <?php
                            $t_image = $link->link_image;

                            if ( $t_image === '' && $t_info ) {
                                $t_email = $t_info['email'];

                                if ( is_string($t_email) && $t_email !== '' ) {
                                    $t_image = 'http://0.gravatar.com/avatar/' . md5($t_email) . '?s=100';
                                }
                            }
                        ?>
                        <img class="avatar" src="<?php echo $t_image; ?>" alt="<?php echo $t_name; ?>">
                        <a class="link" href="<?php echo $link->link_url; ?>" rel="external nofollow" title="查看<?php echo $t_name; ?>的网站">
                            <b class="name"><?php echo $t_name; ?></b>
                            <span class="desc smaller"><?php echo $link->link_description; ?></span>
                        </a>
                    </li><?php
                            unset($t_email);
                            unset($t_image);
                    } ?>
                </ul>
              </div>
            </aside>
        </div>
<?php
}

global $oc_module;

$oc_module = 'index';

get_header();
get_footer();

?>
