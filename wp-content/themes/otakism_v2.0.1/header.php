<?php
	$currentblog = get_bloginfo('url');
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/msie\s*(\d*)/i', $userAgent, $matchArray) && intval($matchArray[1]) < 7) {
		header("Location: $currentblog");
	}
	else {
		$ourai_wpurl = $_SERVER['HTTP_HOST'] === 'localhost' ? 'http://www.ourai.ws' : get_bloginfo('wpurl');
		
		$matchresult = preg_match('/\S*labs\.otakism\.com/', $currentblog);
		if (gettype($matchresult) !== 'boolean' && $matchresult > 0) {
			require_once('templates/lab/header.php');
		}
		else {
			require_once('templates/default/header.php');
		}
	}
?>
