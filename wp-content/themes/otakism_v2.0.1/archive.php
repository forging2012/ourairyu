<?php get_header(); ?>
<?php
	$options = get_option('inove_options');
	if (function_exists('wp_list_comments')) {
		add_filter('get_comments_number', 'comment_count', 0);
	}
	
	$postslimitednum = get_option('posts_per_page');
?>

<?php if (is_search()) : ?>
	<div class="presentation">
		<h3><?php _e('Search Results', 'inove'); ?></h3>
		<span><?php printf( __('Keyword: &#8216;%1$s&#8217;', 'inove'), wp_specialchars($s, 1) ); ?></span>
	</div>

<?php else : ?>
	<?php if(is_category() || is_tag() || is_day() || is_month() || is_year()) : ?>
	<div id="postpath">
		<a title="<?php _e('Go to homepage', 'inove'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'inove'); ?></a>
		<?php
			if(is_category()) :
				$result = new WP_Query('cat='.get_cat_ID(single_cat_title('', false)).'&posts_per_page=-1');
				$postslimitednum = count($result->posts);
				
				$parentcats = get_ancestors(get_cat_ID(single_cat_title('', false)), 'category');
				if(count($parentcats)>0) {
					foreach($parentcats as $i) {
						echo ' &raquo; ';
						$cat = get_category($i);
						echo '<a href=\''.get_category_link($i).'\' title=\'查看&nbsp;'.$cat->cat_name.'&nbsp;的全部文章\'>'.$cat->cat_name.'</a>';
					}
				}
				echo ' &raquo; ';
				single_cat_title('', true);
		?>
		<?php elseif(is_tag()) : $result = new WP_Query('tag='.single_tag_title('', false).'&posts_per_page=-1'); $postslimitednum = count($result->posts); ?>
		 &raquo; <?php single_tag_title('', true); ?>
		<?php elseif(is_day()) : $day = getdate(get_the_time('U')); $result = new WP_Query('year='.$day['year'].'&monthnum='.$day['mon'].'&day='.$day['mday'].'&posts_per_page=-1'); $postslimitednum = count($result->posts); ?>
		 &raquo; <?php echo date('M j, Y', get_the_time('U')); ?>
		<?php elseif(is_month()) : $day = getdate(get_the_time('U')); $result = new WP_Query('year='.$day['year'].'&monthnum='.$day['mon'].'&posts_per_page=-1'); $postslimitednum = count($result->posts); ?>
		 &raquo; <?php echo date('M, Y', get_the_time('U')); ?>
		<?php elseif(is_year()) : $day = getdate(get_the_time('U')); $result = new WP_Query('year='.$day['year'].'&posts_per_page=-1'); $postslimitednum = count($result->posts); ?>
		 &raquo; <?php echo date('Y', get_the_time('U')); ?>
		<?php endif; ?>
	</div>
	<?php else : ?>
	<div class="presentation">
		<h3><?php _e('Archive', 'inove'); ?></h3>
		<span>
			<?php
			if (is_author()) {
				_e('Author Archive', 'inove');
			// If this is a paged archive
			} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
				_e('Blog Archives', 'inove');
			}
			?>
		</span>
	</div>
	<?php endif; ?>
<?php endif; ?>

<?php if (have_posts()) : ?>
					<ul id="posts">
	<?php while (have_posts()) : the_post(); update_post_caches($posts); $curcate = get_the_category(); $curcate = $curcate[0]; ?>
							<li id="post_<?php the_ID(); ?>" class="separator">
								<div class="top clearfix">
									<div class="category left cat_<?php echo $curcate->category_nicename; ?>"><?php the_category(', '); ?></div>
									<div class="meta">
										<div class="clearfix"><a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a><div class="switcher close" title="点击展开">swticher</div></div>
										<div class="clearfix"><span class="date"><?php echo date('M j, Y H:i:s', get_the_time('U')); ?></span><span class="comments"><?php comments_popup_link(__('0'), __('1'), __('%'), '', __('Comments off')); ?></span></div>
									</div>
								</div>
								<div class="bottom clearfix"><?php the_excerpt(); ?><a href="<?php the_permalink(); ?>" class="more left" title="查看更多关于《<?php the_title(); ?>》的内容">Read more &raquo;</a></div>
							</li>
	<?php endwhile; ?>
					</ul>
					<script>
						$(document).ready(function() {
							$(".switcher:lt(5)", $("#posts")).trigger("click");
						});
					</script>
					<?php if($postslimitednum > get_option('posts_per_page')) : ?>
						<div id="pagination" class="clearfix">
						<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
							<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
							<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
						<?php endif; ?>
						</div>
					<?php endif; ?>
<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
