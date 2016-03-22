					<div id="userinfo" class="clearfix">
						<p>今天很残酷，明天更残酷，但后天很美好，绝大部分人死在明天晚上，看不到后天的太阳。</p>
						<img src="<?php bloginfo('template_url'); ?>/images/gravatar.png" alt="Gravatar" title="欧雷" />
						<ul id="followme" class="clearfix">
							<li><a class="sns_rss" href="<?php bloginfo('rss2_url'); ?>" title="订阅本站" target="_blank"></a></li>
							<li><a class="sns_sina" href="http://weibo.com/ourairyu" title="@废柴蜀黍欧雷" target="_blank"></a></li>
							<li><a class="sns_weixin" href="http://weixin.qq.com/cgi-bin/showmsimg?uin=adbde3ca6c9efb64ad045334c7fcdad3e7d2a3888ddfbadc&t=weixin_invite&&func=invite" title="@OuraiLin" target="_blank"></a></li>
							<li><a class="sns_youku" href="http://u.youku.com/shuramaru" title="优酷视频空间" target="_blank"></a></li>
						</ul>
					</div>
					<div id="mostCommentedPosts" class="module">
						<h3>Hot Posts</h3>
						<?php ourai_mostcmtedposts(); ?>
					</div>
					<div id="recentPosts" class="module">
						<h3>Recent Posts</h3>
						<?php ourai_recentposts(); ?>
					</div>
					<div id="recentComments" class="module">
						<h3>Recent Comments</h3>
						<?php ourai_recentcomments(10); ?>
					</div>
					<div id="tagCloud" class="module">
						<h3>Tag Cloud</h3>
						<?php wp_tag_cloud('smallest=8&largest=16'); ?>
					</div>
					<div id="siteStatus" class="module last">
						<h3>Status</h3>
						<?php ourai_status(); ?>
					</div>
