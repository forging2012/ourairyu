<?php
/*
Template Name: Discography
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
			<div id="bodyLeft">
				<?php include('sidebar.php'); ?>
			</div>
			<div id="bodyRight">
				<div class="title"><?php the_title(); ?></div>
				<div class="content"><?php the_content(); ?></div>
			</div>
<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>
<?php get_footer(); ?>