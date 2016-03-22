<?php

global $anime_layers;
global $anime_layerCount;
global $anime_allowed;

$page_title = $prj_layer_allowed[$prj_module]['name']['zh'];

$anime_layers = CLS_Utils::pathname();
$anime_layerCount = count($anime_layers);
$anime_allowed = array('do', 'done', 'wish', 'collect', 'top');

if ( $anime_layerCount > 2 && in_array($anime_layers[2], $anime_allowed) ) {
	switch( $anime_layers[2] ) {
		case 'do':
			$page_title = '在看';
			break;
		case 'done':
			$page_title = '看过';
			break;
		case 'wish':
			$page_title = '想看';
			break;
		case 'collect':
			$page_title = '收藏';
			break;
		case 'top':
			$page_title = '推荐';
			break;
	}
	
	$page_title .= '的动画';
}

function template_layout_pad() {
	global $anime_layers;
	global $anime_layerCount;
	global $anime_allowed;
	
	global $prj_module;
	global $prj_layer_allowed;
	
	global $page_title;
	global $oc_siteinfo;
	
	$db = prj_database();
	
	$t_limit = 10;
	$t_offset = 0;
	$t_cond = array();
	
	if ( $anime_layerCount > 2 ) {
		// 分页
		if ( $anime_layers[$anime_layerCount - 2] === 'page' && is_numeric($anime_layers[$anime_layerCount - 1]) ) {
			$t_pagenum = intval($anime_layers[$anime_layerCount - 1]);
			
			if ( $t_pagenum > 0 ) {
				$t_offset = ($t_pagenum - 1) * $t_limit;
			}
			
			unset($t_pagenum);
		}
		
		// 进度
		if ( in_array($anime_layers[2], $anime_allowed) ) {
			$t_state = $anime_layers[2];
			
			switch( $t_state ) {
				case 'do':
					array_push( $t_cond, '`EPISODE_VIEW` != `EPISODE_TOTAL`' );
					array_push( $t_cond, '`EPISODE_VIEW` <> 0' );
					break;
				case 'done':
					array_push( $t_cond, '`EPISODE_VIEW` = `EPISODE_TOTAL`' );
					array_push( $t_cond, '`EPISODE_VIEW` <> 0' );
					break;
				case 'wish':
					array_push( $t_cond, '`EPISODE_VIEW` = 0' );
					break;
				case 'collect':
					array_push( $t_cond, '`EPISODE_COLLECT` IS NOT NULL' );
					array_push( $t_cond, '`EPISODE_COLLECT` = `EPISODE_TOTAL`' );
					break;
				case 'top':
					array_push( $t_cond, '`RATE_POINT` > 7' );
					break;
			}
		}
	}
	
	// 其他过滤条件
	$t_req = $GLOBALS['_' . $_SERVER['REQUEST_METHOD']];
	if ( !empty($t_req) ) {
		if ( !empty($t_req['s']) && in_array(strtolower($t_req['s']), array('tva', 'mva', 'ova')) ) {
			array_push( $t_cond, "`ANIME_SOURCE` = '{$t_req['s']}'" );
		}
		
		$t_ts = array();
		
		foreach( $t_req as $rk=>$rv ) {
			array_push($t_ts, ($rk . '=' . $rv));
		}
		
		$t_req = '?' . implode('&', $t_ts);
		unset($t_ts);
	}
	else {
		$t_req = '';
	}
	
	$t_SQL_anime = 'SELECT t_a.*, t_c.EPISODE_COLLECT, t_c.FILE_SOURCE, t_c.FILE_EXT, t_c.FILE_PIXEL, t_c.FILE_SIZE, t_c.FANSUB, t_t.TITLE_ZH AS ANIME_POPULATION ';
	$t_SQL_anime .= 'FROM `wota_anime` AS t_a ';
	$t_SQL_anime .= 'LEFT JOIN `wota_anime_collection` AS t_c ';
	$t_SQL_anime .= 'ON t_c.ANIME_ID = t_a.ID ';
	$t_SQL_anime .= 'LEFT JOIN `wota_anime_target` AS t_t ';
	$t_SQL_anime .= 'ON t_t.ID = t_a.ANIME_TARGET ';
	
	$t_total = $db->total($t_SQL_anime . (empty($t_cond) ? '' : ' WHERE ' . implode(' AND ', $t_cond)));
	$t_pages = ceil($t_total/$t_limit);
	$t_current = $t_offset/$t_limit + 1; ?>
			<div id="content">
				<div id="toolbar">
					<div id="footprint" class="fl"><a class="ico-hp" href="<?php echo $oc_siteinfo['home']; ?>" title="返回到首页">首页</a> &raquo; <a href="<?php echo $oc_siteinfo['site']; ?>wota/" title="查看<?php echo PRJ_NAME; ?>"><?php echo PRJ_NAME; ?></a> &raquo; <?php
						if ( !empty($t_state) ) {
							$t_moduleName = $prj_layer_allowed[$prj_module]['name']['zh'];
							echo '<a href="' . $oc_siteinfo['site'] . 'wota/anime/" title="查看' . $t_moduleName . '">' . $t_moduleName . '</a> &raquo; ';
							unset($t_moduleName);
						}
						
						echo $page_title; ?></div>
					<?php if ( $t_pages > 1 && $t_current <= $t_pages ) { ?>
					<div id="pagination" class="fr">
						<div class="wp-pagenavi"><?php
						if ( empty($t_state) ) {
							$t_state = '';
						}
						else {
							$t_state .= '/';
						}
						
						$t_url = $oc_siteinfo['site'] . 'wota/anime/' . $t_state . 'page/';
						
						// 最首页
						if ( $t_pages > 5 && $t_current > 3 ) {
							echo '<a class="first" href="' . $oc_siteinfo['site'] . 'wota/anime/' . $t_state . $t_req . '" title="最首页">&laquo;</a>';
						}
						
						// 上一页
						if ( $t_current > 1 ) {
							echo '<a class="previouspostslink" href="';
							
							if ( $t_current === 2 ) {
								echo $oc_siteinfo['site'] . 'wota/anime/' . $t_state;
							}
							else {
								echo $t_url . ($t_current - 1) . '/';
							}
							
							echo $t_req . '" title="上一页">&lsaquo;</a>';
						}
						
						if ( $t_pages < 5 ) {
							$idx = 1;
							$t_page_limit = $t_pages;
						}
						elseif ( $t_current > intval($t_pages - 3) ) {
							$idx = intval($t_pages - 4);
							$t_page_limit = $t_pages;
						}
						elseif ( $t_current <= 3 ) {
							$idx = 1;
							$t_page_limit = 5;
						}
						else {
							$idx = intval($t_current - 2);
							$t_page_limit = intval($t_current + 2);
						}
						
						// 页码
						for ( ; $idx <= $t_page_limit; $idx++ ) {
							if ( $idx === $t_current ) {
								echo '<span class="current">' . $idx . '</span>';
							}
							else {
								echo '<a class="page ' . ($idx < $t_current ? 'smaller' : 'larger') . '" href="';
								
								if ( $idx === 1 ) {
									echo $oc_siteinfo['site'] . 'wota/anime/' . $t_state;
								}
								else {
									echo $t_url . $idx . '/';
								}
								
								echo $t_req . '" title="第 ' . $idx . ' 页">' . $idx . '</a>';
							}
						}
						
						// 下一页
						if ( $t_current < $t_pages ) {
							echo '<a class="nextpostslink" href="' . $t_url . ($t_current + 1) . '/' . $t_req . '" title="下一页">&rsaquo;</a>';
						}
						
						// 最末页
						if ( $t_pages > 5 && $t_current < $t_pages - 2 ) {
							echo '<a class="last" href="' . $t_url . $t_pages . '/' . $t_req . '" title="最末页">&raquo;</a>';
						}
						
						unset($t_state);
						unset($t_url); ?>
						</div>
					</div><?php } ?>
				</div>
				<div><?php
					$animes = $db->query($t_SQL_anime . (empty($t_cond) ? '' : 'WHERE ' . implode(' AND ', $t_cond)) . " ORDER BY `UPDATE_DATE` DESC LIMIT $t_offset, $t_limit");
					$genres = $db->query("SELECT * FROM `wota_anime_genre`");
					$genres_new = array();
					
					foreach( $genres as $genre ) {
						$genres_new['g_' . $genre['id']] = $genre['title'];
					}
					
					if ( !empty($animes) ) {
						echo '<ul class="view view-container view-mode-content">';
						foreach($animes as $idx => $anime) { ?>
							<li class="view-item<?php
								if ( $idx === 0 ) {
									echo ' first';
								}
								
								if ( $idx === count($animes) - 1 ) {
									echo ' last';
								}
								
								$t_date = strtotime($anime['updateDate']);
								$t_points = $anime['ratePoint'];
							?>"<?php
								// 动画收藏相关属性
								foreach( array('id', 'fileSource', 'fileExt', 'filePixel', 'fileSize', 'fansub') as $attr_key ) {
									$attr_val = $anime[$attr_key];
									
									if ( $attr_val !== '' && is_null( $attr_val ) === false ) {
										echo ' data-' . $attr_key . '="' . $attr_val . '"';
									}
								}
							?>>
								<div class="view-item-content">
									<div class="view-item-header">
										<div class="view-item-cal">
											<span class="cal-mon fl"><?php echo date('M', $t_date); ?></span>
											<span class="cal-year"><?php echo date('Y', $t_date); ?></span>
											<b class="cal-day"><?php echo date('j', $t_date); ?></b>
										</div>
										<h3 class="view-item-title"><?php echo $anime['animeNameZh']; ?></h3>
										<?php
											if ( $anime['animeGenre'] ) {
												$animeGenre = explode(',', $anime['animeGenre']);
												$t_animeGenres = array();
												
												foreach( $animeGenre as $genreId ) {
													$t_animeGenres[] = '<a href="javascript:void(0);" rel="tag">' . $genres_new['g_' . $genreId] . '</a>';
												}
												
												echo implode('', $t_animeGenres);
												
												unset($t_animeGenres);
											}
										?>
									</div>
									<div class="view-item-body clr">
										<div class="view-item-meta fr">
											<ul class="episode">
												<li class="fl first"><b class="count"><?php echo ($anime['episodeTotal'] ? $anime['episodeTotal'] : '-'); ?></b>总共</li>
												<li class="fl"><b class="count"><?php echo ($anime['episodeView'] ? $anime['episodeView'] : '-'); ?></b>看过</li>
												<li class="fl last"><b class="count"><?php echo (empty($anime['episodeCollect']) ? '-' : $anime['episodeCollect']); ?></b>收藏</li>
												<li class="separator"><hr></li>
												<li class="rate"><?php echo str_repeat('★', $t_points) . str_repeat('☆', 10 - $t_points); ?></li>
												<!--
												<li id="test">
													<dl>
														<dt>
															<a href="javascript:void(0);">评价</a>
															<a href="javascript:void(0);">收藏</a>
														</dt>
														<dd>
															<div><?php
												if ( $anime['animeReview'] ) {
													echo '<blockquote><p>' . $anime['animeReview'] . '</p></blockquote>';
												}															?></div>
															<div><?php
												if ( !empty($anime['episodeCollect']) ) { ?>
													<div class="collect">
														<table>
															<colgroup>
																<col style="width: 40px;" />
																<col />
															</colgroup>
															<tbody>
																<tr><th>翻译</th><td><?php echo $anime['fansub']; ?></td></tr>
																<tr><th>来源</th><td><?php echo $anime['fileSource']; ?></td></tr>
																<tr><th>规格</th><td><?php echo $anime['filePixel'] . '／' . $anime['fileSize']; ?></td></tr>
															</tbody>
														</table>
													</div>
											<?php	} ?></div>
														</dd>
													</dl>
												</li>-->
											</ul><?php
												if ( $anime['animeReview'] ) {
													echo '<blockquote><p>' . $anime['animeReview'] . '</p></blockquote>';
												}
												
												/*if ( !empty($anime['episodeCollect']) ) { ?>
											<div class="collect">
												<table>
													<tbody>
														<tr><th>翻译</th><td><?php echo $anime['fansub']; ?></td></tr>
														<tr><th>来源</th><td><?php echo $anime['fileSource']; ?></td></tr>
														<tr><th>规格</th><td><?php echo $anime['filePixel'] . '／' . $anime['fileSize']; ?></td></tr>
													</tbody>
												</table>
											</div>
										<?php	}*/ ?>
										</div>
										<div class="view-item-desc"><?php
											$t_dayDict = array('日', '一', '二', '三', '四', '五', '六');
											$t_image = $anime['animeImage'];
											$t_desc = $anime['animeDesc'];
											$t_broadcastBegin = strtotime($anime['broadcastBegin']);
											
											if ( !empty($t_image) ) {
												echo '<img class="fl" src="' . $t_image . '" alt="' . $anime['animeNameZh'] . '" title="' . $anime['animeNameJa'] . '">';
											}
											
											if ( !preg_match('/\<p\>/', $t_desc) ) {
												$t_desc = '<p>' . $t_desc . '</p>';
											}
											
											// 动画类型
											switch( $anime['animeSource'] ) {
												case 'tva':
													$t_source = '电视';
													$t_broadcastDate = '播放期间：';
													break;
												case 'ova':
													$t_source = '原创录像';
													$t_broadcastDate = '发行时间：';
													break;
												case 'mva':
													$t_source = '剧场';
													$t_broadcastDate = '上映时间：';
													break;
											}
											
											$t_source .= '动画';
											
											// 动画播放时间
											if ( empty($anime['broadcastBegin']) || $anime['broadcastBegin'] == '0000-00-00 00:00:00' ) {
												$t_broadcastDate .= '未知';
											}
											else {
												$t_broadcastDate .= date('Y-m-d', $t_broadcastBegin);
												
												if ( $anime['animeSource'] === 'tva' ) {
													$t_broadcastDate .= '～';
													$t_broadcastTime = ' ' . date('H:i', $t_broadcastBegin);
													
													if ( empty($anime['broadcastStop']) || $anime['broadcastStop'] == '0000-00-00 00:00:00' ) {
														$t_broadcastDate .= ($anime['episodeTotal'] == 0 ? '现在' : '未知');
													}
													else {
														$t_broadcastDate .= date('Y-m-d', strtotime($anime['broadcastStop']));
													}
												}
												else {
													$t_broadcastTime = '';
												}
												
												$t_broadcastDate .= ' 周' . $t_dayDict[date('w', $t_broadcastBegin)];
												$t_broadcastDate .=  $t_broadcastTime . '（日本时间）';
											}
											
											echo $t_desc;
											
											echo '<dl class="view-item-overview"><dt>';
											echo '<strong>' . $anime['animeNameJa'] . '</strong></dt><dd><ul>';
											echo '<li>动画来源：' . $t_source . '</li>';
											if ( !empty($anime['animePopulation']) ) {
												echo '<li>面向人群：' . $anime['animePopulation'] . '</li>';
											}
											echo '<li>' . $t_broadcastDate . '</li>';
											echo '</ul></dd></dl>';
											
											unset($t_dayDict);
											unset($t_source);
											unset($t_broadcastBegin);
											unset($t_broadcastDate);
											unset($t_broadcastTime);
											unset($t_SQL_anime);
										?></div>
									</div>
								</div>
							</li>
					<?php	}
						echo '</ul>';
					}
				?></div>
			</div><?php
} ?>