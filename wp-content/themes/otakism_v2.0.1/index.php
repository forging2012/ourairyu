<?php
	if (preg_match('/msie\s*(\d*)/i', $_SERVER['HTTP_USER_AGENT'], $matchArray) && intval($matchArray[1]) < 7) {
		require_once('kill-ie6.php');
	}
	else {
		get_header();
?>

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
					<?php
						$postlimitnum = intval(get_option('posts_per_page'));
						$posttotal = count(get_posts('numberposts=-1'));
						
						if($posttotal > $postlimitnum) :
					?>
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
					<?php if(is_home()) : ?>
						<script>
							$(document).ready(function() {
								$(".switcher:lt(5)", $("#posts")).trigger("click");
							});
						</script>
					<?php endif; ?>

<?php get_footer(); ?>
<?php } ?>