				</div>
				<div id="sidebar"><?php get_sidebar(); ?></div>
			</div>
			<div id="footer">
				<img class="scroll-top" src="<?php bloginfo('template_url'); ?>/images/button_top.png" title="返回到顶部" alt="返回到顶部" />
				<div class="block clearfix">
					<div id="figure"><img src="<?php bloginfo('template_url'); ?>/images/figure.png" alt="形象图" /></div>
					<ul id="copyright">
						<li class="first">&copy; 2009 - <?php echo date('Y'); ?> <a href="http://www.otakism.com/">宅男的部屋</a></li>
						<?php
						/*
						<li>Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a></li>
						<li>Theme designed by <a href="http://blog.otakism.com/">Ourai</a> based on <a href="http://www.neoease.com/" target="_blank">NeoEase</a></li>
						*/
						?>
					</ul>
					<ul id="navigationFooter">
						<!-- <li class="first"><a href="javascript:void(0);" title="">关于本站</a></li>
						<li><a href="javascript:void(0);" title="">网站地图</a></li>
						<li><a href="javascript:void(0);" title="">联系站长</a></li> -->
						<?php wp_list_pages('title_li=0&sort_column=menu_order'); ?>
						<li><script src="http://s95.cnzz.com/stat.php?id=3373203&web_id=3373203" language="JavaScript"></script></li>
					</ul>
					<script type="text/javascript">
						$("#navigationFooter li:first").addClass("first");
					</script>
					<div id="mark"></div>
				</div>
			</div>
		</div>
		
		<?php wp_footer(); ?>
	</body>
</html>