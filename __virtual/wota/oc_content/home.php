<?php

$page_title = PRJ_NAME;

function template_layout_pad() {
	global $oc_siteinfo;
	global $prj_layer_allowed; ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php echo $oc_siteinfo['home']; ?>" title="返回到首页">首页</a> &raquo; <?php echo PRJ_NAME; ?></div>
				</div>
				<div class="summary clr"><?php
					if ( !empty($prj_layer_allowed) ) {
						$db = prj_database();
						
						echo '<ul class="clr">';
						foreach( $prj_layer_allowed as $key => $mod ) { ?>
							<li class="item fl">
								<h3><a href="<?php echo $oc_siteinfo['site'] . 'wota/' . $mod['name']['en'] . '/'; ?>"><?php echo $mod['name']['zh']; ?></a></h3>
								<div style="overflow: hidden; padding-bottom: 15px;">
						<?php
							if ( $key === 'anime' ) {
								$t_total = $db->total("SELECT * FROM `wota_anime`");
								$t_done = $db->total("SELECT * FROM `wota_anime` WHERE `EPISODE_VIEW` = `EPISODE_TOTAL` AND `EPISODE_VIEW` <> 0");
								$t_wish = $db->total("SELECT * FROM `wota_anime` WHERE `EPISODE_VIEW` = 0");
								$t_collect = $db->total("SELECT * FROM `wota_anime` AS ta LEFT JOIN `wota_anime_collection` AS tb ON ta.`ID` = tb.`ANIME_ID` WHERE tb.`EPISODE_COLLECT` IS NOT NULL AND ta.`EPISODE_TOTAL` = tb.`EPISODE_COLLECT`");
								$t_top = $db->total("SELECT * FROM `wota_anime` WHERE `RATE_POINT` > 7");
								$t_items = $db->query("SELECT * FROM `wota_anime` WHERE `EPISODE_VIEW` <> 0 ORDER BY `UPDATE_DATE` DESC LIMIT 0, 10"); ?>
									<span>在看 <a href="<?php echo $oc_siteinfo['site']; ?>wota/anime/do/" title="在看的动画"><?php echo $t_total - $t_done - $t_wish; ?></a> 部／看过 <a href="<?php echo $oc_siteinfo['site']; ?>wota/anime/done/" title="看过的动画"><?php echo $t_done; ?></a> 部／想看 <a href="<?php echo $oc_siteinfo['site']; ?>wota/anime/wish/" title="想看的动画"><?php echo $t_wish; ?></a> 部／推荐 <a href="<?php echo $oc_siteinfo['site']; ?>wota/anime/top/" title="推荐的动画（评分七颗星以上）"><?php echo $t_top; ?></a> 部／收藏 <a href="<?php echo $oc_siteinfo['site']; ?>wota/anime/collect/" title="收藏的动画"><?php echo $t_collect; ?></a> 部</span>
									<b style="font-size: 1.1em;">最近观看：</b>
									<ul><?php
										foreach( $t_items as $idx => $item ) {
											echo '<li';
											if ( $idx === 0 ) {
												echo ' class="first"';
											}
											elseif ( $idx === count($t_items) - 1 ) {
												echo ' class="last"';
											}
											echo '>' . $item['animeNameZh'] . '</li>';
										}
									?></ul><?php
							}
							elseif ( $key === 'event' ) {
								$t_total = $db->total("SELECT * FROM `wota_event`");
								$t_items = $db->query("SELECT * FROM `wota_event` ORDER BY `UPDATE_DATE` DESC LIMIT 0, 10"); ?>
									<span>参加</span>
									<b style="font-size: 1.1em;">最近关注：</b>
									<ul><?php
										foreach( $t_items as $idx => $item ) {
											echo '<li';
											if ( $idx === 0 ) {
												echo ' class="first"';
											}
											elseif ( $idx === count($t_items) - 1 ) {
												echo ' class="last"';
											}
											echo '>' . $item['eventName'] . '</li>';
										}
									?></ul><?php
							} ?>
									<a class="fr" href="<?php echo $oc_siteinfo['site'] . 'wota/' . $mod['name']['en'] . '/'; ?>" title="查看全部<?php echo $mod['name']['zh']; ?>">查看更多 &raquo;</a>
								</div>
							</li>
				<?php	}
						echo '</ul>';
						
						unset($t_total);
						unset($t_items);
						unset($t_done);
						unset($t_wish);
						unset($t_collect);
						unset($t_top);
					}
				?></div>
			</div><?php
} ?>