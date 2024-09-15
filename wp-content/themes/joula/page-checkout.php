<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package glosscairo
 */
global $language;
// get_header();

$current_user = wp_get_current_user();
?>
<?php require_once 'header.php';?>
<div id="page" class="site">
 <?php if(strpos($_SERVER['REQUEST_URI'], "order-received") !== false){ ?>
  <?php require_once 'theme-parts/main-menu.php';?>
  <?php }else{ ?>
    <?php require_once 'theme-parts/main-menu-checkout.php';?>
  <?php }  ?>
<div class="checkout-page page_checkout">
	<div class="grid">
		<?php while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
  <?php endwhile;?>
  <?php
  //echo do_shortcode('[woocommerce_checkout]');
  ?>
	</div>
</div>
</div>
<?php require_once 'footer.php';?>
<?php
if(is_user_logged_in()){
  $main_address    = mitch_get_user_main_address(get_current_user_id());
  if(!empty($main_address)){
    ?>
    <script>
        $('#billing_address_1').val('<?php echo $main_address -> full_address ?>');
        $('#billing_state').val('<?php echo $main_address -> city ?>');
        $.ajax({
                  type: "POST",
                  url: mitch_ajax_url,
                  data: {
                    action: "get_city",
                    state: '<?php echo $main_address -> city   ?>',
                  },
                  success: function (posts) {
                  // if(window.location.href.indexOf('addresses')>-1){
                      $("#billing_city").html(posts);
                      $('#billing_city').val('<?php echo $main_address -> area   ?>');
                  // }
                  },
      });
      <?php if($main_address -> apartment_type == "flat"){ ?>
        $('#billing_building').val('<?php echo $main_address -> Floor ?>');
      $('#billing_building_2').val('<?php echo $main_address -> apartment ?>');
      <?php } else {?>
        $('#billing_building').val('<?php echo 0 ?>');
      $('#billing_building_2').val('<?php echo 0 ?>');
      <?php }  ?>
   </script>
    <?php 
  }
}
?>
<?php
// get_footer();
