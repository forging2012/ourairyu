<?php

if ( !class_exists('CLS_File') ) :

/**
 * Class CLS_File
 * 
 * 处理文件
 * 
 * @package		CLS_File
 * @author		Ourai Lin <ourairyu@hotmail.com>
 * @copyright	2012 Otakism
 */
class CLS_File {

	public function __construct() {
		// 设置默认的时间带
		date_default_timezone_set( 'Etc/GMT-8' );
	}
	
	/**
	 * 文件扩展名专为 MIME
	 * 
	 * @param	{String} fileExtesion
	 * @return	{String}
	 */
	private function ext2mime( $fileExtension = "" ) {
		$mimeLib = array(
			// 文本
			'html' => 'text/html; charset=UTF-8',
			'css' => 'text/css; charset=UTF-8',
			
			// 程序
			'js' => 'application/javascript; charset=UTF-8',
			
			// 图片
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'png' => 'image/png',
			'ico' => 'image/x-icon'
		);
		
		return !empty( $fileExtension ) && !empty( $mimeLib[$fileExtension] ) ? $mimeLib[$fileExtension] : null;
	}

	/**
	 * 遍历获取指定路径（可以是文件也可以是目录）所在目录下的所有目录及文件
	 * 
	 * @param	{String} path
	 * @param	{Array} hideDirs
	 * @return	{Array}
	 */
	public function traverse( $path = '', $hideDirs = array() ) {
		$result = array( 'files' => array(), 'dirs' => array() );
		
		if ( is_string( $path ) && is_readable( $path ) ) {
			if ( !is_array($hideDirs) ) {
				$hideDirs = array();
			}

			if ( is_file( $path ) ) {
				$path = dirname( $path );
			}
				
			if ( $handle = opendir( $path ) ) {
				while( ($file = readdir( $handle )) !== false ) {
					if ( $file == '.' || $file == '..' )
						continue;
						
					if ( is_file( $path . '/' . $file ) ) {
						$fileext = strtolower(pathinfo( $file, PATHINFO_EXTENSION ));
						$filename = pathinfo( $file, PATHINFO_BASENAME );
						$filename = explode( '.', $filename );
						$filename = strtolower($filename[0]);
						
						if ( in_array( $filename, array( 'index', 'default' ) ) && in_array( $fileext, array( 'php', 'html' ) ) || empty( $fileext ) ) {
							continue;
						}
						
						array_push( $result['files'], $file );
					}
					else {
						if ( in_array($file, $hideDirs) ) {
							continue;
						}
						
						array_push( $result['dirs'], $file );
					}
				}
				
				clearstatcache();
				closedir( $handle );
			}
		}
		
		return $result;
	}
	
	/**
	 * 获取文件信息
	 * 
	 * @param	{String} path
	 * @return
	 */
	public function info( $path = '' ) {
		$result = null;
		
		// 有效路径
		if ( is_string( $path ) && is_readable( $path ) ) {
			$ext = pathinfo( $path, PATHINFO_EXTENSION );
			$infoSrc = $path;

			if ( is_dir($path) ) {
				$infoSrc .= '/';

				// 从 README.di 中读取文件夹信息
				if ( is_file($infoSrc . 'README.di') ) {
					$infoSrc .= 'README.di';
				}
				// 从 index.php 中读取文件夹信息
				else {
					$infoSrc .= 'index.php';
				}
			}
			
			// 拼装返回值
			$result = array(
				'title' => null,
				'privacy' => null,
				'description' => null,
				'path' => $path,
				'name' => basename( $path, '.' . $ext ),
				'ext' => $ext,
				'size' => filesize( $path ),
				'type' => filetype( $path ),
				'accessed' => date( 'Y-m-d H:i:s', fileatime( $path ) ),
				'modified' => date( 'Y-m-d H:i:s', filemtime( $path ) )
			);
			
			// 从信息源中读取文件（夹）描述性信息
			if ( is_file($infoSrc) && preg_match_all( '/[\t\20]*@([^\r\n]*)[\n|\r]*/', file_get_contents($infoSrc), $match) ) {
				foreach( $match[1] as $m ) {
					$m = explode( ': ', $m );
					
					if ( count($m) === 2 ) {
						$result[strtolower($m[0])] = $m[1];
					}
				}
			}
		}
		
		return $result;
	}
	
	/**
	 * 打开给定路径的文件
	 * 
	 * @param	{String} filepath
	 * @return
	 */
	public function open( $filepath = '' ) {
		if ( is_file($filepath) ) {
			$ext = strtolower( pathinfo($filepath, PATHINFO_EXTENSION) );
			
			if ( $ext === 'php' ) {
				require_once( $filepath );
			}
			else {
				$mime = $this->ext2mime( $ext );
				
				if ( $mime ) {
					header( "Content-Type: $mime" );
					@readfile( $filepath );
				}
			}
		}
	}
	
}

endif;

?>