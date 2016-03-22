<?php
/*
	Template Name: Categories
*/

function template_layout_pad() {
	if ( have_posts() ) : the_post(); ?>
			<div id="content">
				<div id="toolbar"><div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a> &raquo; 全部类别</div></div>
				<?php
					global $oc_category_forbidden;
					
					$exparam = ourai_hide_categories() ? ('&exclude=' . implode(',', $oc_category_forbidden)) : '';
					$categories = ourai_sort_categories( get_categories('hide_empty=1' . $exparam) );
					$categories_keys = array_keys($categories);
					
					foreach( $categories as $cats_key => $cats ) {
						$catsClass = array('categories');
						$catsIndex = array_search($cats_key, $categories_keys);
						
						if ( $catsIndex === 0 ) {
							array_push( $catsClass, 'first' );
						}
						
						if ( $catsIndex === count($categories) - 1 ) {
							array_push( $catsClass, 'last' );
						}
						
						if ( !empty($cats['items']) ) { ?>
				<ul id="categories-<?php echo $cats['flag']; ?>" class="<?php echo implode(' ', $catsClass); ?>">
				<?php
							$htm = array();
							$counter = 0;
							
							foreach( $cats['items'] as $r ) {
								$itemClass = array('cat-item', ('cat-item-' . $r['id']));
								$counter++;
								$catName = $r['name'] . ($r['oc_private'] === true ? '（需登录浏览）' : '');
								
								if ( $counter === 1 ) {
									array_push( $itemClass, 'first' );
								}
								
								if ( $counter === count( $cats['items'] ) ) {
									array_push( $itemClass, 'last' );
								}
								
								array_push( $htm, '<li class="' . implode(' ', $itemClass) . '">' );
								array_push( $htm, ($r['count'] == 0 ? '<span class="cat-ttl">' . $catName . '</span>' : '<a class="cat-ttl" href="'.$r['url'].'" rel="category tag" title="查看&nbsp;'.$r['name'].'&nbsp;的全部文章">' . $catName . '</a> ('.$r['count'].')' ) );
								
								if ( !empty($r['desc']) ) {
									array_push( $htm, '<span class="cat-desc">'.$r['desc'].'</span>' );
								}
								
								if ( !empty($r['children']) ) {
									$children = $r['children'];
									$childItems = array();
									$count = 0;
									$passed = 0;
									
									foreach( $children as $c ) {
										$childItem = array();
										
										
										$childItemClass = array('cat-item', ('cat-item-' . $c['id']));
										$count++;
										
										if ( $count === 1 ) {
											array_push($childItemClass, 'first');
										}
										
										if ( $count === count($children) ) {
											array_push($childItemClass, 'last');
										}
										
										array_push($childItem, '<li class="' . implode(' ', $childItemClass) . '">');
										
										if ( $c['count'] == 0 ) {
											array_push($childItem, '<span class="cat-ttl">'.$c['name'].'</span>');
										}
										else {
											array_push($childItem, '<a class="cat-ttl" href="'.$c['url'].'" rel="category tag" title="查看&nbsp;'.$c['name'].'&nbsp;的全部文章">'.$c['name'].'</a> ('.$c['count'].')');
										}
										
										array_push($childItem, '<p class="cat-desc">'.(empty($c['desc']) ? '暂无类别说明' : $c['desc']).'</p></li>');
										array_push($childItems, implode('', $childItem));
									}
									
									if ( !empty($childItems) ) {
										array_push($htm, ('<ul class="children cnt clr">' . implode('', $childItems) . '</ul>'));
									}
								}
								
								array_push( $htm, '</li>' );
							}
							
							echo implode( '', $htm ); unset($htm); unset($counter);
				?>
				</ul>
				<?php	}
					}
				?>
			</div>
<?php endif;
}

global $oc_module;

$oc_module = 'categories';
get_header();
get_footer(); ?>