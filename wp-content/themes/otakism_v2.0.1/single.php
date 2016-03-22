<?php get_header(); ?>

<?php if (have_posts()) : the_post(); update_post_caches($posts); $curcate = get_the_category(); $curcate = $curcate[0]; ?>
					<div id="postpath">
						<a title="<?php _e('Go to homepage', 'inove'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'inove'); ?></a>
						 &raquo; <?php the_category(' &raquo; ', 'multiple'); ?>
						 &raquo; <?php the_title(); ?>
					</div>
					<div class="post">
						<div class="top clearfix">
							<div class="category left cat_<?php echo $curcate->category_nicename; ?>"><?php the_category(', '); ?></div>
							<div class="meta">
								<div class="clearfix"><span class="title"><?php the_title(); ?></span></div>
								<div class="clearfix"><span class="date"><?php echo date('M j, Y H:i:s', get_the_time('U')); ?></span></div>
							</div>
						</div>
						<div class="bottom"><?php the_content(); ?></div>
						<div id="sharebar" class="clearfix">分享到：<a id="qzone-share" title="QQ空间">QQ空间</a><a id="renren-share" title="人人网">人人网</a><a id="kaixin001-share" title="开心网">开心网</a><a id="douban-share" title="豆瓣">豆瓣</a><a id="tsina-share" title="新浪微博">新浪微博</a><a id="live-share" title="Windows Live">Windows Live</a><a id="gmail-share" title="Gmail">Gmail</a><a id="google-share" title="Google">Google</a><a id="delicious-share" title="Delicious">Delicious</a></div>
						<!-- <div id="announce"><strong>声明：</strong>本文采用 <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" target="_blank"><abbr title="署名-非商业性使用-相同方式共享">BY-NC-SA</abbr></a> 协议进行授权。转载请注明转自：《<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>》</div> -->
						<div id="authorinfo" class="clearfix">
							<?php
								$curauthor = get_userdata($posts[0]->post_author);
								$postedtime = get_the_time('U');
								$modifiedtime = get_the_modified_time('U');
								
								echo get_avatar($curauthor->user_email, 72);
								echo '本文由&nbsp;<a href=\'mailto:'.$curauthor->user_email.'\' title=\'发送邮件给'.$curauthor->display_name.'\' rel=\'nofollow\'><strong>'.$curauthor->display_name.'</strong></a>&nbsp;于'.date('Y年m月d日', $postedtime).'发表';
								if ($modifiedtime != $postedtime) {
									echo '，并于'.date('Y年m月d日', $modifiedtime).'最后更新';
								}
								echo '<br />分类：&nbsp;';
								count(get_the_category()) > 0 ? the_category(', ') : print('暂未分类');
								echo '<br />标签：&nbsp;';
								count(get_the_tags()) > 0 ? the_tags('', ', ', '') : print('暂无标签');
							?>
							<div>转载前请仔细阅读 <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" target="_blank" rel="copyright"><abbr title="署名-非商业性使用-相同方式共享">BY-NC-SA</abbr></a> 协议，并注明转自：《<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>》</div>
						</div>
						<div id="relatedposts">
							<?php $posttags = get_the_tags(); if(gettype($posttags) == 'array' && count($posttags)>0) : ?>
							<div><?php echo '相关文章推荐：' ?></div>
							<?php ourai_relatedposts($posttags, get_the_ID()); else : ?>
							<span>没找到相关文章</span>
							<?php endif; ?>
						</div>
					</div>
					<?php include('templates/comments.php'); ?>
<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
