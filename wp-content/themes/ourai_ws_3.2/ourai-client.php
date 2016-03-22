<?php
/*
	Template Name: Client
*/

function is_smartmobile() {
	$ua = strtolower( $_SERVER['HTTP_USER_AGENT'] );
	$result = false;
	
	if ( preg_match( '/(android|iphone)/', $ua, $match ) ) {
		$result = $match[1];
	}
	
	return $result;
}

var_dump( is_smartmobile() );

?>

<div id="ssssssresult" style="border: 1px solid #333; background-color: #F5F5F5; padding: 10px;"></div>
<script>
var cspan = document.createTextNode( navigator.userAgent );
document.getElementById("ssssssresult").appendChild(cspan);
</script>