<?php
require_once 'header.php';
// $page_content = get_field('contact_page');?>
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content style_page_form">
      <div class="grid">
        <div class="page_nav_menu">
            <?php require_once 'theme-parts/pages-sidebar.php';?>
            <div class="section_page contact_us">
              <div class="section_title">
                  <h2><?php echo get_field('hero_title')?></h2>
              </div>
             
              <div class="section_contact_info">
                <?php if( have_rows('section_content_new') ): ?>
                  <div class="content">
                    <?php while( have_rows('section_content_new') ): the_row(); ?> 
                        <div class="single_content">
                            <label class="title_head">  <?php the_sub_field('title'); ?></label>
                            <?php the_sub_field('content'); ?>
                        </div>
                      <?php endwhile; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
        </div>
      </div>
    </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
