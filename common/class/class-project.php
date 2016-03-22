<?php

if ( !class_exists('CLS_Project') ) :

$dir_class = dirname(__FILE__) . '/';

require_once( $dir_class . 'class-utils.php' );
require_once( $dir_class . 'class-file.php' );

/**
 * Class CLS_Project
 * 
 * 项目相关操作
 * 
 * @package		CLS_Project
 * @author		Ourai Lam <ourairyu@hotmail.com>
 * @copyright	2013 Otakism
 */	
class CLS_Project {
	
	public $virtual_dir;
	public $template_dir;
	public $template_uri;
	public $subDomain;
	public $domain;
	public $root;
	public $mainSite;
	public $common;
	public $pathname;
	public $debug;
	public $avatar;
	public $isIE;
	public $lowerIE;
	public $page;
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		$browser = CLS_Utils::browser();
	
		$this->domain = CLS_Utils::domain(false);
		$this->root = CLS_Utils::domain(true);
		$this->common = $this->root . OC_RPATH_CMN;
		$this->pathname = implode('/', CLS_Utils::pathname());

		if ( !empty($this->pathname) ) {
			$this->pathname .= '/';
		}
		
		$this->debug = in_array(strtolower($_SERVER['HTTP_HOST']), array('localhost', '127.0.0.1'));
		$this->isIE = $browser['alias'] === 'IE';
		// 浏览器是否比系统设置的所容忍最低版本的 IE 浏览器还低级
		$this->lowerIE = $this->isIE && intval($browser['version']) < OC_IE_VER;
		
		$this->subDomain = CLS_Utils::subdomain();
		$this->virtual_dir = OC_APATH_ROOT . OC_RPATH_VIRT;
		
		// 主题模板根目录的路径及 URI
		$this->template_dir = OC_APATH_TMPL;
		$this->template_uri = $this->root . OC_RPATH_TMPL;
		
		// 网站开启受保护模式
		if ( $this->protected_mode() ) {
			global $oc_setting;
			$oc_setting['protected'] = true;
		}
		
		// 主站 URL
		if ( is_null($this->subDomain) ) {
			$this->mainSite = $this->blogSite = $this->root;
		}
		else {
			$hostpart = explode('.', $_SERVER['HTTP_HOST']);
			array_shift($hostpart);
			$hostpart = implode('.', $hostpart);
			$this->mainSite = 'http://' . $hostpart . '/';
			$this->blogSite = 'http://blog' . $hostpart . '/';
			unset($hostpart);
		}

		// 页面信息
		$this->page = array(
			'title' => '',
			'path' => $this->virtual_dir . $this->pathname,
			'uri' => $this->root . $this->pathname,
			'theme' => ''
		);
	}
	
	/**
	 * 析构函数
	 */
	public function __destruct() {}
	
	/**
	 * 判断指定文件夹是否存在于虚拟目录中
	 * 
	 * @param	{String} dirname
	 * @return	{Boolean}
	 */
	private function vdir_exists( $dirname = '' ) {
		return is_dir($this->vdir_root($dirname));
	}
	
	/**
	 * 获取虚拟目录中指定文件夹的路径
	 * 
	 * @param	{String} dirname
	 * @return	{String}
	 */
	private function vdir_root( $dirname = '' ) {
		return is_string($dirname) && $dirname !== '' ? ($this->virtual_dir . $dirname . '/') : null;
	}
	
	/**
	 * 遍历虚拟目录中的指定文件夹下的文件并列出
	 * 
	 * @param	{String} dirpath
	 * @return
	 */
	private function vdir_viewdir( $dirpath = '' ) {
		if ( substr($dirpath, -1) !== '/' ) {
			$dirpath .= '/';
		}
		
		$indexFile = $dirpath . 'index.php';

		if ( is_file($indexFile) ) {
			require_once( $indexFile );
		}
		else {
			// 引入文件目录模板
			$this->theme_layout(OC_THEME_DIR);
		}
	}
	
	/**
	 * 打开虚拟目录中指定的文件
	 * 
	 * @param	{String} filepath
	 * @return
	 */
	private function vdir_viewfile( $filepath = '' ) {
		$cf = new CLS_File;
		$cf->open( $filepath );
	}
	
	/**
	 * 重定向到虚拟目录中的指定文件夹
	 * 
	 * @param	{String} dirname
	 * @return	{Boolean}
	 */
	public function vdir_redirect( $dirname = '' ) {
		global $oc_hash_subdomain;
		
		$result = false;
		$module = null;
		
		// 同局域网访问
		if ( CLS_Utils::isLAN() ) {
			$result = true;
			header('Location: http://' . $_SERVER['HTTP_HOST'] . '/work/');
		}
		else {
			// 子域名访问
			if ( array_key_exists($this->subDomain, $oc_hash_subdomain) ) {
				$_SERVER['OC_SUBDOMAIN'] = $this->subDomain;
				$module = $oc_hash_subdomain[$this->subDomain];
				
				// 模块开启才能访问
				if ( $module['enabled'] ) {
					$dirname = $module['dirname'];
					
					$this->page['path'] = $this->vdir_root($dirname) . $this->pathname;
				}
			}
			// 非调试模式下未通过二级域名方式访问开启二级域名的目录时跳转到二级域名访问方式
			else if ( !$this->debug && array_key_exists($dirname, $oc_hash_subdomain) && $oc_hash_subdomain[$dirname]['enabled'] ) {
				$domain = explode('.', $this->domain);

				if ( $domain[0] === 'www' ) {
					array_shift($domain);
				}

				array_unshift($domain, $dirname);

				$redirect = 'http://' . implode('.', $domain) . substr($_SERVER['REQUEST_URI'], strlen('/' . $dirname));

				echo '<!DOCTYPE html>';
				echo '<html>';
				echo '<head>';
				echo '<meta http-equiv="refresh" content="5; url=' . $redirect . '">';
				echo '<title>页面跳转中</title>';
				echo '</head>';
				echo '<body>';
				echo '您所访问的 http://' . $this->domain . $_SERVER['REQUEST_URI'] . ' 已经更换地址，5 秒后将自动跳转。<br>';
				echo '也可以点击 <a href="' . $redirect . '">' . $redirect . '</a> 直接访问。';
				echo '</body>';
				echo '</html>';

				exit;
			}

			// 重定向到虚拟目录
			$result = $this->view_dir($this->vdir_root($dirname));
		}
		
		return $result;
	}
	
	/**
	 * 判断指定主题文件夹是否存在
	 * 
	 * @param	{String} theme_name
	 * @return	{Boolean}
	 */
	private function theme_exists( $theme_name = '' ) {
		$exists = false;
		$pathname = $this->theme_root($theme_name);
		
		if ( $pathname ) {
			$exists = is_dir($pathname);
		}
		
		return $exists;
	}
	
	/**
	 * 获取指定主题的根目录
	 * 
	 * @param	{String} theme_name		主题所在文件夹名
	 * @return	{String}
	 */
	public function theme_root( $theme_name = '' ) {
		$pathname = null;
		
		if ( is_string($theme_name) && $theme_name !== '' ) {
			$pathname = $this->template_dir . $theme_name . '/';
		}
		
		return $pathname;
	}
	
	/**
	 * 获取指定主题的根目录 URI
	 * 
	 * @param	{String} theme_name		主题所在文件夹名
	 * @return	{String}
	 */
	public function theme_uri( $theme_name = '' ) {
		$theme_uri = null;
		
		if ( $this->theme_exists($theme_name) ) {
			$theme_uri = $this->template_uri . $theme_name . '/';
		}
		
		return $theme_uri;
	}
	
	/**
	 * 引入指定主题的 HTML 布局
	 * 
	 * @param	{String} theme_name		主题所在文件夹名
	 * @return
	 */
	public function theme_layout( $theme_name = '' ) {
		if ( $this->theme_exists($theme_name) ) {
			require_once($this->theme_root($theme_name) . 'layout.php');
		}
	}
	
	/**
	 * 引入 HTML 头部
	 * 
	 * @return
	 */
	public function html_header() {
		require_once( $this->template_dir . 'header.php' );
	}
	
	/**
	 * 引入 HTML 尾部
	 * 
	 * @return
	 */
	public function html_footer() {
		require_once( $this->template_dir . 'footer.php' );
	}
	
	/**
	 * 引入 XHTML 头部
	 * 
	 * @return
	 */
	public function xhtml_header() {
		require_once( $this->template_dir . 'xhtml_header.php' );
	}
	
	/**
	 * 引入 XHTML 尾部
	 * 
	 * @return
	 */
	public function xhtml_footer() {
		require_once( $this->template_dir . 'xhtml_footer.php' );
	}
	
	/**
	 * 遍历指定文件夹
	 * 
	 * @param	{String} dirname
	 * @return	{String}
	 */
	public function traverse_dir( $dirpath = '' ) {
		$html = array();
		
		// 有效文件夹路径
		if ( is_string($dirpath) && is_dir($dirpath) ) {
			$html_dir = array();
			$html_file = array();

			$cf = new CLS_File;
			$files = $cf->traverse($dirpath, array('res', 'javascript', 'js', 'css', 'image', 'images', 'img'));	// 隐藏跟资源相关的文件夹
			
			$dirLevel = CLS_Utils::pathname();
			$cond = empty($_SERVER['OC_SUBDOMAIN']) ? 1 : 0;
			
			// 返回到上层
			if ( count($dirLevel) > $cond ) {
				array_pop($dirLevel);
				if ( !empty($dirLevel) ) {
					$filepath = '/' . implode('/', $dirLevel) . '/';
				}
				array_push($html_dir, '<tr><td><span class="dir">文件夹</span></td><td colspan="4"><a title="回到上层" href="http://' . $this->domain . $filepath . '" data-path="' . $filepath . '" data-type="dir">...</a></td></tr>');
			}
			
			// 拼装 HTML
			foreach( $files as $catname=>$cat ) {
				if ( !empty( $cat ) ) {
					foreach( $cat as $file ) {
						// 文件夹
						if ( $catname === 'dirs' ) {
							$t_dirpath = $dirpath . $file;
							$t_dirname = pathinfo($t_dirpath, PATHINFO_BASENAME);
							$filepath = '/' . $this->pathname . $t_dirname . '/';
							$t_dirinfo = $cf->info(iconv(mb_detect_encoding($t_dirpath), 'UTF-8', $t_dirpath));
							$t_dirdesc = $t_dirinfo['description'];
							$t_hasDesc = !empty($t_dirdesc);

							if ( !empty($t_dirinfo['title']) ) {
								$t_dirname = $t_dirinfo['title'];
							}
							
							if ( $t_dirinfo['privacy'] !== 'private' ) {
								array_push($html_dir, '<tr><td><span class="dir">文件夹</span></td>');
								array_push($html_dir, '<td colspan="' . ($t_hasDesc ? 3 : 4) . '"><a href="http://' . $this->domain . $filepath . '" data-path="' . $filepath . '" data-type="dir">' . $t_dirname . '</a></td>');
								if ( $t_hasDesc ) {
									array_push($html_dir, '<td>' . $t_dirdesc . '</td>');
								}
								array_push($html_dir, '</tr>');
							}
						}
						// 文件
						elseif ( $catname === 'files' ) {
							if ( substr($dirpath, -1) !== '/' ) {
								$dirpath .= '/';
							}
							
							$info = $cf->info(iconv(mb_detect_encoding($file), 'UTF-8', $dirpath . $file));
							$filepath = $this->pathname;

							// PHP 文件不显示扩展名
							if ( $info['ext'] === 'php' ) {
								$filename = $info['name'];
								$filepath .= $filename . '/';
							}
							// .di 为自定义的文件夹信息文件，该文件不显示出来
							elseif ( $info['ext'] === 'di' ) {
								continue;
							}
							else {
								$filename = pathinfo($info['path'], PATHINFO_BASENAME);
								$filepath .= $filename;
							}
																					
							if ( $info['title'] ) {
								$fileTitle = $info['title'];
								$fileTip = '查看《' . $fileTitle . '》';
							}
							else {
								$fileTitle = $filename;
								$fileTip = $filename;
							}
							
							if ( $info['privacy'] === 'public' ) {
								$filesize = intval($info['size']);
								
								array_push($html_file, '<tr><td><span class="file file-' . $info['ext'] . '">' . strtoupper($info['ext']) . ' 文件</span></td>');
								array_push($html_file, '<td><a href="' . $this->root . $filepath . '" title="' . $fileTip . '" data-path="' . $filepath . '" data-type="file" rel="external nofollow" target="_blank">' . $fileTitle . '</a></td>');
								array_push($html_file, '<td class="txt-r">' . $info['modified'] . '</td><td class="txt-r">' . ($filesize/1024 > 1 ? round($filesize/1024, 1) . ' KB' : $filesize . ' B') . '</td><td class="txt-l">' . $info['description'] . '</td></tr>');
							}
						}
					}
				}
			}
			
			$html = array_merge($html, $html_dir, $html_file);
		}
		
		return implode('', $html);
	}
	
	/**
	 * 查看指定文件夹或文件
	 * 
	 * @param	{String} dirname
	 * @return	{Boolean}
	 */
	public function view_dir( $dirname = '' ) {
		$result = false;
		$subDomain = $this->subDomain;
		
		if ( is_dir($dirname) ) {
			if ( is_file($dirname . 'index.php') ) {
				require_once( $dirname . 'index.php' );
			}
			else {
				$dirname = $this->virtual_dir;
				$request = substr($_SERVER['REQUEST_URI'], 1);

				// 二级域名访问时
				if ( !empty($subDomain) ) {
					global $oc_hash_subdomain;

					$dirname .= $oc_hash_subdomain[$subDomain]['dirname'] . '/';
				}

				$dirname .= $request;
				
				// 打开虚拟目录中的文件
				if ( is_file($dirname) ) {
					$this->vdir_viewfile($dirname);
				}
				// 查看虚拟目录中的文件
				elseif ( is_dir($dirname) ) {
					$this->vdir_viewdir($dirname);
				}
				else {
					if ( substr($dirname, -1) === '/' ) {
						$dirname = substr($dirname, 0, (strlen($dirname) - 1));
					}
					
					$dirname .= '.php';
					
					// 不带后缀访问时引入 PHP 文件
					if ( is_file($dirname) ) {
						$this->vdir_viewfile($dirname);
					}
					// 不存在
					else {
						die( '404' );
					}
				}
			}
			
			$result = true;
		}
		
		return $result;
	}
	
	public function protected_mode() {
		return OC_PROTECTED && ($this->debug || $this->subDomain === 'blog');
	}
	
}

endif;

?>