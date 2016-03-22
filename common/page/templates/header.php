<?php

// 引入站点相关变量
require_once( dirname(__FILE__) . '/variable.php' );

// array_push($oc_res['js_pre'], ($oc_siteinfo['site'] . 'common/javascript/JSDK/jsdk.min.js'));

if ( $oc_setting['html5shim'] ) {
  array_push($oc_res['js_pre'], "http://html5shim.googlecode.com/svn/trunk/html5.js");
}

?>
<!DOCTYPE html>
<html lang="<?php echo $oc_siteinfo['lang']; ?>" dir="<?php echo $oc_siteinfo['dir']; ?>"> 
  <head>
    <meta charset="<?php echo $oc_siteinfo['charset']; ?>">
    <title><?php echo $oc_siteinfo['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ( !empty($oc_siteinfo['keywords']) ) : ?>
    <meta name="keywords" content="<?php echo $oc_siteinfo['keywords']; ?>">
    <?php endif; if ( !empty($oc_siteinfo['desc']) ) : ?>
    <meta name="description" content="<?php echo $oc_siteinfo['desc']; ?>">
    <?php endif; ?>
    <link rel="author" href="https://plus.google.com/110971881899489153670/">
    <link rel="shortcut icon" href="<?php echo $oc_siteinfo['site']; ?>common/image/favicon.ico"><?php
    // 引入 CSS 文件
    foreach( $oc_res['css'] as $css ) { ?>
    <link rel="stylesheet" href="<?php echo $css; ?>"><?php
    }
    // 引入预加载的 JavaScript 文件
    foreach ( $oc_res['js_pre'] as $js ) { ?>
    <script src="<?php echo $js; ?>"></script><?php
    }
    // WordPress 设置
    if ( $oc_setting['wpmode'] ) {
      wp_head();
    } ?>
  </head>
  <body itemscope itemtype="http://schema.org/WebPage">
<?php
  // 禁止访问
  if ( $oc_setting['forbid'] === true ) {
    if ( $oc_setting['wpmode'] && is_file(get_stylesheet_directory() . '/ourai-forbidden.php') ) {
      require_once( get_stylesheet_directory() . '/ourai-forbidden.php' );
    }
    else {
      @require_once( OC_APATH_PAGE . 'forbidden.php' );
    } ?>
  </body>
</html><?php die(); } ?>
