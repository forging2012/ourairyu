<?php
/*
Plugin Name: wp slug translate
Plugin URI: http://blog.2i2j.com
Version: 1.5
Description: set slug by translate title or slug from chinese to english with google translate or pinyin. 通过将title用google translate 翻译成英语或者拼音.
Author: 偶爱偶家
Author URI: http://blog.2i2j.com
*/

/*

2008-04-02
			1. 重新修改wp-slug, 适合wp2.5的后台直接显示, 同时修改翻译流程.

2008-01-13
			1. 修正google translate更改导致翻译失效, 采用正则表达式匹配.
			2. 增加自定义的iconv函数, 防止因虚拟主机没有配置iconv导致出错.
			3. 重新改写获取google translate部分, 采用snoopy, 去掉原先自定义的http_get
*/

if(!class_exists('wp_slug')):
class wp_slug{
	var $slug_name = '';
	var $slug_title = '';

	function wp_slug(){
		global $wp_version;

		add_filter('title_save_pre', array(&$this,'get_from_title'), 0);
		add_filter('name_save_pre', array(&$this,'put_to_name'), 0);
		if($wp_version > 2.4 && strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') && $_POST['action'] === 'sample-permalink'){
			add_filter('sanitize_title', array(&$this,'w25_ajax_slug'),0);
			//register_shutdown_function('remove_filter', 'sanitize_title', array(&$this,'w25_ajax_slug'), 0);
			register_shutdown_function(array(&$this,'w25_ajax_remove'));
			
		}
		
	}

	function w25_ajax_slug($name){
		remove_filter('sanitize_title', array(&$this,'w25_ajax_slug'), 0);
		if(isset($_POST['new_title'])){
			if( !(strpos($_POST['new_title'], '@@') === false) ){
			$post_titlename = explode('@@', $_POST['new_title']);
			$name = $post_titlename[1];
			unset($post_titlename);
			}
		}
		$name = $this->put_to_name($name);
		add_filter('sanitize_title', array(&$this,'w25_ajax_slug'), 0);
		return $name;
	}

	function w25_ajax_remove(){
		remove_filter('sanitize_title', array(&$this,'w25_ajax_slug'), 0);
	}

	function get_from_title($title){

		$this->slug_name = '';
		$this->slug_title = $title;
		if( !(strpos($title, '@@') === false) ){
			$post_titlename = explode('@@', $title);
		    $this->slug_title = $title = $post_titlename[0];
			$this->slug_name = $post_titlename[1];
	    }
		unset($post_titlename);
		return $title;
	}

	function put_to_name($name){

		if(!empty($this->slug_name)){
			return $this->slug_name;
		}elseif(empty($name) && !empty($this->slug_title)){
			$name = $this->slug_title;
		}else{}

		$name = strip_tags($name);
		
		if(empty($name) || !seems_utf8($name))
			return $name;

		if(!class_exists('Snoopy'))
			require_once(ABSPATH.WPINC."/class-snoopy.php");

		$snoopy = new Snoopy();
		$url = "http://translate.google.com/translate_t?langpair=zh|en";
		$submit_vars["hl"] = "zh-CN";
		$submit_vars["text"] = $name;
		$submit_vars["ie"] = "UTF8";
		$submit_vars["langpair"] = "zh|en";
		$snoopy->agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11';

		$snoopy->submit($url,$submit_vars);

		if($snoopy->status >= 200 && $snoopy->status < 300){
			$htmlret = $snoopy->results;

			if(preg_match('/<div.*?id\s*=\s*("|\')?\s*result_box\s*("|\')?.*?>/ius', $htmlret, $matchs) == 1){
				$out = explode($matchs[0],$htmlret);
				unset($matchs);
				$out = explode('</div>',$out[1]);
				$name_tmp = sanitize_user(sanitize_title($out[0]), true);
				
				unset($out,$htmlret);
				
				if(!empty($name_tmp))
					return $name_tmp;
				
				unset($name_tmp);	
			}
		}

		require_once(dirname(__FILE__) . '/pinyin.php');
		$name = get_pinyin_array($name);
		$name = sanitize_user(sanitize_title($name), true);

		$this->slug_name = "";
		$this->slug_title = "";
		unset($this->slug_name,$this->slug_title);

		return $name;
	}
}
endif;

$new_wp_slug = new wp_slug();
?>