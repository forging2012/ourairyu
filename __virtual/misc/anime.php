<?php

/*
	@Title: 动画收藏情况统计
	@Description: 统计动画收藏情况
	@Privacy: public
*/

$oc_title = '动画收藏情况统计';
$oc_keywords = '宅文化, 御宅族, 宅男, otaku, wota, 动漫, acg, 二次元, nico, vocaloid';
$oc_desc = '统计动画收藏情况';
$oc_cmn_url = 'http://'.$_SERVER['HTTP_HOST'].'/common/';
$oc_files_css = array( $oc_cmn_url . 'css/doc.css', 'http://'.$_SERVER['HTTP_HOST'].'/misc/css/anime.css' );

get_global_header(); ?>
		<div id="sidebar" class="catalog">
			<a href="javascript:void(0);" class="log_title">年代目录</a>
			<ul id="year_catalog" class="log_section"></ul>
		</div>
		<div id="content" class="page">
			<h1 class="doc_title"><span class="fr"><?php echo $oc_title; ?></span></h1>
			<blockquote>
				<strong>播放形式</strong>
				<ol>
					<li><strong>TVA</strong>——<strong>电视动画</strong>（Television Animation），定期（一般为以周为单位）在电视连载播放的</li>
					<li><strong>OVA</strong>——<strong>原创录像动画</strong>（Original Video Animation），通过物理媒体（VHS&bull;LD&bull;DVD&bull;Blue-ray Disc等）发售或以租借为主要贩售渠道的商业动画作品</li>
					<li><strong>MVA</strong>——<strong>剧场动画</strong>（Movie Animation），在电影院上映的</li>
				</ol>
			</blockquote>
			<table class="table" data-year="1988">
				<tbody>
					<tr>
						<th></th>
						<td>魔神英雄伝ワタル</td>
						<td>1988-04-15</td>
						<td>TVA</td>
						<td>045</td>
						<td>VCD/RMVB/640×480/4.91G</td>
					</tr>
				</tbody>
			</table>
			<table class="table" data-year="2008">
				<tbody>
					<tr>
						<th></th>
						<td>true tears</td>
						<td>2008-01-05</td>
						<td>TVA</td>
						<td>013</td>
						<td>Blu-ray/MKV/1920×1080/13.2G</td>
					</tr>
					<tr>
						<th></th>
						<td>xxxHOLiC◆継</td>
						<td>2008-04-03</td>
						<td>TVA</td>
						<td>013</td>
						<td>DVD/MKV/848×480/2.62G</td>
					</tr>
					<tr data-sub-zh="华盟字幕组" data-sub-en="CASO">
						<th></th>
						<td>イタズラなKiss</td>
						<td>2008-04-04</td>
						<td>TVA</td>
						<td>025</td>
						<td>DVD/MKV/848×480/4.93G</td>
					</tr>
					<tr data-sub-zh="漫友之家-异域动漫-星尘" data-sub-en="CNMYZJ-YYDM-SD">
						<th></th>
						<td>ゼロの使い魔 ～三美姫の輪舞～</td>
						<td>2008-07-06</td>
						<td>TVA</td>
						<td>013</td>
						<td>DVD/MKV/848×480/1.58G</td>
					</tr>
					<tr data-sub-zh="澄空学园" data-sub-en="SumiSora">
						<th></th>
						<td>とらドラ！</td>
						<td>2008-10-01</td>
						<td>TVA</td>
						<td>025</td>
						<td>HDTV/RMVB/848×480/2.49G</td>
					</tr>
				</tbody>
			</table>
		</div>
<?php

$oc_files_js = array( $oc_cmn_url . 'javascript/library/jquery/jquery-1.7.1.min.js', 'http://'.$_SERVER['HTTP_HOST'].'/misc/js/anime.js' );

get_global_footer();

?>
