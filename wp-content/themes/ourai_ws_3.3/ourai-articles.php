<?php
/*
    Template Name: Articles
*/

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php echo bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span>全部文章<?php
}

function template_layout_main() {
   get_template_part('content');
}

function template_layout_sidebar() { ?>
        <?php
            global $oc_hide_cats;

            $t_cat_html = oc_hide_cats_html( $oc_hide_cats );

            if ( !empty( $t_cat_html ) ) { ?>
            <div class="module">
                <div class="module_content">
                    <p style="margin: 0; padding: 0;"><b class="larger">列表中不包含——</b><br><?php echo implode(' ', $t_cat_html) . (count($t_cat_html) === 1 ? ' ' : ' 等'); ?>类别的文章</p>
                </div>
            </div>
    <?php   } ?>
            <div class="module">
                <h3 class="module_title">新鲜吐槽</h3>
                <div class="module_content"><?php
                    $t_cmts = oc_recent_comments();

                    if ( count($t_cmts) > 0 ) { ?>
                    <ul class="comment_list"><?php
                        foreach( $t_cmts as $cmt ) { ?>
                        <li class="activity">
                            <a class="comment_url clr" href="<?php echo get_permalink($cmt->comment_post_ID); ?>" title="<?php echo get_the_title($cmt->comment_post_ID); ?>" rel="nofollow">
                                <?php echo get_avatar($cmt->comment_author_email, 36, '', $cmt->comment_author); ?>
                                <span class="activity_content">
                                    <span class="name fl"><?php echo $cmt->comment_author; ?></span>
                                    <span class="date fl"><?php echo $cmt->comment_date_gmt; ?></span>
                                    <span class="comment_content txt-elp"><?php echo strip_tags($cmt->comment_content); ?></span>
                                </span>
                            </a>
                        </li>
                <?php   }
                    ?></ul>
            <?php   }
                    else { ?>
                    <p>槽点太低，没人吐槽！</p>
            <?php   }

                ?></div>
            </div>
            <div class="module">
                <h3 class="module_title"><span>热门标签</span><span class="separator">&rsaquo;</span><a rel="tag" class="more" href="<?php echo site_url('/tags/'); ?>" title="查看全部文章标签">more</a></h3>
                <div class="module_content clr"><?php
                    $tags = get_tags(array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 15 ));
                    
                    foreach( $tags as $tag ) {
                        ?><a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag" rel="tag" title="查看与 <?php echo $tag->name; ?> 相关的文章"><span class="tag_name"><?php echo $tag->name; ?></span><span class="tag_count"><?php echo $tag->count; ?></span><i></i></a><?php
                    }
                ?></div>
            </div>
    <?php
}

global $oc_module;

$oc_module = 'article';
get_header();
get_footer(); ?>