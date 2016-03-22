<?php

global $oc_project;
global $oc_res;

array_unshift($oc_res['css'], $oc_project->common . 'css/common.css');

require_once( OC_APATH_CMN . 'function.php' );
$oc_project->html_header();
require_once( dirname(__FILE__) . '/variable.php' );

global $oc_module;
global $oc_setting;

// 改变预定义变量
if ( function_exists('template_variable_filter') ) {
	template_variable_filter();
}

// 对模块依照 index 进行排序
function sort_modules( $a, $b ) {
	return $a['index'] > $b['index'] ? 1 : 0;
}
uasort($oc_modules, 'sort_modules');

// 临时变量
$temp_commonjs = $oc_siteinfo['site'] . 'common/javascript/library/';
$temp_jsDir = $oc_siteinfo['site'] . 'common/page/templates/ourai_ws_3/javascript/';
$temp_pluginurl = ($oc_project->debug || !function_exists('site_url') ? 'http://ourai.ws/' : site_url('/')) . 'common/javascript/plugin/syntaxhighlighter/scripts/';
$temp_signup = in_array($oc_module, array('signup', 'activate'));

// 头像图片
if ( empty($template_avatar) ) {
	$template_avatar = '<img alt="欧雷" src="http://0.gravatar.com/avatar/0565b1df14e0b4a1a9cdecb3f085cdba?s=128&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D128&amp;r=G" class="avatar avatar-128 photo" height="128" width="128">';
}

if ( $oc_module === 'resume' ) {
	$template_avatar = '<img alt="林垚" src="' . $oc_siteinfo['site'] . 'common/image/ourai_lam.jpg" class="avatar avatar-128 photo" width="128" height="128">';
}

// 头像链接
if ( empty($template_avatar_url) ) {
	if ( !$oc_modules['about']['enabled'] || $oc_setting['wpmode'] && in_array($oc_module, array('about', 'resume')) ) {
		$template_avatar_url = '<span title="' . $oc_siteinfo['author']['zh'] . '">' . $template_avatar . '</span>';
	}
	else {
		$template_avatar_url = '<a class="website" href="' . $oc_siteinfo['site'] . 'about/" title="' . $oc_siteinfo['author']['zh'] . '">' . $template_avatar . '</a>';
	}
}

// 非空白页时添加脚本文件
if ( $oc_module !== 'blank' ) {
	// 引入 JavaScript 文件
	if ( !isset($oc_res['js']) ) {
		$oc_res['js'] = array();
	}
	
	$oc_res['js'] = array_merge( $oc_res['js'], array($temp_commonjs . 'jquery/jquery-1.7.1.min.js', $temp_jsDir . 'blog.js') );
	
	if ( $oc_setting['wpmode'] ) {
		if ( $oc_modules['album']['enabled'] && in_array($oc_module, array('album', 'photo')) ) {
			array_push( $oc_res['js'], $temp_commonjs . 'sns/flickr.js' );
		}
		
		if ( $oc_module === 'index' ) {
			array_push( $oc_res['js'], $temp_jsDir . 'home.js' );
		}
		
		if ( $oc_modules['album']['enabled'] && in_array($oc_module, array('album', 'photo')) ) {
			array_push( $oc_res['js'], $temp_jsDir . 'album.js' );
		}
		
		if ( is_single() ) {
			$oc_res['js'] = array_merge( array( $temp_pluginurl . 'shCore.js', $temp_pluginurl . 'shBrushXml.js', $temp_pluginurl . 'shBrushCss.js', $temp_pluginurl . 'shBrushJScript.js', $temp_pluginurl . 'shBrushPhp.js' ), $oc_res['js'] );
		}
	}
	else {
		if ( $oc_module === 'otakism' ) {
			array_push( $oc_res['js'], $temp_jsDir . 'otakism.js' );
		}
	}
}

// 页面 HTML 框架
if ( in_array($oc_module, array('index', 'blank')) || $temp_signup ) { ?>
		<div id="wrapper"><?php
			if ( $temp_signup ) { ?>
			<div class="abs-ctr"><div class="abs-ctr-wrp"><div class="abs-ctr-cnt"></div></div></div>
	<?php	}
			else {
				if ( function_exists('template_layout_pad') ) {
					template_layout_pad();
				}
			}
		?></div><?php
}
else { ?>
		<div id="pane">
			<div id="intro"><h3><?php echo $template_avatar_url; ?></h3></div>
			<ul id="navi">
			<?php
				foreach( $oc_modules as $key => $module ) {
					if ( $module['enabled'] === true ) {
						// 只有在「关于」和「简历」页面显示「About」菜单项
//						if ( in_array($oc_module, array('about', 'resume')) || $module['alias'] !== 'prf' ) {
			?>
				<li class="nav-itm mod-<?php
						echo $module['alias'];
						
						$temp_mod_url = $module['url'] ? $module['url'] : 'javascript:void(0);';
						$temp_mod_name = $module['name']['en'];
						$temp_mod_desc = $module['desc'] ? $module['desc'] : $module['name']['zh'];
						
						if ( $key === 'about' && $oc_module === 'resume' ) {
							$temp_mod_url = $oc_siteinfo['site'] . 'resume/';
							$temp_mod_name = 'resume';
							$temp_mod_desc = '简历';
						}
						
						if ( $key === $oc_module || $key === 'about' && $oc_module === 'resume' || ($key === 'article' && !array_key_exists($oc_module, $oc_modules) && !in_array($oc_module, array('resume'))) ) {
							echo ' current';
						}
				?>"><a class="mod-ttl" title="<?php echo $temp_mod_desc; ?>" href="<?php echo $temp_mod_url; ?>"><span><?php echo ucfirst($temp_mod_name); ?></span></a></li>
			<?php
//						}
					}
				}
				
				unset($temp_mod_url);
				unset($temp_mod_name);
				unset($temp_mod_desc);
			?>
			</ul>
		</div>
		<div id="page"><?php if ( function_exists('template_layout_pad') ) { template_layout_pad(); } ?></div>
		<div id="copyright"><span>&copy; 2009-<?php $d = getdate(); echo $d['year']; unset($d); ?> Ourai.WS</span></div><?php
}

// 销毁临时变量
unset($temp_commonjs);
unset($temp_jsDir);
unset($temp_pluginurl);
unset($temp_signup);

unset($template_avatar);
unset($template_avatar_url);

$oc_project->html_footer(); ?>