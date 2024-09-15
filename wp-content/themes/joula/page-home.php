<?php
require_once 'header.php';
$page_content = get_field('home_page');
/*if(isset($_GET['test'])){
  echo '<pre>';
  var_dump($page_content);
  echo '</pre>';
}*/
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content home">
    <?php include_once 'theme-parts/home/alerts.php';?>
    <div class="page_home">
      <?php include_once 'theme-parts/home/hero-slider.php';?>
      <div class="grid">
        <?php include_once 'theme-parts/home/categories-section.php';?>
        <?php include_once 'theme-parts/home/home-products.php';?>
        <?php include_once 'theme-parts/home/repeater-banners.php';?>
        <?php  include_once 'theme-parts/home/video.php';?>
      </div>  
      <?php //include_once 'theme-parts/best-selling.php';?> 
      <?php //include_once 'theme-parts/new-arrival.php';?>
      <?php //include_once 'theme-parts/slider-reviews.php';?>
      <div class="grid">
        <?php // include_once 'theme-parts/home/section-themes.php';?>

        <?php include_once 'theme-parts/home/instgram-section.php';?>
        <?php include_once 'theme-parts/home/repeater-section.php';?>        
        <?php include 'theme-parts/home/footer-banners.php';?>
        <?php //include_once 'theme-parts/home/gift-section.php';?>
        <?php //include_once 'theme-parts/home/footer-banners.php';?>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
