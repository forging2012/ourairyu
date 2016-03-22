<?php

global $oc_project;
global $oc_siteinfo;
global $oc_res;

$t_uri = $oc_project->theme_uri(OC_THEME_DOC);
$t_css = array( $oc_project->common . 'css/base.css', $t_uri . 'css/doc.css' );

$oc_res['css'] = is_array($oc_res['css']) ? array_merge($t_css, $oc_res['css']) : $t_css;

$oc_project->html_header(); ?>
    <div id="catalog"><?php if ( function_exists('template_doc_catalog') ) { template_doc_catalog(); } ?></div>
    <div id="content"><?php if ( function_exists('template_doc_content') ) { template_doc_content(); } ?></div>
<?php $oc_project->html_footer(); ?>
