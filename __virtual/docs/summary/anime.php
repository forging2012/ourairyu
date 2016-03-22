<?php

/*
	@Title: 动画收藏情况统计
	@Description: 统计动画收藏情况
	@Privacy: public
*/

global $oc_siteinfo;
global $oc_project;
global $oc_res;

$oc_siteinfo['title'] = '动画收藏情况统计';
$oc_siteinfo['keywords'] = '宅文化, 御宅族, 宅男, otaku, wota, 动漫, acg, 二次元, nico, vocaloid';
$oc_siteinfo['desc'] = '统计动画收藏情况';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
			<span id="total">共收藏动画 <b></b> 部<br>文件总大小 <b></b> GB</span>
			<a href="javascript:void(0);" class="catalog_title">年代</a>
			<ul id="year_catalog" class="catalog_section"></ul>
<?php
}

function template_doc_content() { ?>
			<dl class="statement">
				<dt><strong>播放形式</strong></dt>
				<dd>
					<ul class="n-rst">
						<li><strong>TVA</strong>——<strong>电视动画</strong>（Television Animation），定期（一般为以周为单位）在电视连载播放的</li>
						<li><strong>OVA</strong>——<strong>原创录像动画</strong>（Original Video Animation），通过物理媒体（VHS&bull;LD&bull;DVD&bull;Blue-ray Disc等）发售或以租借为主要贩售渠道的商业动画作品</li>
						<li><strong>MVA</strong>——<strong>剧场动画</strong>（Movie Animation），在电影院上映的</li>
					</ul>
				</dd>
			</dl>
			<?php
				require_once( OC_APATH_CLS . 'class-database.php' );
				
				$db = new CLS_Database;
				$db->select_db(OC_DEV_MODE === 'release' ? 'ourai_misc' : 'ourai');
				$animes = $db->query('select * from `ourai_summary_anime` order by `BROADCAST_BEGIN` asc');
				
				$animes_new = array();
				foreach( $animes as $anime ) {
					$year = date('Y', strtotime($anime['broadcastBegin']));
					
					if ( empty($animes_new[$year]) ) {
						$animes_new[$year] = array();
					}
					
					array_push($animes_new[$year], $anime);
				}
				
				foreach( $animes_new as $year=>$anime ) {
			?>
			<h2 id="Year_<?php echo $year; ?>" class="n-rst" data-year="<?php echo $year; ?>"><span class="symbol">&#9798;</span> <?php echo $year; ?></h2>
			<div class="view-wrapper">
				<table class="view-list" data-year="<?php echo $year ?>">
					<colgroup>
						<col>
						<col style="width: 100px;">
						<col style="width: 100px;">
						<col style="width: 80px;">
						<col style="width: 220px;">
					</colgroup>
					<thead>
						<tr>
							<th>名字</th>
							<th>开播日期</th>
							<th>播放形式</th>
							<th>集数</th>
							<th>文件信息</th>
						</tr>
					</thead>
					<tbody>
				<?php foreach( $anime as $i=>$a ) {
						if ( $a['fileSize'] === '' ) {
							$a['fileSize'] = '0 GB';
						}
						
						$date = date('Y-m-d', strtotime($a['broadcastBegin']));
						$fs = explode(' ', $a['fileSize']); ?>
						<tr data-size="<?php echo $a['fileSize']; ?>" data-sub-zh="<?php echo $a['fansubNameZh']; ?>" data-sub-en="<?php echo $a['fansubNameEn']; ?>">
							<td class="txt-l"><?php echo '<span title="'.$a['animeNameJa'].'">'.$a['animeNameZh'].'</span>'; ?></td>
							<td class="txt-c"><?php echo '<time datetime="'.$date.'">'.$date.'</time>'; ?></td>
							<td class="txt-c"><?php echo strtoupper($a['animeSource']); ?></td>
							<td class="txt-c"><?php echo $a['episodeTotal']; ?></td>
							<td class="txt-c"><?php if ($fs[0] != 0) { echo $a['fileSource'] . '/' . strtoupper($a['fileExt']) . '/' . $a['filePixel'] . '/' . $fs[0] . substr($fs[1], 0, 1); } ?></td>
						</tr>
				<?php } ?>
					</tbody>
				</table>
			</div>
			<?php } ?>
			<script>
				var tables = document.getElementById("content").getElementsByTagName("table"),
					contents = document.getElementById("year_catalog"),
					bolds = document.getElementById("total").getElementsByTagName("b"),
					idx = 0, year, item, rows, rowIdx, count = 0, total = 0, size = 0;
				
				for ( ; idx < tables.length; idx++ ) {
					rows = tables[idx].getElementsByTagName("tbody")[0].getElementsByTagName("tr");
					count = rows.length;
					total += count;
					year = tables[idx].getAttribute("data-year");
					item = document.createElement("li");
					item.innerHTML = "&ndash; <a href=\"#Year_" + year + "\">" + year + "</a> (" + count + ")";
					contents.appendChild( item );
					
					for ( rowIdx = 0; rowIdx < rows.length; rowIdx++ ) {
						size += parseFloat( rows[rowIdx].getAttribute("data-size") );
					}
				}
				
				bolds[0].innerHTML = total;
				bolds[1].innerHTML = Math.round(size*100)/100;
			</script>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>