<?php
/*
Template Name: Links
*/
?>

<?php
	get_header();
	$linkcats = $wpdb->get_results("SELECT T1.name AS name FROM $wpdb->terms T1, $wpdb->term_taxonomy T2 WHERE T1.term_id = T2.term_id AND T2.taxonomy = 'link_category'");
?>

<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>

	<div id="postpath">
		<a title="<?php _e('Go to homepage', 'inove'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'inove'); ?></a>
		 &raquo; <?php the_title(); ?>
	</div>
	<div class="page" id="post-<?php the_ID(); ?>">
		<div class="content">
			<?php if($linkcats) : foreach($linkcats as $linkcat) : ?>
				<div class="boxcaption"><h3><?php echo $linkcat->name; ?></h3></div>
				<div class="box linkcat">
					<ul>
						<?php
							$bookmarks = get_bookmarks('orderby=rand&category_name='.$linkcat->name);
							if ( !empty($bookmarks) ) {
								foreach ($bookmarks as $bookmark) {
									$linktarget = $bookmark->link_target == '' ? '_blank' : $bookmark->link_target;
									echo '<li><a href="'.$bookmark->link_url.'" title="'.$bookmark->link_description.'" rel=\'friend\' target=\''.$linktarget.'\'>'.$bookmark->link_name.'</a>';
									if ($bookmark->link_description != '') {
										echo '&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;'.$bookmark->link_description;
									}
									echo '</li>';
								}
							}
						?>
					</ul>
				</div>
			<?php endforeach; endif; ?>
		</div>
	</div>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
