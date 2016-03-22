<?php
/*
	Template Name: Archives
*/

function template_layout_pad() {
	global $posts;
	
	if ( have_posts() ) : ?>
			<div id="content">
				<div id="toolbar"><div id="footprint" class="fl"><a class="ico-hp" href="<?php bloginfo('url'); ?>" title="返回到首页">首页</a> &raquo; <a href="<?php echo site_url('/articles/'); ?>" title="查看全部文章">全部文章</a> &raquo; 全部存档</div></div>
			<?php
					$html = array();
					
					if ( empty( $posts ) ) {
						array_push( $html, '<span>There are no archives.</span>' );
					}
					else {
						$monthlyposts = array();
						$num2char = array( '01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June',
										   '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December' );
						
						foreach( $posts as $p ) {
							$monthlyposts[mysql2date( 'Y.m', $p->post_date )][] = $p;
						}
						
						foreach( $monthlyposts as $postdate => $posts ) {
							$htmlYear = array();
							list( $year, $month ) = explode( '.', $postdate );
							
							array_push( $htmlYear, '<li id="arc-month-' . $year . $month . '" class="arc-month"><h3>' . $num2char[$month] . '</h3><ul class="arc-list-daily">' );
							foreach( $posts as $post ) {
								array_push( $htmlYear, '<li class="arc-day">&nbsp;-&nbsp;' . mysql2date( 'd', $post->post_date ) . ': <a href="' . get_permalink( $post->ID ) . '" title="阅读《' . get_the_title( $post->ID ) . '》">' . get_the_title( $post->ID ) . '</a></li>' );
							}
							array_push( $htmlYear, '</ul></li>' );
							
							if ( empty($html['' . $year]) )
								$html['' . $year] = array();
								
							array_push( $html['' . $year], implode( '', $htmlYear ) );
						}
						
						echo '<ul id="archives" class="arc-list-yearly bb">';
						$html = array_reverse( $html, true );
						foreach( $html as $year => $yearHtml ) {
							echo '<li id="arc-year-' . $year . '" class="arc-year vd"><h3>'.$year.'</h3><ul class="arc-list-monthly">', implode( '', $yearHtml ), '</ul></li>';
						}
						echo '</ul>';
					}	?>
			</div>
<?php endif;
}

global $oc_module;

$oc_module = 'archive';
get_header();
get_footer(); ?>