<?php wp_head();?>
<?php require_once 'header.php';?>

<div id="page" class="site" style="min-height: 1000px;">
  <?php require_once 'theme-parts/main-menu.php';
  $page_content = get_field('contact_page');?>
  <!--start page-->
    <div class="site-content style_page_form">
      <div class="grid">
        <div class="page_nav_menu">
            <?php require_once 'theme-parts/pages-sidebar.php';?>
            <div class="section_page contact_us">
              <div class="section_title">
                  <h2><?php echo $page_content['hero_section']['title'];?></h2>
                  <p><?php echo $page_content['hero_section']['subtitle'];?></p>
                  <span>Your Info.</span>
              </div>
              <div class="form_content">
                  <?php echo do_shortcode('[fluentform id="1"]');?>
              </div>
              <!-- ------------------------ ------  News Letter checkbox  --------------------------- =-->
              <div class="news-letter">
              <input type="checkbox" style = "-webkit-appearance:button;">
              <label > Would you like to receive our newsletter and latest news</label><br>
              </div>

              <div class="section_contact_info">
                <div class="box_border">
                    <h3 class="title mobile">Mobile
                      <span class="info"><?php echo $page_content['hero_section']['mobile'];?></span>
                    </h3>
                    <h3 class="title email">Email
                      <span class="info"><?php echo $page_content['hero_section']['email'];?></span>
                    </h3>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
<?php wp_footer();?>
<!-- <script type='text/javascript' src='<?php // echo $theme_settings['site_url'];?>/wp-content/plugins/caldera-forms/assets/build/js/jquery-baldrick.min.js?ver=1.9.6' id='cf-baldrick-js'></script>
<script type='text/javascript' src='<?php // echo $theme_settings['site_url'];?>/wp-content/plugins/caldera-forms/assets/build/js/parsley.min.js?ver=1.9.6' id='cf-validator-js'></script>
<script type='text/javascript' src='<?php // echo $theme_settings['site_url'];?>/wp-content/plugins/caldera-forms/clients/render/build/index.min.js?ver=1.9.6' id='cf-render-js'></script>
<script type='text/javascript' src='<?php // echo $theme_settings['site_url'];?>/wp-content/plugins/caldera-forms/assets/build/js/caldera-forms-front.min.js?ver=1.9.6' id='cf-form-front-js'></script> -->
