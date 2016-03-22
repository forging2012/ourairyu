<?php

/**
 * 公共文件夹路径
 * 
 * RPATH = Relative Path
 * APATH = Absolute Path
 */
define('OC_APATH_ROOT', dirname(dirname(dirname(__FILE__))) . '/');
define('OC_RPATH_PRJ', 'project/');
define('OC_APATH_PRJ', OC_APATH_ROOT . OC_RPATH_PRJ);
define('OC_RPATH_CMN', 'common/');
define('OC_APATH_CMN', OC_APATH_ROOT . OC_RPATH_CMN);
define('OC_RPATH_JS', OC_RPATH_CMN . 'javascript/');
define('OC_APATH_JS', OC_APATH_ROOT . OC_RPATH_JS);
define('OC_RPATH_CSS', OC_RPATH_CMN . 'css/');
define('OC_APATH_CSS', OC_APATH_ROOT . OC_RPATH_CSS);
define('OC_RPATH_IMG', OC_RPATH_CMN . 'image/');
define('OC_APATH_IMG', OC_APATH_ROOT . OC_RPATH_IMG);
define('OC_RPATH_CLS', OC_RPATH_CMN . 'class/');
define('OC_APATH_CLS', OC_APATH_ROOT . OC_RPATH_CLS);
define('OC_RPATH_PAGE', OC_RPATH_CMN . 'page/');
define('OC_APATH_PAGE', OC_APATH_ROOT . OC_RPATH_PAGE);
define('OC_RPATH_TMPL', OC_RPATH_PAGE . 'templates/');
define('OC_APATH_TMPL', OC_APATH_ROOT . OC_RPATH_TMPL);
define('OC_RPATH_VIRT', '__virtual/');



/**
 * 配置
 * 
 * @param {String} OC_DEV_MODE  开发模式
 * @param {Boolean} OC_MOBILE   是否为智能手机访问
 * @param {Integer} OC_IE_VER   允许的 IE 最低版本
 */
define('OC_DEV_MODE', (in_array($_SERVER['HTTP_HOST'], array('localhost', '127.0.0.1')) ? 'debug' : 'release'));
define('OC_MOBILE', !!preg_match( '/(android|iphone)/', strtolower($_SERVER['HTTP_USER_AGENT']) ));
// define('OC_MOBILE', false);
define('OC_IE_VER', 8 );
define('OC_PROTECTED', false);

define('OC_THEME', 'ourai_ws_3.2');
define('OC_THEME_DIR', 'file_system');
define('OC_THEME_DOC', 'document');



global $oc_hash_subdomain;

// 二级域名与虚拟目录的映射表
$oc_hash_subdomain = array(
  'wota' => array(
    'dirname' => 'wota',
    'enabled' => false
  ),
  'semantic-web' => array(
    'dirname' => 'semantic',
    'enabled' => false
  ),
  'fds' => array(
    'dirname' => 'solution',
    'enabled' => false
  ),
  'me' => array(
    'dirname' => 'me',
    'enabled' => true
  ),
  'sakura' => array(
    'dirname' => 'japan',
    'desc' => '介绍日本及其文化',
    'enabled' => true
  )
);

?>
