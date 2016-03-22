<?php

// 打印网址
function oc_siteurl() {
	echo oc_get_siteurl();
}

// 打印域名
function oc_domain() {
	echo oc_get_domain();
}

// 补零
function zerofill( $num = 0, $digit = 0 ) {
	if ( is_numeric($num) && !empty($digit) ) {
		$num = str_pad(strval($num), $digit, '0', STR_PAD_LEFT);
	}
	
	return $num;
}

?>
