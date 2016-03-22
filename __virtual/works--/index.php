<?php

global $oc_project;

if ( count(CLS_Utils::pathname()) === 1 ) {
	global $oc_siteinfo;
	global $oc_res;
	global $oc_module;
	
	$oc_siteinfo['title'] = '全部作品 - 宅男的部屋';
	$oc_siteinfo['keywords'] = '欧雷, 宅男, 部屋, 作品, HTML, CSS, JavaScript';
	$oc_siteinfo['desc'] = '展示我的作品及项目';
	$oc_module = 'works';
	$t_template = $oc_project->theme_uri( OC_THEME );
	$oc_res['css'] = array(
		$t_template . 'css/global.css',
		$t_template . 'css/main.css',
		$t_template . 'css/album.css'
	);
	unset($t_template);
	
	function template_layout_pad() {
		global $oc_siteinfo;
		global $oc_project; ?>
				<div id="content">
					<div id="toolbar">
						<div id="footprint" class="fl"><a class="ico-hp" href="<?php echo $oc_siteinfo['home']; ?>" title="返回到首页">首页</a> &raquo; 全部作品</div>
					</div>
					<div>
						<ul class="alb-lst">
							<?php
								$cf = new CLS_File;
								$t_curdir = substr($_SERVER['REQUEST_URI'], 1);
								
								if ( substr($t_curdir, -1) !== '/' ) {
									$t_curdir .= '/';
								}
								
								$t_cururi = $oc_project->root . $t_curdir;
								$t_curdir = $oc_project->virtual_dir . $t_curdir;
								
								$files = $cf->traverse($t_curdir);
								$demo_files = array();
								
								foreach( $files as $catname=>$cat ) {
									if ( !empty( $cat ) ) {
										foreach( $cat as $file ) {
											$t_file;
											$t_fileinfo;
											$t_fileuri = '#';
											$t_thumbnail = '';
											
											if ( $catname === 'dirs' ) {
												$t_file = $t_curdir . $file . '/index.php';
												$t_fileuri = array_pop(explode('/', pathinfo($t_file, PATHINFO_DIRNAME)));
												$t_thumbnail = $file . '/thumbnail.png';
											}
											elseif ( $catname === 'files' ) {
												$t_file = $t_curdir . $file;
												$t_fileuri = pathinfo($t_file);
												$t_fileuri = $t_fileuri['filename'];
											}
											
											if ( is_file( $t_file ) ) {
												$t_fileinfo = $cf->info(iconv(mb_detect_encoding($t_file), 'UTF-8', $t_file));
												$t_title = $t_fileinfo['title'];
												$t_fileuri = $t_cururi . $t_fileuri . '/';
												
												if ( is_file( $t_curdir . $t_thumbnail ) ) {
													$t_thumbnail = $t_cururi . $t_thumbnail;
												} ?>
							<li class="alb-data"><a class="alb-itm" href="<?php echo $t_fileuri; ?>" rel="external"><img class="alb-crv" src="<?php echo $t_thumbnail; ?>" alt="<?php echo $t_title; ?>" title="<?php echo $t_fileinfo['description']; ?>"><span class="alb-ttl txt-elp" title="<?php echo $t_title; ?>"><?php echo $t_title; ?></span></a></li>
												<?php
											}
										}
									}
								}
							?>
						</ul>
					</div>
				</div>
		<?php
	}
	
	$oc_project->theme_layout( OC_THEME );
}
else {
	$oc_project->view_dir($oc_project->virtual_dir . array_shift(CLS_Utils::pathname()));
}

?>
