<?php ob_start(); require_once preg_replace('/wp-content.*$/','',__DIR__).'wp-load.php'; // $theme_settings = mitch_theme_settings();?>
<!doctype html>
<html dir="ltr" lang="en">
<html>
  <head>
    <title>
      <?php
      $cate = get_queried_object(); 
      $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
      if (strpos($url,'myaccount') !== false) {
        echo "My Account" ;

      }
      else {
        if(isset($cate) && !empty($cate) && isset($cate->taxonomy)){
          $page_title = $cate->name;
        }
        if(isset($page_title)){
          echo $page_title;
        }
        else{
          echo get_the_title();
        } 
      }
     
      ?> - <?php echo get_bloginfo('name');?>
    </title>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
              j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
              'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-MXPR4G4H');</script>
      <!-- End Google Tag Manager -->

    <meta charset="<?php echo get_bloginfo('charset'); ?>">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<?php echo $theme_settings['theme_url'];?>/assets/sass/main.css" rel="stylesheet">
    <!-- <link href="<?php //echo $theme_settings['theme_url'];?>/assets/sass/main.rtl.css" rel="stylesheet"> -->
    <link href="<?php echo $theme_settings['theme_url'];?>/style.css?no_cash=4" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $theme_settings['theme_favicon'];?>"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined&display=swap" rel="stylesheet"  defer>
    <?php
//      if(is_checkout() ){?>
      <?php wp_head();?>
<!--    --><?php //}?>
    <style>
      .thanks_page .order_review-content #order_review_thanks .shop_table tfoot{display: block;}
      .thanks_page .order_review-content #order_review_thanks .shop_table tfoot tr.order-total{padding-top: 0;}
    </style>
  </head>
  <?php
        $has_class = (is_page(3322) || is_page(3325) || is_page(3328) || is_page(394) || is_page(386) || is_page(3333) || is_page(3404) || is_page(434) || is_page(392))? 'MD-my-account':''; 
    ?>
  <body
  class="<?php if(is_user_logged_in()){echo 'logged-in-user';}else{echo 'logged-out-user';}?> <?php echo $has_class?>"
  data-mitch-ajax-url="<?php echo admin_url('admin-ajax.php');?>"
  data-mitch-logged-in="<?php if(is_user_logged_in()){echo 'yes';}else{echo 'no';}?>"
  data-mitch-current-lang="<?php echo $theme_settings['current_lang'];?>"
  data-mitch-home-url="<?php echo home_url();?>"
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MXPR4G4H"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <?php if(is_checkout()){ ?>
    data-redeem = "<?php if(!empty(WC()->cart->get_fees())){echo 'true';} else{echo 'false';} ?>"
    <?php } ?>
  
  >
  <div id="ajax_loader" style="display:none;">
      <div class="loader"></div>
  </div>
  <?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['mitch_action']) && $_POST['mitch_action'] == 'add_subscriber'){
      if(wp_verify_nonce($_POST['add_subscriber_nonce'], 'mitch_add_subscriber_nonce')){
        $user_email     = sanitize_text_field($_POST['user_email']);
        $add_subscriber = mitch_campaign_monitor_add_subscriber($user_email);
        if($add_subscriber == 201){
          $response = 'success';
        }else{
          $response = 'error';
        }
        ?>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
          <script>
              swal({
                  title: "Newsletter",
                  text: "Subscription done successfully.",
                  icon: "success",
                  button : false ,
                  timer : 1500 ,
              });
          </script>
        <?php
        wp_redirect(home_url().'?add_subscriber='.$response);
        exit;
      }
      wp_redirect(home_url());
      exit;
    }
  }
  ?>
