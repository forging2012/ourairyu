<?php

function template_layout_pad() {
	global $oc_project;
	global $oc_modules;
	global $oc_siteinfo;
	global $oc_setting;
	global $posts;
	
	if ( $oc_setting['protected'] === true ) {
		require_once( get_template_directory() . '/ourai-protected-home.php' );
	}
	else {
		if ( OC_MOBILE ) { ?>
			<div>
				<div id="infomation" class="clr">
					<a href="<?php echo $oc_siteinfo['home']; ?>about/"><?php echo get_avatar('ourairyu@hotmail.com', 128, '', '欧雷'); ?></a>
					<div id="basicInfo">
						<h3 class="name">Ourai Lam</h3>
						<span class="astro">Pisces</span>, <span class="age">80s</span>
						<span class="place">Hangzhou, P.R.C.</span>
						<span class="prof">Front-end Web Developer</span>
					</div>
				</div>
				<ul id="articles"><?php
						if ( count($posts) ) {
							$temp_counter = 0;
							foreach( $posts as $p ) {
								$temp_counter++; ?>
					<li class="clr<?php
						if ( $temp_counter === 1 ) {
							echo ' first';
						}
						else if ( $temp_counter === count($posts) ) {
							echo ' last';
						}
					?>">
						<a class="fl txt-elp" href="<?php echo get_permalink($p->ID); ?>"><?php echo $p->post_title; ?></a>
						<span class="fr txt-elp"><?php echo date('Y-m-d', strtotime($p->post_date)); ?></span>
					</li>
					<?php	} ?>
					<li class="clr more"><a class="fl txt-elp" href="/articles/">查看更多 »</a></li>
				<?php	}
						else {
							echo '无新文章！';
						}
				?></ul>
			</div>
<?php	} else { ?>
			<div class="abs-ctr">
				<div class="abs-ctr-wrp">
					<div class="abs-ctr-cnt">
						<div class="vcard">
					<?php	$temp_avatar = get_avatar('ourairyu@hotmail.com', 128, '', '欧雷');
							if ( $oc_modules['about']['enabled'] ) { ?>
							<a href="<?php echo $oc_siteinfo['home']; ?>about/" title="<?php echo $oc_siteinfo['author']['zh']; ?>"><?php echo $temp_avatar; ?></a>
					<?php	} else { ?>
							<span title="<?php echo $oc_siteinfo['author']['zh']; ?>"><?php echo $temp_avatar; ?></span>
					<?php		unset($temp_avatar);
							} ?>
							<div class="bsc-info">
								<h3 class="name">Ourai Lam</h3>
								<span class="astro" data-symbol="&#9811;">Pisces</span>, <span class="age">80s</span>
								<span class="place">Hangzhou, P.R.C.</span>
								<span class="prof">Front-end Web Developer</span>
							</div>
							<div class="dtl-info">
								<div class="intro"><p>Hi~ Welcome to my website what is about <strong>technique of web development</strong>, Otakism, my life, etc. I think you will find something helpful to you here.</p></div>
							</div>
							<hr class="separator" />
							<ul class="sns-links"><?php
								$t_sns = array(
									array( 'name_en' => 'Weibo', 'name_zh' => '新浪微博', 'url' => 'http://weibo.com/ourairyu' ),
									array( 'name_en' => 'Youku', 'name_zh' => '优酷', 'url' => 'http://i.youku.com/ourailam' ),
									array( 'name_en' => 'Pinterest', 'name_zh' => '', 'url' => 'http://pinterest.com/ourai/' ),
									array( 'name_en' => 'Pixiv', 'name_zh' => '', 'url' => 'http://www.pixiv.net/member.php?id=1419195' ),
									array( 'name_en' => 'Xiami', 'name_zh' => '虾米', 'url' => 'http://www.xiami.com/u/650955' ),
									array( 'name_en' => 'Zhihu', 'name_zh' => '知乎', 'url' => 'http://www.zhihu.com/people/ourai' ),
									array( 'name_en' => 'Douban', 'name_zh' => '豆瓣', 'url' => 'http://www.douban.com/people/ourai/' ),
									array( 'name_en' => 'bgm', 'name_zh' => 'Bangumi 番组计划', 'url' => 'http://bangumi.tv/user/ourai' ),
									array( 'name_en' => 'Delicious', 'name_zh' => '美味书签', 'url' => 'http://delicious.com/ourailin' )/*,
									array( 'name_en' => 'Twitter', 'name_zh' => '推特', 'url' => 'http://twitter.com/#!/ourairyu' ),
									array( 'name_en' => 'github', 'name_zh' => 'GitHub', 'url' => 'http://github.com/ourai' ),
									array( 'name_en' => 'Facebook', 'name_zh' => '', 'url' => 'http://www.facebook.com/ourairyu' ),
									array( 'name_en' => 'Flickr', 'name_zh' => '', 'url' => 'http://www.flickr.com/photos/ourairyu/' ),
									array( 'name_en' => 'gplus', 'name_zh' => 'Google+', 'url' => 'https://plus.google.com/110971881899489153670/' ),
									array( 'name_en' => 'V2EX', 'name_zh' => 'Way to explore', 'url' => 'http://www.v2ex.com/member/ourai' )*/
								);
								
								foreach( $t_sns as $sns ) {
									$n_e = $sns['name_en'];
									$n_z = $sns['name_zh'];
									$n_z = ($n_z === '' ? $n_e : $n_z); ?>
								<li><a class="sns-<?php echo strtolower($n_e); ?>" href="<?php echo $sns['url']; ?>" title="<?php echo $n_z; ?>" rel="external nofollow"><?php echo $n_z; ?></a></li>
						<?php	} ?>
							</ul>
							<div id="siteInfo">
								<h3>Site's Info</h3>
								<ul>
									<li>Since from: 2009</li>
									<li style="display: none;">Powered by: Otakism Promotion Association</li>
									<li>Hosted on: <a href="http://www.gegehost.com/" rel="external nofollow">GegeHost</a></li>
									<li class="separator"><hr /></li>
									<li>Theme: <?php $themedata = get_theme_data( get_bloginfo('stylesheet_url') ); echo $themedata['Name'].' '.$themedata['Version']; ?></li>
									<li>Designer: Ourai Lam</li>
								</ul>
							</div>
						</div>
						<div id="news">
							<ul class="lst-wrp">
							<?php
								foreach( $oc_modules as $module ) {
									if ( $module['enabled'] === true && in_array($module['alias'], array('atc', 'otk', 'alb', 'wrk')) ) { ?>
								<li class="lst-itm mod-<?php echo $module['alias'];
										if ( $module['alias'] === 'atc' ) {
											echo ' current';
										} ?>">
									<a class="lst-ttl mod-ttl" href="<?php echo $module['url'] ? $module['url'] : 'javascript:void(0);'; ?>" title="<?php echo $module['desc'] ? $module['desc'] : $module['name']['zh']; ?>"><span><?php echo ucfirst($module['name']['en']); ?></span></a>
									<div class="lst-cnt">
										<ul class="lst-dta">
										<?php
											if ( $module['alias'] === 'atc' ) {
												if ( count($posts) ) {
													// 文章按修改时间排序
													/*function sort_posts( $a, $b ) {
														return strtotime($a->post_modified) < strtotime($b->post_modified) ? 1 : -1;
													}
													
													usort($posts, 'sort_posts');*/
													
													foreach( $posts as $p ) { ?>
											<li>
												<a class="atc-ttl fl txt-elp ltd-w" href="<?php echo get_permalink($p->ID); ?>" title="阅读《<?php echo $p->post_title; ?>》"><?php echo $p->post_title; ?></a>
												<span class="atc-date fr txt-elp ltd-w">Posted: <?php echo $p->post_date; ?></span>
											</li>
											<?php	}
												}
												else {
													echo '无新文章！';
												}
											}
											elseif ( $module['alias'] === 'otk' ) {
												require_once( OC_APATH_CLS . 'class-database.php' );
												$t_db = new CLS_Database;
												
												if ( $_SERVER['HTTP_HOST'] === 'localhost' || preg_match('/^192\.168(\.\d{1,3}){2}/', $_SERVER['HTTP_HOST']) ) {
													$t_db->select_db('wota');
												}
												else {
													$t_db->select_db('ourai_wota');
												}
												$t_animes = $t_db->query('SELECT * FROM `wota_anime` ORDER BY `UPDATE_DATE` DESC LIMIT 0, 15');
												
												foreach( $t_animes as $anime ) { ?>
											<li>
												<a class="fl txt-elp ltd-w" href="javascript:void(0);" rel="nofollow" style="cursor: default;"><?php echo $anime['animeNameZh']; ?></a>
												<span class="atc-date fr txt-elp ltd-w">Updated: <?php echo date('Y-m-d H:i:s', strtotime($anime['updateDate'])); ?></span>
											</li>
										<?php	}
												
												unset($t_db);
												unset($t_animes);
											}
											elseif ( $module['alias'] === 'alb' ) {
												require_once( OC_APATH_CLS . 'fetch-flickr/FetchFlickr.php');
												$ff = new FetchFlickr;
												$albums = $ff->getAlbum();
												$t_view = 'list';
												
												if ( $albums['stat'] == "ok" ) {
													$albums = $albums['photosets']['photoset'];
													
													if ( $t_view === 'list' ) {
														function sort_album( $a, $b ) {
															return intval($a['date_update']) < intval($b['date_update']) ? 1 : -1;
														}
														usort($albums, 'sort_album');
													}
													
													foreach( $albums as $a ) {
														if ( $t_view === 'thumbnail' ) {
															echo '<li class="alb-data">';
															echo '<a class="alb-itm" href="'.site_url('/albums/'.$a['id'].'/').'" title="浏览《'.$a['title']['_content'].'》">';
															echo '<img class="alb-crv" title="'.$a['description']['_content'].'" src="'.$a['cover'].'" />';
															echo '<span class="alb-ttl txt-elp" title="'.$a['title']['_content'].'">'.$a['title']['_content'].'</span>';
															echo '<span class="alb-count">'.$a['photos'].'</span>';
															echo '<span class="alb-btm">相册封底1</span>';
															echo '<span class="alb-btm alb-btm-sub">相册封底2</span></a></li>';
														}
														elseif ( $t_view === 'list' ) { ?>
											<li>
												<a class="fl txt-elp ltd-w" href="<?php echo site_url('/albums/' . $a['id'] . '/'); ?>" title="浏览《<?php echo $a['title']['_content']; ?>》"><?php echo $a['title']['_content']; ?></a>
												<span class="atc-date fr txt-elp ltd-w">Updated: <?php echo date('Y-m-d H:i:s', $a['date_update']); ?></span>
											</li>
											<?php		}
													}
												}
											}
											elseif ( $module['alias'] === 'wrk' ) {
												$t_fileCls = new CLS_File;
												$t_cururi = $module['url'];
												$t_dir_array = explode('/', $t_cururi);
												$t_dir = array_pop( $t_dir_array );
												
												if ( strlen($t_dir) < 2 ) {
													$t_dir = array_pop( $t_dir_array );
												}
												
												$t_dir = $oc_project->virtual_dir . $t_dir . '/';
												
												$t_files = $t_fileCls->traverse($t_dir);
												
												foreach( $t_files as $catname=>$cat ) {
													if ( !empty( $cat ) ) {
														foreach( $cat as $file ) {
															$t_file;
															$t_fileinfo;
															$t_fileuri = '#';
															
															if ( $catname === 'dirs' ) {
																$t_file = $t_dir . $file . '/index.php';
																$t_fileuri = array_pop(explode('/', pathinfo($t_file, PATHINFO_DIRNAME)));
															}
															elseif ( $catname === 'files' ) {
																$t_file = $t_dir . $file;
																$t_fileuri = pathinfo($t_file);
																$t_fileuri = $t_fileuri['filename'];
															}
															
															if ( is_file( $t_file ) ) {
																$t_fileinfo = $t_fileCls->info(iconv(mb_detect_encoding($t_file), 'UTF-8', $t_file));
																$t_title = $t_fileinfo['title'];
																$t_fileuri = $t_cururi . $t_fileuri . '/'; ?>
											<li>
												<a class="fl txt-elp ltd-w" href="<?php echo $t_fileuri; ?>" title="查看《<?php echo $t_title; ?>》" rel="external"><?php echo $t_title; ?></a>
												<span class="atc-date fr txt-elp ltd-w">Modified: <?php echo $t_fileinfo['modified']; ?></span>
											</li>
																<?php
															}
														}
													}
												}
											}
										?>
										</ul>
										<div class="lst-mta"><a class="more" title="<?php echo $module['desc'] ? $module['desc'] : $module['name']['zh']; ?>" href="<?php echo $module['url'] ? $module['url'] : 'javascript:void(0);'; ?>">查看更多 &raquo;</a></div>
									</div>
								</li>
								<?php }
								} ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
<?php
		}
	}
}

global $oc_module;

$oc_module = 'index';
get_header();
get_footer(); ?>