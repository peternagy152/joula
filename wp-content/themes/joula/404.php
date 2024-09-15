<?php
$page_title = 'No Results';
require_once 'header.php';?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content style_page_form">
    <div class="grid">
      <div class="page-404">
          <h1>404</h1>
          <p><?php echo $fixed_string['page_404_descreption'];?></p>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
