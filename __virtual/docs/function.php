<?php

function template_variable_filter() {
	global $oc_modules;
	global $oc_env;
	
	if ( $oc_env['browser']['alias'] === 'IE' ) {
		$oc_modules['album']['enabled'] = false;
	}
}

function template_layout_pad() {
	global $dir_uri;
	global $doc_page_title;
	global $oc_siteinfo;
	global $oc_project;
	
	require_once( OC_APATH_CMN . 'class/class-file.php' );
	
	$cf = new CLS_File;
	$files = $cf->traverse($dir_uri); ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php echo $oc_siteinfo['home']; ?>" title="返回到首页">首页</a> &raquo; <?php
						if ( count(CLS_Utils::pathname()) === 1 ) {
							echo '全部文档';
						}
						else {
							echo '<a href="' . $oc_project->root . 'docs/" title="查看全部文档">全部文档</a> &raquo; ' . $doc_page_title;
						} ?>
					</div>
				</div>
				<div class="view-wrapper" style="margin: 5px;">
					<table class="view-list">
						<colgroup>
							<col style="width: 40px;">
							<col>
							<col style="width: 150px;">
							<col style="width: 150px;">
						</colgroup>
						<thead>
							<tr>
								<th></th>
								<th class="txt-l">名称</th>
								<th class="txt-r">访问日期</th>
								<th class="txt-r">修改日期</th>
							</tr>
						</thead>
						<tbody><?php
							$html = array();
							$dirHTML = array();
							$fileHTML =  array();
							$dirLevel = CLS_Utils::pathname();
							$cond = empty($_SERVER['OC_SUBDOMAIN']) ? 1 : 0;
							
							if ( count($dirLevel) > $cond ) {
								array_pop($dirLevel);
								if ( !empty($dirLevel) ) {
									$filepath = '/' . implode('/', $dirLevel) . '/';
								}
								array_push($dirHTML, '<tr><td><span class="dir">文件夹</span></td><td colspan="3"><a title="回到上层" href="http://' . $oc_project->domain . $filepath . '" data-path="' . $filepath . '" data-type="dir">...</a></td></tr>');
							}
							
							foreach( $files as $catname=>$cat ) {
								if ( !empty( $cat ) ) {
									foreach( $cat as $file ) {
										if ( $catname === 'dirs' ) {
											$dirname = pathinfo($dir_uri . $file, PATHINFO_BASENAME);
											$filepath = $_SERVER['REQUEST_URI'] . $dirname . '/';
											
											if ( !in_array( $dirname, array( 'res', 'plan' ) ) ) {
												array_push($dirHTML, '<tr><td><span class="dir">文件夹</span></td><td colspan="3"><a href="http://' . $oc_project->domain . $filepath . '" data-path="' . $filepath . '" data-type="dir">' . $dirname . '</a></td></tr>');
											}
										}
										elseif ( $catname === 'files' ) {
											$info = $cf->info(iconv(mb_detect_encoding($file), 'UTF-8', $dir_uri . '/' . $file));
											$filepath = $_SERVER['REQUEST_URI'] . $info['name'] . '/';
											
											if ( $info['privacy'] === 'public' ) {
												array_push($fileHTML, '<tr><td><span class="file file-' . $info['ext'] . '">' . strtoupper($info['ext']) . ' 文件</span></td><td><a href="http://' . $oc_project->domain . $filepath . '" title="查看《' . $info['title'] . '》" data-path="' . $filepath . '" data-type="file">' . $info['title'] . '</a></td><td class="txt-r">' . $info['accessed'] . '</td><td class="txt-r">' . $info['modified'] . '</td></tr>');
											}
										}
									}
								}
							}
							
							$html = array_merge($html, $dirHTML, $fileHTML);
							echo implode('', $html); ?>
						</tbody>
					</table>
					<script>
						var tables = document.getElementById("content").getElementsByTagName("table"),
							idx = 0;
						
						for ( idx; idx < tables.length; ) {
							if ( document.addEventListener ) {
								tables[idx++].addEventListener( "click", openFile, false );
							}
							else {
								tables[idx++].attachEvent( "onclick", openFile );
							}
						}
						
						function openFile( event ) {
							var target = event.target || event.srcElement;
							
							if ( target.tagName.toLowerCase() === "a" && target.getAttribute("data-type") === "file" ) {
								window.open( target.href );
							
								if ( event.preventDefault ) {
									event.preventDefault();
								}
								else {
									window.event.returnValue = false;
								}
								
								if ( event.stopPropagation ) {
									event.stopPropagation();
								}
								else {
									window.event.cancelBubble = true;
								}
							}
						}
					</script>
				</div>
			</div><?php
}

function access_callback() {
	global $oc_siteinfo;
	global $oc_res;
	global $oc_module;
	global $oc_project;
	
	global $doc_page_title;
	
	$template_uri = $oc_project->theme_uri( OC_THEME );
	
	$oc_siteinfo['title'] = $doc_page_title . ' - 宅男的部屋';
	$oc_module = 'document';
	$oc_res['css'] = array(
		$template_uri . 'css/global.css',
		$template_uri . 'css/main.css',
		$oc_project->root . OC_RPATH_VIRT . 'docs/res/css/view.css'
	);
	
	$oc_project->theme_layout( OC_THEME );
}

?>