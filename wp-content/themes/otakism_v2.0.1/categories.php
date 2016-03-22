<?php
/*
Template Name: Categories
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>

	<div id="postpath">
		<a title="<?php _e('Go to homepage', 'inove'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'inove'); ?></a>
		 &raquo; <?php the_title(); ?>
	</div>
	<div class="page" id="post-<?php the_ID(); ?>">
		<div>
			<ul id="categories">
			<?php
				// wp_list_categories('title_li=0&orderby=name&hide_empty=0');
				$cats = get_categories('orderby=slug&order=ASC');
				foreach($cats as $cat) {
					echo '<li class=\'cat_'.$cat->slug.' clearfix\'>';
					echo '<a href=\''.get_category_link($cat->term_id).'\' title=\'查看 '.$cat->name.' 下的所有文章\'>'.$cat->name.'</a>';
					if($cat->count > 0) {
						echo '&nbsp;<a href=\'javascript:void(0);\' class=\'switcher close\'></a>';
						echo '<ul class=\'child-posts clearfix\'>';
						$catposts = get_posts("numberposts=-1&category=$cat->cat_ID");
						foreach($catposts as $catpost) {
							echo '<li><a href=\''.get_permalink($catpost->ID).'\'>'.$catpost->post_title.'</a></li>';
						}
						echo '</ul>';
					}
					echo '</li>';
				}
			?>
			</ul>
		</div>
	</div>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
