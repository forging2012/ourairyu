<?php

require_once( './common/config/global.php' );
require_once( OC_APATH_CLS . 'class-utils.php' );

global $oc_project;
global $oc_module;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

global $oc_hide_cats;

// if ( $oc_project->debug ) {
//     $oc_hide_cats = array(4, 5, 18, 6, 8, 15, 12);
// }
// else {
//     $oc_hide_cats = array(136, 137, 138, 139, 140);
// }

function plugin_css( $file ) {
  global $oc_project;
  return $oc_project->common . 'javascript/plugin/syntaxhighlighter/styles/' . $file . '.css';
}

function theme_css( $file ) {
  global $oc_project;
  return $oc_project->theme_uri(get_template()) . 'css/' . $file . '.css';
}

// 测试样式文件是否存在于主题 CSS 文件夹中
function test_file( $file ) {
  return is_file(OC_APATH_TMPL . get_template() . '/css/' . $file . '.css');
}

function site_tile( $title = null, $module = null ) {
  $result;

  if ( is_home() && empty($title) ) {
    $result = get_bloginfo('name');
  }
  else if ( $module === 'resume' ) {
    $result = '林垚的简历';
  }
  else {
    $result = (empty($title) ? trim(wp_title('', false)) : $title) . ' - ' . get_bloginfo('name');
  }

  return $result;
}

function site_css() {
  global $oc_module;
  global $oc_project;

  $t_plugin = array();
  $t_css = array('theme');

  // 非空白页时添加样式文件
  if ( $oc_module !== 'blank' ) {
    // 样式文件
    if ( $oc_module === 'index' ) {
      array_push( $t_css, 'home' );
    }
    else {
      if ( is_single() || is_page() ) {
        array_push( $t_css, 'page' );
      }

      if ( in_array($oc_module, array('about', 'resume')) ) {
        array_push( $t_css, 'profile' );
      }
      else {
        if ( is_single() ) {
          $t_plugin = array('shCoreRDark', 'shThemeRDark');
          $t_plugin = array_map('plugin_css', $t_plugin);
        }
        elseif ( $oc_module !== 'home' ) {
          array_push( $t_css, $oc_module );
        }
      }
    }
  }

  array_push($t_css, 'respond');

  // 线上模式时引用压缩后的文件
  // if ( $oc_project->debug === false ) {
  //  $t_css = array('minified');
  // }

  $t_css = array_filter($t_css, 'test_file');
  $t_css = array_map('theme_css', $t_css);

  return array_merge($t_plugin, $t_css);
}

$oc_res['css'] = site_css();

$oc_siteinfo['title'] = site_tile( $oc_siteinfo['title'], $oc_module );
$oc_siteinfo['home'] = site_url('/');

// 首页时的网页描述
if ( $oc_module === 'index' ) {
  $oc_siteinfo['desc'] = '欧雷（Ourai Lin）的个人网站，用于展示自我、分享思考总结。文章的主要内容为 Web 前端开发技术、日本文化与日语、哲学思考以及日记、游记等日常生活类。';
}

specified_page_posts();

/**
 * 特定页面文章数量设置
 */
function specified_page_posts() {
  global $posts;
  global $oc_project;
  
  $temp_post_count;
  $default_count = get_option('posts_per_page');
  
  if ( is_home() ) {
    if ( $oc_project->protected_mode() ) {
      $temp_post_count = $default_count;
    }
    else {
      $temp_post_count = 15;
    }
  }
  else if ( is_page() ) {
    // 页面名称（slug）
    switch ( get_page(get_the_ID())->post_name ) {
      case 'archives':
        $temp_post_count = -1;
        break;
      case 'articles':
        $temp_post_count = $default_count;
        break;
    }
  }
  
  if ( is_numeric($temp_post_count) ) {
    $posts = oc_display_articles($temp_post_count);
  }
}

/**
 * 重设模板参数
 */
function template_variable_filter() {
  global $oc_modules;
  global $oc_project;
  global $oc_setting;
  
  // 网站为受保护模式
  if ( $oc_project->protected_mode() ) {
    $modules_allowed = array('article');
    
//    if ( !$oc_project->isIE ) {
//      array_push( $modules_allowed, 'album' );
//    }
    
    foreach( $oc_modules as $mod_key => $mod ) {
      $oc_modules[$mod_key]['enabled'] = in_array($mod_key, $modules_allowed);
    }
  }
}

if ( in_array( $oc_module, array('article', 'tags') ) || is_single() || is_tag() || is_search() || is_category() ) {
  function template_layout_toolbar() {
    get_search_form(); ?>
              <dl id="categoryList">
                  <dt><a href="<?php echo site_url('/categories/'); ?>" title="查看全部文章分类">文章类别</a></dt>
                  <dd><ul class="hover-noline"><?php wp_list_categories( 'title_li=&hide_empty=1' ); ?></ul></dd>
              </dl><?php
  }
}

$oc_project->theme_layout( get_template() );

?>
