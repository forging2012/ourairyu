<?php

if ( !interface_exists('UtilEnv') ) :

/**
 * Interface Util Environment
 * 
 * Get infomations of running environment.
 * 
 * @package		utils
 * @author		Ourai Lam <ourairyu@hotmail.com>
 * @copyright	2012 Otakism
 */	
interface UtilEnv {
	// Get client browser's info
	public static function browser();
	
	// Get domain
	public static function domain();
	
	// Sub-domain
	public static function subdomain();
	
	// Operating system
	public static function OS();
	
	// Client IP
	public static function IP();
	
	// visit from LAN(Local Area Network)
	public static function isLAN();
	
	// get the dir level of site
	public static function pathname();
}

endif;

?>