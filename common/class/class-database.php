<?php

if ( !class_exists('CLS_Database') ) :
	
/**
 * Class CLS_Database
 * 
 * 数据库操作
 * 
 * @package		CLS_Database
 * @author		Ourai Lin <ourairyu@hotmail.com>
 * @copyright	2012 Otakism
 */
class CLS_Database {
	
	private $connect;
	
	public function __construct() {
		if ( empty( $this->connect ) ) {
			$host = 'localhost';
			$isLAN = $_SERVER['HTTP_HOST'] === 'localhost' || preg_match('/^192\.168(\.\d{1,3}){2}/', $_SERVER['HTTP_HOST']);
			$user = $isLAN ? 'root' : 'ourai_lam';
			$password = $isLAN ? '' : '!(**)@@@berryz';
			
			$this->connect = mysql_connect( $host, $user, $password ) or die( 'Counld not connect to MySQL!' );
		
			mysql_query( "SET NAMES utf8", $this->connect );
			mysql_query( "SET CHARACTER SET utf8", $this->connect );
			mysql_query( "SET COLLATION_CONNECTION='utf8_general_ci'", $this->connect );
		}
	}
	
	public function __destruct() {}
	
	// 连接数据库
	public function select_db( $db_name = null, $create = false ) {
		if ( !mysql_select_db( $db_name, $this->connect ) && $create === true ) {
			$this->create_db( $db_name );
			$this->select_db( $db_name );
		}
	}
	
	public function create_db( $db_name = null ) {
		return @$this->query( "CREATE DATABASE {$db_name} CHARACTER SET utf8 COLLATE utf8_general_ci;" );
	}
	
	public function create_tb( $table_data = null ) {
		if ( !empty($table_data) ) {
			// 通过数据数组创建
			if ( gettype($table_data) === 'array' ) {
				$sql = array( "CREATE TABLE IF NOT EXISTS {$table_data['name']} (" );
				
				foreach( $table_data['columns'] as $col ) {
					array_push( $sql, $col );
				}
				
				array_push( $sql, ") {$table_data['meta']};" );
				$this->query( implode('', $sql) );
			}
			// 通过 sql 文件创建
			elseif ( gettype($table_data) === 'string' && file_exists($table_data) === true ) {
			}
		}
	}
	
	public function query( $sql ) {
		$result = @mysql_query( $sql, $this->connect );
		
		if ( $result === false ) {
			die("Invalid query: " . mysql_error());
		}
		elseif ( gettype($result) === 'resource' ) {
			$r = array();
			
			while ($row = mysql_fetch_assoc($result)) {
				$row_m = array();
				
				foreach( $row as $key=>$val ) {
					$row_m[$this->camelcase($key)] = $val;
				}
				
				array_push($r, $row_m);
			}
			
			$result = $r;
		}
		
		return $result;
	}
	
	public function total( $sql ) {
		$result = @mysql_query( $sql, $this->connect );
		
		if ( $result === false ) {
			die("Invalid query: " . mysql_error());
		}
		elseif ( gettype($result) === 'resource' ) {
			$result = mysql_num_rows($result);
		}
		
		return $result;
	}
	
	/**
	 * 将字符串转换成驼峰式写法
	 * 
	 * @param		$string
	 * @param		$upper		是否为大驼峰式（第一个单词首字母大写）
	 */
	private function camelcase( $string = '', $upper = false ) {
		if ( !empty($string) && gettype($string) === 'string' ) {
			$string = preg_replace('/\x20/', '', ucwords(preg_replace('/_/', ' ', strtolower($string))));
			
			if ( $upper === false ) {
				$string = strtolower(substr($string, 0, 1)) . substr($string, 1);
			}
		}
		
		return $string;
	}
	
}

endif;

?>