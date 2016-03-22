<?php

require_once( './common/config/global.php' );
require_once( OC_APATH_CMN . 'function.php' );
require_once( OC_APATH_CLS . 'class-utils.php' );

global $oc_project;

if ( !class_exists('CLS_Project') ) {
	require_once( OC_APATH_CLS . 'class-project.php' );
	$oc_project = new CLS_Project();
}

$t_logged_in = is_user_logged_in();
$t_protected = $oc_project->protected_mode();

// 受保护模式下未登录浏览非主页页面时重定向到主页
if ( $t_protected && !is_home() && !$t_logged_in ) {
	wp_redirect(home_url() . '?oc_path=' . urlencode($_SERVER['REQUEST_URI']));
	exit;
}

global $template_url;

global $oc_module;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

// 文章顶级目录排序
global $oc_category_order;
// 禁止显示的文章目录
global $oc_category_forbidden;
// 私密文章目录
global $oc_category_private;

// 注册页面
if ( has_action('wp_head', 'wpmu_signup_stylesheet') ) {
	$oc_module = 'signup';
}
// 激活页面
elseif ( has_action('wp_head', 'wpmu_activate_stylesheet') ) {
	$oc_module = 'activate';
}
// 受保护模式下用户登录后的首页
elseif ( is_home() && $t_protected && $t_logged_in ) {
	$oc_module = 'article';
}

// 网页标题
if ( is_home() && empty($oc_siteinfo['title']) ) {
	$oc_siteinfo['title'] = get_bloginfo('name');
}
else if ( $oc_module === 'resume' ) {
	$oc_siteinfo['title'] = '林垚的简历';
}
else {
	$oc_siteinfo['title'] = (empty($oc_siteinfo['title']) ? trim(wp_title('', false)) : $oc_siteinfo['title']) . ' - ' . get_bloginfo('name');
}

if ( $oc_project->debug ) {
	$oc_category_order = array(7, 10, 5, 4);
	$oc_category_forbidden = array(6);
	$oc_category_private = array(4, 5);
}
else {
	$oc_category_order = array(53, 46, 105, 102, 1, 5);
	$oc_category_forbidden = array();
	$oc_category_private = array(1, 5);
}

$siteroot_url = CLS_Utils::domain();
$common_root = $siteroot_url . 'common/';
$common_js = $common_root . 'javascript';
$common_css = $common_root . 'css';
$common_img = $common_root . 'image';

$template_url = $common_root . 'page/templates/ourai_ws_3/';

$temp_browser = CLS_Utils::browser();
$temp_pluginurl = $oc_project->common . 'javascript/plugin/syntaxhighlighter/styles/';
$temp_cssDir = $template_url . 'css/';

$oc_siteinfo['home'] = site_url('/');
$oc_res['css'] = array( $temp_cssDir . 'global.css' );

// 低版本 IE 浏览器
if ( $oc_project->lowerIE ) {
	$temp_cssDir .= 'ie_low/';
	array_push( $oc_res['css'], $temp_cssDir . 'main.css' );
	
	if ( is_single() ) {
		$oc_res['css'] = array_merge( $oc_res['css'], array($temp_pluginurl . 'shCoreRDark.css', $temp_pluginurl . 'shThemeRDark.css', $temp_cssDir . 'post.css') );
	}
}
else {
	// 移动终端访问
	if ( OC_MOBILE ) {
		$temp_cssDir .=  'mobile/';
	}
		
	// 非空白页时添加样式文件
	if ( $oc_module !== 'blank' ) {
		// 样式文件
		if ( in_array($oc_module, array('signup', 'activate')) ) {
			array_push( $oc_res['css'], $temp_cssDir . 'signup.css' );
		}
		elseif ( $oc_module === 'index' ) {
			array_push( $oc_res['css'], $temp_cssDir . 'home.css' );
		}
		else {
			array_push( $oc_res['css'], $temp_cssDir . 'main.css' );
			
			if ( in_array($oc_module, array('about', 'resume')) ) {
				array_push( $oc_res['css'], $temp_cssDir . 'profile.css' );
			}
			else {
				if ( is_single() ) {
					$oc_res['css'] = array_merge( $oc_res['css'], array($temp_pluginurl . 'shCoreRDark.css', $temp_pluginurl . 'shThemeRDark.css', $temp_cssDir . 'post.css') );
				}
				elseif ( is_404() ) {
					$oc_res['css'] = array_merge( $oc_res['css'], array($temp_cssDir . '404.css') );
				}
				elseif ( $oc_module !== 'home' && is_file(OC_APATH_TMPL . 'ourai_ws_3/css/' . $oc_module . '.css') ) {
					array_push( $oc_res['css'], $temp_cssDir . $oc_module . '.css' );
				}
			}
		}
	}
}

// 销毁临时变量
unset($temp_cssDir);
unset($temp_pluginurl);
unset($temp_browser);
unset($t_logged_in);
unset($t_protected);

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
		$posts = ourai_display_articles($temp_post_count);
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
		
//		if ( !$oc_project->isIE ) {
//			array_push( $modules_allowed, 'album' );
//		}
		
		foreach( $oc_modules as $mod_key => $mod ) {
			$oc_modules[$mod_key]['enabled'] = in_array($mod_key, $modules_allowed);
		}
	}
}

$oc_project->theme_layout( get_template() );

?>