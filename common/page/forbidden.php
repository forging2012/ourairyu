<?php

if ( preg_match('/msie\x20*(\d+)[.]/', strtolower($_SERVER['HTTP_USER_AGENT']), $mtc) && intval($mtc[1]) < 8 ) {
	echo '检测到您所使用的浏览器为 Internet Explorer '.$mtc[1].'，为了您的网络安全以及获得更好的浏览体验，请升级浏览器或者更换为其他标准浏览器。谢谢您的配合！';
}

?>
