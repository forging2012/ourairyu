<?php
/*
Template Name: Archives
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
			<?php
				/*if (function_exists('wp_easyarchives')) {
					wp_easyarchives();
				} else {
					echo '<ul>';
					wp_get_archives('type=monthly&show_post_count=1');
					echo '</ul>';
				}*/
				the_content();
			?>
		</div>
	</div>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
