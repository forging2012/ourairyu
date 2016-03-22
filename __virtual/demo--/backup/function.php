<?php

function access_callback() {
	global $dir_uri;
	global $doc_toplevel;
	global $doc_page_title;
	global $oc_siteinfo;
	
//	$oc_siteinfo['title'] = (empty($doc_page_title) ? "" : $doc_page_title . ' - ') . '欧雷的工作站';
	$oc_siteinfo['title'] = 'Index of /' . implode('/', get_layers());
	
	require_once( OC_PATH_ABS . 'demo/xhtml_header.php' );
	require_once( OC_PATH_CMN . 'class/class-file.php' );
	
	$cf = new File;
	$files = $cf->traverse($dir_uri); ?>
			<div id="main">
				<div id="content">
					<h1 class="index-title"><?php
						echo 'Index of /' . implode('/', get_layers());
					?></h1>
					<div class="view-wrapper">
						<table class="view-list">
							<colgroup>
								<col style="width: 40px;" />
								<col />
								<col style="width: 150px;" />
								<col style="width: 80px;" />
								<col style="width: 300px;" />
							</colgroup>
							<thead>
								<tr>
									<th></th>
									<th class="txt-l">Name</th>
									<th class="txt-r">Last modified</th>
									<th class="txt-r">Size</th>
									<th class="txt-l">Description</th>
								</tr>
							</thead>
							<tbody><?php
								$html = array();
								$dirHTML = array();
								$fileHTML =  array();
								$dirLevel = get_layers();
								$cond = empty($_SUBDOMAIN) ? 1 : 0;
								
								if ( count($dirLevel) > $cond ) {
									array_pop($dirLevel);
									if ( !empty($dirLevel) ) {
										$filepath = '/' . implode('/', $dirLevel) . '/';
									}
									array_push($dirHTML, '<tr><td><span class="dir">文件夹</span></td><td colspan="2"><a title="回到上层" href="http://' . oc_get_domain() . $filepath . '" data-type="dir">...</a></td><td class="txt-r">-</td><td></td></tr>');
								}
									
								foreach( $files as $catname=>$cat ) {
									if ( !empty( $cat ) ) {
										foreach( $cat as $file ) {
											if ( $catname === 'dirs' ) {
												$dirname = pathinfo($dir_uri . $file, PATHINFO_BASENAME);
												$filepath = $_SERVER['REQUEST_URI'] . $dirname . '/';
												
												if ( !in_array( $dirname, array( 'res', 'javascript', 'js', 'css', 'image', 'img' ) ) ) {
													array_push($dirHTML, '<tr><td><span class="dir">文件夹</span></td><td colspan="2"><a href="http://' . oc_get_domain() . $filepath . '" data-type="dir" title="' . $dirname . '">' . $dirname . '</a></td><td class="txt-r">-</td><td></td></tr>');
												}
											}
											elseif ( $catname === 'files' ) {
												$info = $cf->info(iconv(mb_detect_encoding($file), 'UTF-8', $dir_uri . '/' . $file));
												$filepath = $_SERVER['REQUEST_URI'] . pathinfo($info['path'], PATHINFO_BASENAME);
												
												if ( $info['privacy'] === 'public' ) {
													$filesize = intval($info['size']);
													array_push($fileHTML, '<tr><td><span class="file file-' . $info['ext'] . '">' . strtoupper($info['ext']) . ' 文件</span></td><td><a href="http://' . oc_get_domain() . $filepath . '" title="' . pathinfo($info['path'], PATHINFO_BASENAME) . '" data-type="file" rel="external nofollow" target="_blank">' . pathinfo($info['path'], PATHINFO_BASENAME) . '</a></td><td class="txt-r">' . $info['modified'] . '</td><td class="txt-r">' . ($filesize/1024 > 1 ? round($filesize/1024, 1) . ' KB' : $filesize . ' B') . '</td><td class="txt-l">' . $info['description'] . '</td></tr>');
												}
											}
										}
									}
								}
								
								$html = array_merge($html, $dirHTML, $fileHTML);
								echo implode('', $html); ?>
							</tbody>
						</table>
						<script type="text/javascript">
							var rows = document.getElementsByTagName("table")[0].getElementsByTagName("tbody")[0] .getElementsByTagName("tr");
							rows[0].setAttribute("class", "first");
							rows[rows.length - 1].setAttribute("class", "last");
						</script>
					</div>
				</div>
				<div id="overlay">遮罩层</div>
			</div><?php
	require_once( OC_PATH_ABS . 'demo/xhtml_footer.php' );
}

?>