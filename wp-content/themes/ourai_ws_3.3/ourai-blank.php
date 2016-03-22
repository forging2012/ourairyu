<?php
/*
	Template Name: Blank
*/

global $oc_module;

$oc_module = 'blank';

function template_layout_pad() {
	$cons = array(
		array(
			'content' => '为什么在中国的中国人有那么多人“物质”，那么多人容易被鼓动，那么多人跟流氓似的充满戾气，那么多人不互助互爱，那么多人自私自利，那么多人……那是因为他们读书太少而导致精神贫瘠、视野狭窄、内心狭隘，换而言之——井底之蛙。',
			'date' => '2012-10-15 15:53:57'
		),
		array(
			'content' => '世上无绝对的“对”与“错”，所谓的“对”与“错”只是“三观”不合所产生的矛盾，所以不要自以为是地批判别人，你有表达自己观点的资格，但没有拍死对方的权力！不要总觉得“理所当然”，没什么事情是“理所当然”让你受益的，所以要懂得感激那些为你付出的人。',
			'date' => '2012-10-19 09:00:00'
		)
	);
	
	function sort_cons( $a, $b ) {
		return strtotime($a['date']) < strtotime($b['date']) ? 1 : -1;
	}
	
	usort( $cons, 'sort_cons' ); ?>
			<ol class="n-rst" style="font-size: 1.2em;"><?php
				foreach( $cons as $c ) { ?>
				<li class="lang_zh" data-date="<?php echo $c['date']; ?>" style="margin-top: 8px;"><?php echo $c['content']; ?></li><?php
				} ?>
			</ol><?php
}

get_header();
get_footer(); ?>