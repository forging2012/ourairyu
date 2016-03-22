  <?php
    if ( OC_MOBILE === false ) {
      global $oc_res;
      global $oc_setting;
      global $oc_mobile;
      
      if ( $oc_setting['wpmode'] === true ) {
        wp_footer();
      }
    
      if ( gettype($oc_res['js']) !== 'array' ) {
        $oc_res['js'] = array();
      }
      
      foreach( $oc_res['js'] as $js ) { ?>
    <script src="<?php echo $js; ?>"></script>
    <?php
      }
    } ?>
  </body>
</html>
