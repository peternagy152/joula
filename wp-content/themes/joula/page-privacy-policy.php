<?php
require_once 'header.php';
$page_content = get_field('about_page');
// var_dump($page_content);
?>
<style>
/* .page_about .section_slide .single_slide .text .content {
  color: #000000;
  font-size: 20px;
  font-weight: normal;
  line-height: 36px;
} */
</style>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content style_page_form">
      <div class="grid">
        <div class="page_nav_menu">
            <?php require_once 'theme-parts/pages-sidebar.php';?>
            <div class="section_page content terms">
              <div class="section_title">
                  <h1 ><?php echo the_title(); ?></h1>
              </div>
              <div class="page-content">
                <h3 class="policy">Joula Policies</h3>
                <?php the_content();?>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
