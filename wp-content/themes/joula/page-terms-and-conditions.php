<?php
require_once 'header.php';
$terms_items = get_field('terms_items', get_the_id());
?>
<div id="page" class="site" style="min-height: 1000px;">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content style_page_form">
    <div class="grid">
      <div class="page_nav_menu">
          <?php require_once 'theme-parts/pages-sidebar.php';?>
          <div class="section_page content terms">
              <div class="section_title">
                <h1><?php echo get_the_title();?></h1>
              </div>
              <div class="page-content ">
              <div class="term-content">
                  <p><?php echo get_the_content();?></p>
                  </div>
                  <?php if(!empty($terms_items)){
                    foreach($terms_items as $term_item){
                  ?>
                    <div class="min_box">
                      <h3><?php echo $term_item['title'];?></h3>
                      <div class="term-content">
                        <?php echo $term_item['content'];?>
                      </div>
                    </div>
                  <?php } } ?>
              </div>
          </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
