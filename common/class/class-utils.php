<?php

if ( !class_exists('CLS_Utils') ) :

$dir = dirname(__FILE__) . '/utils/';

require_once( $dir . 'Environment.php' );
require_once( $dir . 'Localization.php' );

/**
 * Class CLS_Utils
 * 
 * 工具方法类
 * 用于运行环境检测、本地化等
 * 
 * @package		CLS_Utils
 * @author		Ourai Lin <ourairyu@hotmail.com>
 * @copyright	2012 Otakism
 */	
class CLS_Utils implements UtilEnv, UtilLoc {
	/* --------------------------------------
	   ---------- Start of UtilEnv ----------
	   -------------------------------------- */
	   
	/**
	 * Get client browser's info
	 * 
	 * @param		<void>
	 * 
	 * @return		<array>		array( 'type'=>'', 'alias'=>'', 'version'=>'' )
	 */
	public static function browser() {
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		$result = array();
		
		// RegExps for match browsers' user-agent string
		$browser = array(
			array( 'name' => 'Smart Phone', 'alias' => 'SP', 'regExp' => '/(android|iphone)/' ),
			array( 'name' => 'Microsoft Internet Explorer', 'alias' => 'IE', 'regExp' => '/msie ([\d.]+)/' ),
			array( 'name' => 'Mozilla Firefox', 'alias' => 'FF', 'regExp' => '/firefox\/([\d.]+)/' ),
			array( 'name' => 'Google Chrome', 'alias' => 'GC', 'regExp' => '/chrome\/([\d.]+)/' ),
			array( 'name' => 'Opera', 'alias' => 'OP', 'regExp' => '/opera.([\d.]+)/' ),
			array( 'name' => 'Apple Safari', 'alias' => 'AS', 'regExp' => '/version\/([\d.]+).*safari/' )
		);
		
		foreach ( $browser as $br ) {
			if ( preg_match( $br['regExp'], $ua, $match ) ) {
				$result['type'] = $br['name'];
				$result['alias'] = $br['alias'];
				$result['version'] = $match[1];
				
				break;
			}
		}
		
		return $result;
	}
	
	/**
	 * Get domain
	 * 
	 * @param		<boolean>	$protocol - whether with protocol
	 * 
	 * @return		<string>
	 */
	public static function domain( $protocol = true ) {
		return $protocol === true ? "http://{$_SERVER['HTTP_HOST']}/" : $_SERVER['HTTP_HOST'];
	}
	
	/**
	 * Sub-domain
	 * 
	 * @param		<void>
	 * 
	 * @return		<mixed>		if host is 'localhost', return null.
	 */
	public static function subdomain() {
		$hostname = $_SERVER['HTTP_HOST'];
		$hostpart = explode('.', $hostname);
		$result = null;
		
		if ( $hostname !== 'localhost' && count($hostpart) > 2 && $hostpart[0] !== 'www' ) {
			$result = $hostpart[0];
		}
		
		return $result;
	}
	
	/**
	 * Operating system
	 * 
	 * @param		<void>
	 * 
	 * @return		<array>		array( 'type'=>'', 'alias'=>'' )
	 */
	public static function OS() {
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		$result = array();
		
		// RegExps for match browsers' user-agent string
		$os = array(
			array( 'name' => 'Windows XP', 'regExp' => '/nt\s5\.1/' ),
			array( 'name' => 'Windows Vista', 'regExp' => '/nt\s6\.0/' ),
			array( 'name' => 'Windows Server 2003', 'regExp' => '/nt\s5\.2/' ),
			array( 'name' => 'Windows 2000', 'regExp' => '/NT\s5/' ),
			array( 'name' => 'Windows 7', 'regExp' => '/nt\s6\.1/' ),
			array( 'name' => 'Linux', 'regExp' => '/linux/' ),
			array( 'name' => 'Unix', 'regExp' => '/unix/' ),
			array( 'name' => 'Macintosh', 'regExp' => '/mac/' )
		);
		
		foreach ( $os as $o ) {
			if ( preg_match( $o['regExp'], $ua ) ) {
				$result['type'] = $o['name'];
				$result['alias'] = strtolower(strlen($o['name']) > 5 ? substr($o['name'], 0, 3) : $o['name']);
				
				break;
			}
		}
		
		return $result;
	}
	
	/**
	 * Client IP
	 * 
	 * @param		<void>
	 * 
	 * @return		<string>
	 */
	public static function IP() {
		$vars = array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' );
		
		foreach( $vars as $var ) {
			if ( getenv($var) ) {
				return getenv($var);
			}
		}
		
		return $_SERVER['REMOTE_ADDR'];
	}
	
	public static function isLAN( $segment = array() ) {
		$server = array_slice( explode('.', $_SERVER['SERVER_ADDR']), 2, 1 );	// 服务器所在的网段
		$segment = array_unique(array_merge(array(1, intval($server[0])), (gettype($segment) === 'array' ? $segment : array())));

//		exec('ipconfig /all | find /i "IPv4"', $ips);
		
		return !!preg_match('/192\.168\.(' . implode('|', $segment) . ')\.\d{1,3}/', $_SERVER['REMOTE_ADDR']);
	}
	
	public static function pathname() {
		$requri = $_SERVER['REQUEST_URI'];
		$layers = array();
		
		if ( preg_match('/\/([\w_-]+\/?)*/', $requri, $match) ) {
			$layers = explode('/', $match[0]);
			
			array_shift($layers);
			
			if ( $layers[count($layers)-1] === '' ) {
				array_pop($layers);
			}
		}
		
		return $layers;
	}
	
	/* ------------------------------------
	   ---------- End of UtilEnv ---------- 
	   ------------------------------------ */
	
	/* --------------------------------------
	   ---------- Start of UtilLoc ----------
	   -------------------------------------- */
	   
	public static function DayOfWeek( $day = null ) {
		$result = null;
		$dayDict = array('日', '一', '二', '三', '四', '五', '六');
		
		if ( is_numeric($day) ) {
			$day = intval($day);
			
			if ( $day <= count($dayDict) ) {
				$result = $dayDict[$day];
			}
		}
		
		return $result;
	}
	
	/* ------------------------------------
	   ---------- End of UtilLoc ---------- 
	   ------------------------------------ */
}

endif;

?>