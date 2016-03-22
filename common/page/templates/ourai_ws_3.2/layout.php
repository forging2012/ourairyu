<?php

global $oc_project;
global $oc_res;

array_unshift($oc_res['css'], $oc_project->common . 'css/base.css');

$oc_res['js_pre'] = array( $oc_project->common . 'javascript/library/jquery/jquery-1.7.1.min.js' );
// $oc_res = array();

$oc_project->html_header();
require_once( dirname(__FILE__) . '/variable.php' );

global $oc_module;
global $oc_setting;

// 改变预定义变量
if ( function_exists('template_variable_filter') ) {
  template_variable_filter();
}

function sns_js( $file = '' ) {
  global $oc_project;
  return $oc_project->common . 'javascript/library/sns/' . $file . '.js';
}

function plugin_js( $file = '' ) {
  global $oc_project;
  return $oc_project->common . 'javascript/plugin/syntaxhighlighter/scripts/' . $file . '.js';
}

function theme_js( $file = '' ) {
  global $oc_project;
  return function_exists('get_template') ? ($oc_project->theme_uri(get_template()) . 'javascript/' . $file . '.js') : '';
}

function site_js() {
  global $oc_setting;
  global $oc_modules;
  global $oc_module;

  $t_plugin = array();
  $t_sns = array();
  $t_js = array( 'blog' );

  if ( $oc_setting['wpmode'] ) {
    if ( $oc_modules['album']['enabled'] && in_array($oc_module, array('album', 'photo')) ) {
      $t_sns = array( $t_sns, 'flickr' );
      $t_sns = array_map('sns_js', $t_sns);
    }
    
    if ( $oc_module === 'index' ) {
      array_push( $t_js, 'home' );
    }
    
    if ( $oc_modules['album']['enabled'] && in_array($oc_module, array('album', 'photo')) ) {
      array_push( $t_js, 'album' );
    }

    if ( $oc_module === 'works' ) {
      array_push($t_js, 'works');
    }
    
    if ( is_single() ) {
      $t_plugin = array('shCore', 'shBrushXml', 'shBrushCss', 'shBrushJScript', 'shBrushPhp');
      $t_plugin = array_map('plugin_js', $t_plugin);
    }
  }
  else {
    if ( $oc_module === 'otakism' ) {
      array_push($t_js, 'otakism');
    }
  }

  $t_js = array_map('theme_js', $t_js);

  return array_merge($t_plugin, $t_sns, $t_js);
}

// 对模块依照 index 进行排序
function sort_modules( $a, $b ) {
  return $a['index'] > $b['index'] ? 1 : 0;
}

uasort($oc_modules, 'sort_modules');

if ( !is_array($oc_res['js']) ) {
  $oc_res['js'] = array();
}

$oc_res['js'] = array_merge($oc_res['js'], site_js());

// 整个页面的模板
if ( function_exists('template_layout_page') ) {
  template_layout_page();
}
else { ?>
    <header class="layout-header">
      <div id="pane">
        <nav id="navi" class="hover-noline">
        <?php
          foreach( $oc_modules as $key => $module ) {
            if ( $module['enabled'] === true ) {
              $t_mod_url = $module['url'] ? $module['url'] : 'javascript:void(0);';
              $t_mod_name = $module['name'];
              $t_mod_desc = $module['desc'] ? $module['desc'] : $t_mod_name['zh'];
              
              if ( $key === 'about' && $oc_module === 'resume' ) {
                $t_mod_url = $oc_siteinfo['site'] . 'resume/';
                $t_mod_name['en'] = 'resume';
                $t_mod_desc = '简历';
              }

              $t_class = 'nav-' . $module['alias'];

              if ( $key === $oc_module || $key === 'about' && $oc_module === 'resume' || ($key === 'article' && !array_key_exists($oc_module, $oc_modules) && !in_array($oc_module, array('resume'))) ) {
                $t_class .= ' current';
              }
        ?>
          <a class="<?php echo $t_class; ?>" title="<?php echo $t_mod_desc; ?>" href="<?php echo $t_mod_url; ?>"><i><?php echo $t_mod_name['zh']; ?></i><?php echo ucfirst($t_mod_name['en']); ?></a>
        <?php
            }
          }
          
          unset($t_mod_url);
          unset($t_mod_name);
          unset($t_mod_desc);
        ?>
        </nav>
        <div id="caption">
          <h1>Ourai.WS</h1>
          <p>my personal website</p>
        </div>
      </div><?php
        $t_hasBread = function_exists('template_layout_breadcrumb');
        $t_hasToolbar = function_exists('template_layout_toolbar');

        if ( $t_hasBread || $t_hasToolbar ) { ?>
      <div id="headerBar" class="clr"><?php
          // 面包屑导航
          if ( $t_hasBread ) { ?>
        <div id="breadcrumb" class="hover-noline" itemprop="breadcrumb"><?php template_layout_breadcrumb(); ?></div><?php
          }
          // 工具栏
          if ( $t_hasToolbar ) { ?>
        <div id="toolbar"><?php template_layout_toolbar(); ?></div>
      <?php } ?>
      </div><?php
        }

        unset( $t_hasBread );
        unset( $t_hasToolbar );
      ?>
    </header>
    <?php
      $t_hasPad = function_exists('template_layout_pad');
      $t_hasMain = function_exists('template_layout_main');
      $t_hasSub = function_exists('template_layout_sidebar');

      $t_class = array('layout-container', 'clr');

      // 双栏布局标识
      if ( !$t_hasPad && $t_hasMain && $t_hasSub ) {
        array_push($t_class, 'layout-column-two');
      }
    ?>
    <div id="main" class="<?php echo implode(' ', $t_class); ?>">
    <?php
      if ( $t_hasPad ) {
        template_layout_pad();
      }
      else {
        if ( $t_hasMain ) { ?>
      <div class="layout-main"><?php template_layout_main(); ?></div>
    <?php }

        if ( $t_hasSub ) { ?>
      <aside id="sidebar" class="layout-sub"><?php template_layout_sidebar(); ?></aside>
    <?php }
      }

      unset($t_hasPad);
      unset($t_hasMain);
      unset($t_hasSub); ?>
    </div>
    <footer class="layout-footer">
      <div>
        <div id="extraModules">
          <div id="projectLinks" class="link-list">
            <b>特别企划</b>
            <ul>
              <li><a href="http://dev.ourai.ws/" rel="external nofollow" title="专注于 web 开发的技术博客">网道</a></li>
              <!-- <li class="hidden" data-project-name="御宅频道"><span>哎呀！H！</span></li> -->
            </ul>
          </div>
          <div id="socialLinks" class="link-list">
            <b>社交网络</b>
            <ul class="sns-links"><?php
              $t_sns = array(
                array( 'name_en' => 'Weibo', 'name_zh' => '新浪微博', 'url' => 'http://weibo.com/ourairyu' ),
                array( 'name_en' => 'Zhihu', 'name_zh' => '知乎', 'url' => 'http://www.zhihu.com/people/ourai' ),
                array( 'name_en' => 'bgm', 'name_zh' => 'Bangumi 番组计划', 'url' => 'http://bangumi.tv/user/ourai' ),
                array( 'name_en' => 'Pinterest', 'name_zh' => '', 'url' => 'http://pinterest.com/ourai/' ),
                array( 'name_en' => 'Pixiv', 'name_zh' => '', 'url' => 'http://www.pixiv.net/member.php?id=1419195' )/*,
                array( 'name_en' => 'Xiami', 'name_zh' => '虾米', 'url' => 'http://www.xiami.com/u/650955' ),
                array( 'name_en' => 'Douban', 'name_zh' => '豆瓣', 'url' => 'http://www.douban.com/people/ourai/' ),
                array( 'name_en' => 'Delicious', 'name_zh' => '美味书签', 'url' => 'http://delicious.com/ourailin' ),
                array( 'name_en' => 'Twitter', 'name_zh' => '推特', 'url' => 'http://twitter.com/#!/ourairyu' ),
                array( 'name_en' => 'Youku', 'name_zh' => '优酷', 'url' => 'http://i.youku.com/ourailam' ),
                array( 'name_en' => 'github', 'name_zh' => 'GitHub', 'url' => 'http://github.com/ourai' ),
                array( 'name_en' => 'Facebook', 'name_zh' => '', 'url' => 'http://www.facebook.com/ourairyu' ),
                array( 'name_en' => 'Flickr', 'name_zh' => '', 'url' => 'http://www.flickr.com/photos/ourairyu/' ),
                array( 'name_en' => 'gplus', 'name_zh' => 'Google+', 'url' => 'https://plus.google.com/110971881899489153670/' ),
                array( 'name_en' => 'V2EX', 'name_zh' => 'Way to explore', 'url' => 'http://www.v2ex.com/member/ourai' )*/
              );
              
              foreach( $t_sns as $sns ) {
                $n_e = $sns['name_en'];
                $n_z = $sns['name_zh'];
                $n_z = ($n_z === '' ? $n_e : $n_z); ?>
              <li class="sns-<?php echo strtolower($n_e); ?>"><a class="txt-elp" href="<?php echo $sns['url']; ?>" title="<?php echo $n_z; ?>" rel="external nofollow"><?php echo $n_z; ?></a></li>
          <?php } ?>
            </ul>
          </div>
          <div id="siteLinks" class="link-list">
            <b>交换链接</b>
            <ul>
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
              <li class="user_info">
                <?php
                  $t_image = $link->link_image;

                  if ( $t_image === '' && $t_info ) {
                    $t_email = $t_info['email'];

                    if ( is_string($t_email) && $t_email !== '' ) {
                      $t_image = 'http://0.gravatar.com/avatar/' . md5($t_email);
                    }
                  }

                  if ( $t_image !== '' ) {
                    echo '<img class="avatar" src="' . $t_image . '" alt="' . $t_name . '">';
                  }

                  unset($t_email);
                  unset($t_image);
                ?>
                <a class="name" href="<?php echo $link->link_url; ?>" rel="external nofollow" title="查看<?php echo $t_name; ?>的网站"><?php echo $t_name; ?></a>
                <p class="desc smaller"><?php echo $link->link_description; ?></p>
              </li>
          <?php }
            ?>
            </ul>
          </div>
          <!--
          <div id="groups" class="link-list">
            <b>Groups</b>
            <ul>
              <li>
                <div>宅男的部屋 <a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=08e8082430f38b5a7bcbe1da26e9741fdf10cc3ff79e6565a61c75efa5d9f434"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="宅男的部屋" title="宅男的部屋"></a></div>
                <p><b class="tri tri-t">群简介</b><span class="tri tri-t">注意</span>申请时请说出证明自己是“宅”的信息。</p>
              </li>
              <li>
                <div>前端开发中心 <a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=2fb41866c321e90f1572271f17450e21e3a1853f3f97f96cc0a2aee96bcf8e18"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="前端开发中心" title="前端开发中心"></a></div>
                <p><b class="tri tri-t">群简介</b><span class="tri tri-t">注意</span>网络（web）开发的技术交流，主要是前端开发。</p>
              </li>
            </ul>
          </div>
          -->
        </div>
        <div id="contact">
          <img class="avatar" src="http://0.gravatar.com/avatar/0565b1df14e0b4a1a9cdecb3f085cdba?s=128&d=&r=G">
          <div>
            <b class="tri tri-r">contacts me</b>
            <p>有事请发送邮件到<span class="tri tri-r">email address:</span><b class="contact_mail lang_en">ourairyu[AT]hotmail.com</b>或者 <a class="contact_qq" target="_blank" href="http://sighttp.qq.com/authd?IDKEY=b0176fe21b03fb0c3242c6bcbfbbbed94fa149032e84da9d"><img border="0" src="http://wpa.qq.com/imgd?IDKEY=b0176fe21b03fb0c3242c6bcbfbbbed94fa149032e84da9d&pic=52" alt="点击这里给我发消息" title="点击这里给我发消息"></a></p>
          </div>
        </div>
        <span id="copyright">&copy; 2009-<?php $d = getdate(); echo $d['year']; unset($d); ?> Ourai.WS. All rights reserved.</span>
      </div>
    </footer><?php
  }

  // 线上模式时引入站点统计
  if ( $oc_project->debug === false ) { ?>
    <aside data-role="statistic" style="display:none;">
      <script src="http://s95.cnzz.com/stat.php?id=5347656&web_id=5347656&show=pic1" language="JavaScript"></script>
      <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Ffde3aa1758e72151ec65d5cbdf31f5d4' type='text/javascript'%3E%3C/script%3E"));
      </script>
      <script type='text/javascript'>
        (function() {
          var c = document.createElement('script'); 
          c.type = 'text/javascript';
          c.async = true;
          c.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.clicki.cn/boot/49283';
          var h = document.getElementsByTagName('script')[0];
          h.parentNode.insertBefore(c, h);
        })();
      </script>
    </aside><?php
  }
$oc_project->html_footer(); ?>
