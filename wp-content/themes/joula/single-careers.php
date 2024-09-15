<?php
require_once 'header.php';
$careers_data = get_field('careers_data');
?>
<div id="single-careers" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content style_page_form single-careers">
    <div class="grid">
      <div class="section_page">
        <div class="section_title">
          <img src="<?php echo get_the_post_thumbnail_url();?>">
          <h1><?php echo get_the_title();?></h1>
          <p><?php echo get_the_content();?></p>
        </div>
        <div class="section_faq">
          <h2>Apply Now</h2>
          <?php if(!empty($careers_data['caldera_form_shortcode'])){echo do_shortcode($careers_data['caldera_form_shortcode']);}?>
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
