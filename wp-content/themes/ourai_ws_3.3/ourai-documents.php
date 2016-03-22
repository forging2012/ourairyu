<?php
/*
	Template Name: Documents
*/

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/';

if ( !empty($_GET['dir']) ) {
	$ourai_page_title = true;
	$dir = implode('/', explode('-', $_GET['dir']));
	$url .= $dir . '/';
}
else {
	$url .= 'doc/';
}

$ourai_cur_navi = 'documents'; get_header(); ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <?php
						if ( empty($ourai_page_title) ) {
							echo '全部文档';
						}
						else {
							echo '<a href="' . site_url('/docs/') . '" title="查看全部文档">全部文档</a> &raquo; ';
						}
					?></div>
				</div>
				<script>
					function frameLoad( doc ) {
						var docTitle = doc.title.replace(" - 欧雷的文档", ""), idx = 0, divs = doc.getElementsByTagName("div");
						
						doc.body.style.minWidth = 0;
						doc.body.style.minHeight = 0;
						doc.documentElement.style.minWidth = 0;
						doc.documentElement.style.minHeight = 0;
						
						for ( ; idx < divs.length; idx++ ) {
							if ( divs[idx].className.indexOf("view-wrapper") > -1 ) {
								divs[idx].style.margin = 0;
							}
						}
						
						document.getElementById("docFrame").height = doc.documentElement.scrollHeight;
						
						if ( location.search.indexOf("dir=") > -1 ) {
							document.getElementById("footprint").appendChild(document.createTextNode(docTitle));
							document.title = docTitle + " - 宅男的部屋";
						}
						
						if ( doc.body.addEventListener ) {
							doc.body.addEventListener( "click", selectFile, false );
						}
						else {
							doc.body.attachEvent( "onclick", selectFile );
						}
					}
					
					function selectFile( event ) {
						var target, type, path;
						
						if ( event.target.tagName.toLowerCase() === "a" ) {
							target = event.target;
							type = target.parentNode.previousElementSibling.children[0].className.indexOf("dir") > -1 ? "dir" : "file";
							
							if ( type === "dir" ) {
								path = target.getAttribute("data-path").split("/");
								path.shift();
								path.pop();
								
								if ( path.length === 1 ) {
									location.search = "";
								}
								else {
									location.search = "dir=" + encodeURI(path.join("-"));
								}
							}
							else {
								window.open( target.href );
							}
						}
						
						if ( event.preventDefault ) {
							event.preventDefault();
						}
						else {
							event.returnValue = false;
						}
					}
				</script>
				<div style="padding: 5px;"><iframe id="docFrame" src="<?php echo $url; ?>" frameborder="0" width="100%"></iframe></div>
			</div>
<?php get_footer(); ?>