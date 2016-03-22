<?php

function template_layout_breadcrumb() {
?><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a><span class="separator">&raquo;</span><?php
    echo '<a href="'.site_url('/articles/').'" title="查看全部文章">全部文章</a><span class="separator">&raquo;</span>';
    if ( is_category() ) {
        echo '<a href="' . site_url('/categories/') . '" title="查看全部文章分类">全部类别</a>';
        $parentcats = get_ancestors(get_cat_ID(single_cat_title('', false)), 'category');
        if (count($parentcats) > 0) {
            foreach($parentcats as $i) {
                echo '<span class="separator">&raquo;</span>';
                $cat = get_category($i);
                echo '<a href=\''.get_category_link($i).'\' title=\'查看&nbsp;'.$cat->cat_name.'&nbsp;的全部文章\'>'.$cat->cat_name.'</a>';
            }
        }
        echo '<span class="separator">&raquo;</span>'; unset($parentcats);
        single_cat_title('', true);
    }
    elseif ( is_tag() ) {
        echo '<a href="' . site_url('/tags/') . '" title="查看全部文章标签">全部标签</a><span class="separator">&raquo;</span>';
        single_tag_title('', true);
    }
    elseif ( is_archive() ) {
        echo '<a href="' . site_url('/archives/') . '" title="查看全部文章存档">全部存档</a><span class="separator">&raquo;</span>';
        $pd = get_the_time('U');
        if ( is_year() )
            echo date('Y', $pd).'年';
        elseif ( is_month() ) {
            echo '<a href="' . site_url('/archives/'.date('Y', $pd).'/') . '" title="查看 '.date('Y', $pd).'年 的全部文章">'.date('Y', $pd).'年</a><span class="separator">&raquo;</span>';
            echo date('Y', $pd).'年'.date('m', $pd).'月';
        }
        unset($pd);
    }
}

function template_layout_main() {
    get_template_part('content');
}

if ( is_category() ) {

function template_layout_sidebar() {
    $t_cat = get_category(get_cat_ID(single_cat_title('', false)));
    $t_posts = oc_commented_posts(-1, $t_cat->cat_ID);
    $t_count = count($t_posts);
    $t_posts = array_slice($t_posts, 0, 10); ?>
            <div class="module">
                <p style="margin: 0; padding: 0;"><span style="vertical-align: text-bottom;">所谓</span><b class="larger" style="vertical-align: text-bottom; margin: 0 .3em;"><?php echo $t_cat->name; ?></b><span style="vertical-align: text-bottom;">——</span></p>
                <p style="margin: 0; padding: 0;"><?php
                    $t_desc = $t_cat->description;

                    if ( empty($t_desc) ) {
                        echo '还是问问谷哥哥吧～';
                    }
                    else {
                        echo $t_desc;
                    }

                    unset($t_desc);
                ?></p>
                <div class="smaller" style="color: #999; margin-top: .5em; padding-top: .5em; border-top: 1px solid #EEE;">该分类下共有 <?php echo $t_count; ?> 篇文章</div>
            </div>
            <?php
                if ( count($t_posts) > 0 ) { ?>
            <div class="module">
                <h3 class="module_title">热评文章</h3>
                <div class="module_content">
                    <ul class="tiny_list n-rst">
                <?php   foreach( $t_posts as $p ) {
                            if ( $p->comment_count > 0 ) { ?>
                        <li>
                            <a href="<?php echo get_permalink($p->ID); ?>" title="阅读《<?php echo $p->post_title; ?>》"><?php echo $p->post_title; ?></a>
                            <div class="info smaller"><?php echo $p->comment_count; ?> 个评论</div>
                        </li>
                <?php       }
                        } ?>
                    </ul>
                </div>
            </div>
        <?php   }
}

}

global $oc_module;

$oc_module = is_category() ? 'categories' : (is_date() ? 'date' : 'home');
get_header();
get_footer(); ?>