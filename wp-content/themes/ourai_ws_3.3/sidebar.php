<?php if ( is_single() ) : ?>
			<div class="figure">
			<?php
				$curauthor = get_userdata($posts[0]->post_author);
				$name = $curauthor->display_name;
				//var_dump($curauthor);
				
				echo '<h3><a href="mailto:' . $curauthor->user_email . '" title="发送邮件给' . $name . '" rel="nofollow">' . get_avatar($curauthor->user_email, 96, '', $name) . $name . '</a></h3>';
				echo '<a class="hp" href="' . $curauthor->user_url . '" title="' . $name . '的主页" rel="external" target="_blank">' . $curauthor->user_url . '</a>';
				echo '<p class="desc">' . $curauthor->user_description . '</p>';
			?>
			</div>
			<dl id="related">
				<dt><h3>Related Articles</h3></dt>
				<dd><?php oc_related_posts(get_the_tags(), get_the_ID()); ?></dd>
			</dl>
			<!--
			<dl>
				<dt><h3>Comments</h3></dt>
				<dd>
					<ul>
						<li><a href="#" title="">评论 1</a></li>
						<li><a href="#" title="">评论 2</a></li>
						<li><a href="#" title="">评论 3</a></li>
						<li><a href="#" title="">评论 4</a></li>
						<li><a href="#" title="">评论 5</a></li>
					</ul>
				</dd>
			</dl>
			-->
<?php else : ?>
			<div class="intro">
				<p class="first"><span class="drop-caps">这</span>里是欧雷的个人网站，主要记录 Web 开发技术、互联网知识、二次元文化、工作生活、人生感悟等内容。</p>
				<p class="last">本站文章基本为原创，欢迎各位读者尽情转载，如果在<strong>转载时注明出处</strong>，在下将感激不尽！</p>
			</div>
			<dl id="hotatcs">
				<dt><h3>Hot Articles</h3></dt>
				<dd><?php ourai_mostcmtedposts(20); ?></dd>
			</dl>
			<dl id="rctcmts">
				<dt><h3>Recent Comments</h3></dt>
				<dd><?php oc_recent_comments(20); ?></dd>
			</dl>
<?php endif; ?>