<?php

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        update_post_caches( $post );

        $t_date = get_the_time('U');
        $t_class = array('entry', 'list-item');
        $t_index = $wp_query->current_post;

        if ( $t_index === 0 ) :
            array_push( $t_class, 'first' );
        endif;

        if ( $t_index === $wp_query->post_count - 1 ) :
            array_push( $t_class, 'last' );
        endif;

        $t_class = implode(' ', $t_class) ?>
        <article class="<?php echo $t_class; ?>">
            <header class="entry-header">
                <h2 class="entry-title hover-noline"><a href="<?php the_permalink(); ?>" title="阅读《<?php the_title(); ?>》"><?php the_title(); ?></a></h2>
                <div class="entry-info">
                    <time datetime="<?php echo date('Y-m-d H:m:s', $t_date); ?>" class="date"><?php echo date('M jS, Y', $t_date); ?></time>
                    <div class="tags"><?php count(get_the_tags()) > 0 ? the_tags('', '', '') : ''; ?></div>
                </div>
            </header>
            <div class="entry-excerpt"><?php the_excerpt(); ?></div>
            <footer class="entry-footer action">
                <a class="read-more" href="<?php the_permalink(); ?>">more &raquo;</a>
            </footer>
        </article>
    <?php
    endwhile;

    unset( $t_date );
    unset( $t_class );
    unset( $t_index );

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <div class="pagination">
        <?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
            <span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
            <span class="older right"><?php next_posts_link(__('下一页')); ?></span>
        <?php endif; ?>
        </div>
    <?php
    endif;
else :
    echo 'There is no posts.';
endif;

?>