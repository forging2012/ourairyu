<?php

$t_login = $oc_siteinfo['home'] . 'wp-login.php';
$t_user = get_user_by('email', 'ourairyu@hotmail.com');
$t_redirect = admin_url();

if ( is_user_logged_in() ) {
	global $posts;
	
	if ( have_posts() ) : ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; 全部文章</div>
					<div id="pagination" class="fr">
					<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
						<span class="newer left"><?php previous_posts_link(__('上一页')); ?></span>
						<span class="older right"><?php next_posts_link(__('下一页')); ?></span>
					<?php endif; ?>
					</div>
				</div>
				<ul id="articles" class="view view-container view-mode-content">
				<?php
					$counter = 0;
					$postdate = 0;
					
					while ( have_posts() ) :
						the_post();
						update_post_caches($post);
						$counter++;
						$postdate = get_the_time('U'); ?>
					<li id="atc-<?php the_ID(); ?>" class="view-item<?php if ( $counter == 1 ) { echo ' first'; } if ( $counter == count($posts) ) { echo ' last'; } ?>">
						<div class="view-item-content">
							<div class="view-item-header">
								<div class="view-item-cal">
									<a class="cal-mon fl" href="<?php $calday = date('j', $postdate); $calyear = date('Y', $postdate); echo site_url('/archives/'.$calyear.'/'.date('m', $postdate)); ?>" title="<?php echo '查看'.$calyear.'年'.date('m', $postdate).'月的全部文章';?>"><?php echo date('M', $postdate); ?></a>
									<a class="cal-year" href="<?php echo site_url('/archives/'.$calyear.'/'); ?>" title="查看<?php echo $calyear;?>年的全部文章"><?php echo $calyear; ?></a>
									<b class="cal-day"><?php echo $calday; ?></b>
								</div>
								<h3><a href="<?php the_permalink(); ?>" class="title" title="阅读《<?php the_title(); ?>》"><?php the_title(); ?></a></h3>
								<?php count(get_the_tags()) > 0 ? the_tags('', '', '') : ''; ?>
							</div>
							<div class="view-item-body"><?php the_excerpt(); ?></div>
						</div>
					</li><?php
					endwhile;
					
					unset($counter);
					unset($postdate);
					unset($calday);
					unset($calyear); ?>
				</ul>
			</div>
	<?php
	endif;
}
else {
	$t_redirect = home_url();
	
	if ( !empty($_GET['oc_path']) ) {
		$t_redirect .= urldecode($_GET['oc_path']);
	} ?>
			<div class="abs-ctr">
				<div class="abs-ctr-wrp">
					<div id="loginPane" class="abs-ctr-cnt">
						<?php echo get_avatar('ourairyu@hotmail.com', 128, '', '欧雷'); ?>
						<div id="sloganWrapper">
							<div id="sloganContent">
								<p>欢迎来到我的博客，这里记录了我的生活、心情以及感悟等。</p>
								<p>谢谢您的关注与支持～♥</p>
							</div>
						</div>
						<hr class="separator">
						<form name="loginform" id="loginform" action="<?php echo $t_login; ?>" method="post" autocomplete="off">
							<div id="loginInfo">
								<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="登录" tabindex="100">
								<dl>
									<dt class="bb"><label for="user_login" title="请输入通行证帐号">用户名</label></dt>
									<dd><input type="text" name="log" id="user_login" class="input bb" value="" size="20" tabindex="10" placeholder="用户名"></dd>
									<dt class="bb"><label for="user_pass" title="请输入通行证密码">密码</label></dt>
									<dd><input type="password" name="pwd" id="user_pass" class="input bb" value="" size="20" tabindex="20" placeholder="密码"></dd>
								</dl>
								<div id="loginMeta">
									<label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90"> 记住我的登录信息</label>
									<a class="fr" href="<?php echo $t_login; ?>?action=lostpassword" title="让名侦探帮你找回密码">忘记密码？</a>
								</div>
							</div>
							<input type="hidden" name="redirect_to" value="<?php echo $t_redirect; ?>">
							<input type="hidden" name="testcookie" value="1">
						</form>
						<hr class="separator">
						<p id="registerSlogan">现在就获取通行证开始了解<?php echo $t_user->data->display_name; ?>吧！</p>
						<a id="registerButton" class="button bb" href="<?php echo $t_login; ?>?action=register" title="获取通行证"><span>获取通行</span>证</a>
						<hr class="separator">
						<div id="copyright"><span>&copy; 2009-<?php $d = getdate(); echo $d['year']; unset($d); ?> Ourai.WS</span></div>
					</div>
				</div>
			</div>
<?php
}

unset($t_login);
unset($t_user);
unset($t_redirect);

?>