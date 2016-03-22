<?php

global $oc_project;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;
global $oc_env;

$temp_res = array( 'css' => array(), 'js' => array(), 'js_pre' => array() );
$temp_env = array( 'browser' => CLS_Utils::browser(), 'os' => CLS_Utils::OS() );
$temp_setting = array(
  'protected' => false,                     // 博客受保护
  'limit_ie' => true,                       // 限制 IE 版本
  'forbid' => false,                        // 禁止浏览
  'wpmode' => function_exists('wp_head'),   // WordPress 模式
  'html5shim' => false                      // 引入 html5shim
);
$temp_siteinfo = array(
  'name' => '欧雷流',
  'site' => $oc_project->mainSite,
  'blog' => $oc_project->blogSite,
  'home' => $oc_project->root,
  'profile' => "http://me.ourai.ws/",
  'title' => '',
  'keywords' => '欧雷,欧雷流,宅男的部屋,宅男部屋,宅男,ourai,ourairyu',
  'desc' => '',
  'lang' => 'zh',
  'dir' => 'ltr',
  'charset' => 'UTF-8',
  'author' => array(
    'zh' => '欧雷',
    'en' => 'Ourai Lin',
    'ja' => 'マサト'
  )
);
  
// 合并设置
$oc_siteinfo = mergeSettings($oc_siteinfo, $temp_siteinfo);
$oc_setting = mergeSettings($oc_setting, $temp_setting);
$oc_res = mergeSettings($oc_res, $temp_res);
$oc_env = mergeSettings($oc_env, $temp_env);

/**
 * 合并设置参数
 * 
 * @private
 * @method  mergeSettings
 * @param {Array} target
 * @param {Array} source
 * @return  {Array}
 */
function mergeSettings( $target = array(), $source = array() ) {
  if ( empty($target) ) {
    $target = array_merge($source, array());
  }
  else {
    foreach( $source as $key => $val ) {
      if ( !array_key_exists($key, $target) ) {
        $target[$key] = $val;
      }
    }
  }
  
  return $target;
}

unset($temp_siteinfo);
unset($temp_setting);
unset($temp_res);
unset($temp_env);

// 当浏览器为 IE 时的特殊处理
if ( $oc_env['browser']['alias'] === 'IE' ) {
  $t_ver = intval($oc_env['browser']['version']);

  // 小于所允许的最低版本时提示更换浏览器
  if ( $oc_setting['limit_ie'] === true && $t_ver < OC_IE_VER ) {
    $oc_setting['forbid'] = true;
    $oc_siteinfo['title'] = '请升级或更换浏览器';
  }

  // 小于 IE9 时引入解决方案文件
  if ( $t_ver < 9 ) {
    $oc_setting['html5shim'] = true;
  }

  unset($t_ver);
}

?>
