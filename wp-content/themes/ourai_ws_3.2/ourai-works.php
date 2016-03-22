<?php
/*
  Template Name: Works
*/

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span><?php the_title(); ?><?php
}

function template_layout_main() {
  if ( have_posts() ) : the_post(); ?>
  <p class="project_info">There are <span class="repo_count">0</span> repositories hosted on <a href="https://github.com/ourai" rel="external nofollow">GitHub</a>.</p>
  <ol class="repos"></ol><?php
  endif;
}

global $oc_module;

$oc_module = 'works';
get_header();
get_footer(); ?>