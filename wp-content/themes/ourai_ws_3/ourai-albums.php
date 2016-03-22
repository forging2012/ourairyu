<?php
/*
	Template Name: Albums
*/

function template_layout_pad() {
	global $oc_siteinfo;
	global $album;
	global $albumId;
	global $ff;
	
	$albums = $ff->getAlbum();
	$view = 'list';
	
	if ( !empty($album) ) {
		$view = 'detail';
		$ourai_page_title = $album['title']['_content'];
	} ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <?php
						if ( empty($ourai_page_title) ) {
							echo '全部相册';
						}
						else {
							echo '<a href="' . site_url('/albums/') . '" title="查看全部相册">全部相册</a> &raquo; '.$ourai_page_title;
						}
					?></div>
				</div>
				<div class="alb<?php if ( $view == 'detail' ) { echo ' alb-cnt'; } ?>">
					<div class="alb-lst-wrp">
						<a class="alb-flickr" href="http://www.flickr.com/photos/ourairyu/" rel="nofollow external" title="打开 flickr 相册">打开 flickr 相册</a>
						<a class="alb-ctrl alb-prev" href="javascript:void(0);" rel="nofollow" title="上一个">向上</a>
						<div class="alb-lst-cnt"><?php
							if ( $albums['stat'] == 'ok' ) {
								echo '<ul class="alb-lst">';
								foreach( $albums['photosets']['photoset'] as $a ) {
									echo '<li class="alb-data">';
									echo '<a class="alb-itm" href="'.site_url('/albums/'.$a['id'].'/').'" title="浏览《'.$a['title']['_content'].'》">';
									echo '<img id="'.$a['id'].'" class="alb-crv" title="'.$a['description']['_content'].'" src="'.$a['cover'].'" />';
									echo '<span class="alb-ttl txt-elp" title="'.$a['title']['_content'].'">'.$a['title']['_content'].'</span>';
									echo '<span class="alb-count">'.$a['photos'].'</span>';
									echo '<span class="alb-btm">相册封底1</span>';
									echo '<span class="alb-btm alb-btm-sub">相册封底2</span></a></li>';
								}
								echo '</ul>';
							}
							else {
								echo "<pre style=\"font: 14px/1.5 'Courier New',Courier,monospace,Sans-serif; padding: 5px;\">获取数据时发生错误：<b>{$albums['message']}</b></pre>";
							} ?>
						</div>
						<a class="alb-ctrl alb-next" href="javascript:void(0);" rel="nofollow" title="下一个">向下</a>
					</div>
					<?php if ( !empty($ourai_page_title) && $album !== null ) : ?>
					<div class="alb-dtl"<?php if ( $view == 'detail' ) { echo ' data-id="'.$albumId.'"'; } ?>>
						<div class="alb-hd">
							<div class="alb-meta fr">
								<span class="alb-count"><strong><?php echo $album['count_photos']; ?></strong> 张相片</span>
								<span class="alb-views">被围观 <strong><?php echo $album['count_views']; ?></strong> 次</span>
								<span class="alb-dt-crt"><?php echo date('Y年m月d日', $album['date_create']); ?> 创建</span>
								<span class="alb-dt-upt"><?php echo date('Y年m月d日', $album['date_update']); ?> 更新</span>
							</div>
							<h3><?php echo $ourai_page_title; ?></h3>
							<p class="alb-desc"><?php echo $album['description']['_content']; ?></p>
						</div>
						<div class="alb-bd cnt"><ul class="pto-lst"></ul></div>
						<div class="alb-link"><img src="<?php echo $album['cover']; ?>" /></div>
					</div>
					<div id="photoInfo">
						<a class="btn-close alb-close" href="javascript:void(0);" title="关闭">&#10006;</a>
						<ul class="abs-ctr"></ul>
						<?php if ( false ) : ?>
						<div class="alb-ol"></div>
						<div class="alb-tb">
							<div class="alb-meta">
							<a class="alb-crv-wrp" href="javascript:void(0);"><img class="alb-crv" src="<?php echo $album['cover']; ?>" /></a>
							</div>
							<a class="pto-lst-ctrl alb-tb-btn fl" href="<?php echo site_url('/albums/'.$albumId.'/'); ?>"><span>查看全部</span><b class="tri tri-t">三角</b></a>
							<b style="display: none;"><?php echo $ourai_page_title; ?></b>
						</div>
						<div class="pto-lst-wrp">
							<div class="pto-lst-ttl"><b><?php echo $ourai_page_title; ?> (<span class="pto-count"></span>)</b><a class="btn-close pto-close" href="javascript:void(0);" title="关闭">&#10006;</a></div>
							<a class="pto-ctrl pto-prev" href="javascript:void(0);" rel="nofollow" title="上一个">向上</a>
							<div class="pto-lst-cnt">
								<ul class="pto-lst"></ul>
							</div>
							<a class="pto-ctrl pto-next" href="javascript:void(0);" rel="nofollow" title="下一个">向下</a>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div><?php
}

global $oc_module;
global $oc_siteinfo;

require_once( OC_APATH_CLS . 'fetch-flickr/FetchFlickr.php' );
$ff = new FetchFlickr;
$album = null;

if ( preg_match('/albums\/([0-9]+)\/?/', $_SERVER['REDIRECT_URL'], $match) ) {
	$albumId = $match[1];
	$album = $ff->getAlbum($albumId);
	
	
	if ( $album['stat'] == 'ok' ) {
		$album = $album['photoset'];
		$oc_siteinfo['title'] = $album['title']['_content'];
	}
}

$oc_module = 'album';

get_header();
get_footer(); ?>