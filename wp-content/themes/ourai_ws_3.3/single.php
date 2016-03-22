<?php

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span><a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a><span class="separator">&raquo;</span><a href="<?php echo site_url('/categories/'); ?>" title="查看全部文章分类">全部类别</a><span class="separator">&raquo;</span><?php the_category('<span class="separator">&raquo;</span>', 'multiple'); ?><?php
}

function template_layout_pad() {
	global $oc_project;
    global $oc_siteinfo;
	
	$postdate = 0;
	
	if ( have_posts() ) {
		the_post();
        
		$postdate = get_the_time('U'); ?>
      <div class="layout-column-two">
        <div class="layout-main">
          <article class="entry">
            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>
              <div class="entry-info">
                <time datetime="<?php echo date('Y-m-d H:m:s', $postdate); ?>" class="date"><?php echo date('M jS, Y', $postdate); ?></time>
                <div class="tags"><?php count(get_the_tags()) > 0 ? the_tags('', '', '') : ''; ?></div>
              </div>
            </header>
            <div class="entry-content"><?php the_content(); ?></div>
            <?php if ( OC_MOBILE === false ) { ?>
            <footer class="entry-footer clr">
              <!-- JiaThis Button BEGIN -->
              <div class="jiathis_style">
                <a class="jiathis_button_tsina"></a>
                <a class="jiathis_button_douban"></a>
                <a class="jiathis_button_renren"></a>
                <a class="jiathis_button_qzone"></a>
                <a class="jiathis_button_weixin"></a>
                <a href="http://www.jiathis.com/share?uid=1848802" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                <a class="jiathis_counter_style"></a>
              </div>
              <script type="text/javascript">
                var jiathis_config = {data_track_clickback:'true'};
              </script>
              <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1343908745022472" charset="utf-8"></script>
              <!-- JiaThis Button END -->
            </footer>
            <?php } ?>
          </article>
          <aside class="layout-sub">
            <?php
              global $post;

              $t_modified = mysql2date('U', $post->post_modified);
              $t_author_name = get_the_author_meta('display_name');
            ?>
            <div class="module">
              <div class="module_content user_info">
                <?php echo get_avatar(get_the_author_meta('user_email'), 128, '', $t_author_name); ?>
                <div>
                  <a class="name" href="<?php echo $oc_siteinfo['profile']; ?>" rel="external nofollow" title="查看<?php echo $t_author_name; ?>的个人空间"><?php echo $t_author_name; ?></a>
                  <div class="info smaller">更新于 <time datetime="<?php echo date('Y-m-d', $t_modified); ?>"><?php echo date('Y-m-d H:m:s', $t_modified); ?></time></div>
                </div>
              </div>
            </div>
            <?php
              unset($t_modified);
              unset($t_author_name);

              $t_posts = oc_related_posts(get_the_tags(), get_the_ID());

              if ( count($t_posts) > 0 ) { ?>
            <div class="module">
              <h3 class="module_title">相关文章</h3>
              <div class="module_content">
                <ul class="tiny_list n-rst">
              <?php   foreach( $t_posts as $p ) {
                      $t_date = mysql2date('U', $p->post_date); ?>
                  <li>
                    <a href="<?php echo get_permalink($p->ID); ?>" title="阅读《<?php echo $p->post_title; ?>》"><?php echo $p->post_title; ?></a>
                    <div class="info smaller"><time datetime="<?php echo date('Y-m-d', $t_date); ?>"><?php echo date('Y-m-d H:m:s', $t_date); ?></time></div>
                  </li>
              <?php   } ?>
                </ul>
              </div>
            </div>
          <?php   }
            ?>
          </aside>
          <?php
            comments_template('', true);
          ?>
        </div>
      </div>
<?php
	}
	
	unset($postdate);
	unset($calday);
	unset($calyear);
}

get_header();
get_footer(); ?>
