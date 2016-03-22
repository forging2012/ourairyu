<?php

/**
 * FetchFlickr - PHP 5 class to play with flickr API
 * 
 * PHP version 5
 * 
 * @author    Ourai Lin <ourairyu@hotmail.com>
 * @copyright Ourai Lin 2012
 * @package   FetchFlickr
 * @version   1.0
 */
class FetchFlickr {
  private $_flickr_user;
  
  public function __construct() {
    $this->_flickr_user = array('id' => '55640473@N05', 'username' => '欧雷');
  }
  
  /**
   * 从 Flickr 获取数据并返回
   */
  private function get( $param = array() ) {
    $encoded_params = array();
    $param = array_merge(array('api_key' => 'baced9477f83d19e69b677b7cf4d7580', 'format' => 'php_serial'), $param);
    
    foreach( $param as $k => $v ) {
      $encoded_params[] = urlencode($k).'='.urlencode($v);
    }
    
    $url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
    $rsp = @file_get_contents($url);
    
    if ( $rsp === false ) {
      $rsp_obj = array('stat' => 'fail', 'code' => 999, 'message' => 'Error occurred when get Flickr\'s data.');
    }
    else {
      $rsp_obj = unserialize($rsp);
    }
    
    return $rsp_obj;
  }
  
  public function getPhotosets( $listonly = "y" ) {
    $result = $this->get( array('method' => 'flickr.photosets.getList', 'user_id' => $this->_flickr_user['id']) );
    
    if ( !empty($result['photosets']) ) {
      foreach( $result['photosets']['photoset'] as $index => $set ) {
        $result['photosets']['photoset'][$index]['cover'] = $this->getCover($set['id'], 'photos');
      }
    }
    
    return $listonly == "y" ? $result['photosets']['photoset'] : $result['photosets'];
  }
  
  public function getCover( $setid = 0, $media = 'all', $size = 'q' ) {
    $result = $this->get( array('method' => 'flickr.photosets.getPhotos', 'photoset_id' => $setid, 'media' => $media, 'privacy_filter' => 1) );
    
    if (!empty($result)) {
      $result = $result['photoset']['photo'][rand(0, (int)$result['photoset']['total']-1)];
    }
    
    return $this->getPhotoUrl($result, $size);
  }
  
  public function getRecentPhotos( $count = null ) {
    $result = $this->get( array('method' => 'flickr.people.getPublicPhotos', 'user_id' => $this->_flickr_user['id'], 'per_page' => (is_numeric($count) ? (int)$count : 15)) );
    
    if (!empty($result)) {
      foreach( $result['photos']['photo']  as $index => $photo ) {
        $result['photos']['photo'][$index]['url'] = $this->getPhotoUrl( $photo );;
      }
    }
    
    return $result['photos'];
  }
  
  /**
   * 获取图片 URL
   * 
   * @param     $photo  - 照片数据体（id、server、secret、farm）
   * @param     $size - 照片尺寸
   * @remark      s 小正方形 75x75
   *          q large square 150x150
   *          t 缩略图，最长边为 100
   *          m 小，最长边为 240
   *          n small, 320 on longest side
   *          - 中等，最长边为 500
   *          z 中等尺寸 640，最长边为 640
   *          c medium 800, 800 on longest side†
   *          b 大尺寸，最长边为 1024*
   *          o 原始图片, 根据来源格式可以是 jpg、gif 或 png
   */
  public function getPhotoUrl( $photo = array(), $size = 'n' ) {
    return 'http://farm'.$photo['farm'].'.staticflickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_'.$size.'.jpg';
  }
  
  /**
   * 获取个人信息
   */
  public function getPersonInfo() {
    $result = $this->get( array('method' => 'flickr.people.getInfo', 'user_id' => $this->_flickr_user['id']) );
    
    return $result['person'];
  }
  
  /**
   * 获取相册
   * 
   * @param     $album_id - 不为空时获取指定 ID 的相册，否则获取相册列表
   */
  public function getAlbum( $album_id = null ) {
    if ( empty($album_id) ) {
      $param = array( 'method' => 'flickr.photosets.getList', 'user_id' => $this->_flickr_user['id'] );
    }
    else {
      $param = array( 'method' => 'flickr.photosets.getInfo', 'photoset_id' => $album_id );
    }
    
    $result = $this->get( $param );
    
    if ( $result['stat'] === 'ok' ) {
      if ( empty($result['photosets']) ) {
        $cover = array_merge(array(), $result['photoset']);
        $cover['id'] = $cover['primary'];
        
        $result['photoset']['cover'] = $this->getPhotoUrl($cover, 'q');
      }
      else if ( !empty($result['photosets']['photoset']) ) {
        foreach( $result['photosets']['photoset'] as $index => $photoset ) {
          $cover = array_merge(array(), $photoset);
          $cover['id'] = $cover['primary'];
          
          $result['photosets']['photoset'][$index]['cover'] = $this->getPhotoUrl($cover, 'q');
        }
      }
    }
      
    return $result;
  }
}

?>