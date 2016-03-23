<?php

// wp_redirect(home_url() . '/articles/');
// exit;

function template_layout_page() {
  global $oc_project; ?>
    <main>
      <header>
        <div class="layout-inner">
          <div class="profile" itemscope itemtype="http://schema.org/Person">
            <a href="#" class="avatar_link"><img class="avatar" src="http://www.gravatar.com/avatar/<?php echo md5('ourairyu@hotmail.com'); ?>?s=120" itemprop="image"></a>
            <div class="profile_info">
              <h3 class="author"><a href="#" class="author_link" itemprop="name">Ourai Lin</a></h3>
              <p>Talk less, Do more. Raise my self-worth.</p>
              <a href="http://hz.ourai.ws/">Hangzhou</a>, China
            </div>
          </div>
        </div>
      </header>
      <?php

      ?>
    </main>
<?php
}

global $oc_module;

$oc_module = 'index';

get_header();
get_footer();

?>
