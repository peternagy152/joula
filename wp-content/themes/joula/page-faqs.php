<?php
require_once 'header.php';
$faq_items = get_field('faq_items', get_the_id());
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content style_page_form">
    <div class="grid">
      <div class="page_nav_menu">
          <?php require_once 'theme-parts/pages-sidebar.php';?>
          <div class="section_page">
            <div class="section_title">
              <h1><?php echo $fixed_string['faq_page_title'];?></h1>
            </div>
            <div class="section_faq">
                <?php if(!empty($faq_items)){
                  foreach($faq_items as $faq_item){
                ?>
                  <div class="single_faq">
                      <h3 class="title_faq"><?php echo $faq_item['title'];?></h3>
                      <div class="content faq">
                        <?php echo $faq_item['content'];?>
                      </div>
                  </div>
                <?php } } ?>
            </div>
            <div class="bottom-faq">
            <p class="note_faq">Still need to ask for your inquiries?</p>  <a href="<?php echo home_url('contact-us');?>">contact us</a>
            </div>
            
          </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
