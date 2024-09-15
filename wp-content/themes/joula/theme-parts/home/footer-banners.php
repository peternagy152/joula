<!-- <?php 
if(is_checkout() && !empty( is_wc_endpoint_url('order-received'))){
    $args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'orderby'        => 'rand',
    'fields'         => 'ids',
    );
    $thankyou_products_ids = get_posts($args);
   // include get_template_directory().'/theme-parts/related-products.php';
}else{

}

$page_content = get_field('footer_builder_en', 'options');
?>

<?php if( strpos(($_SERVER['REQUEST_URI']) , 'myaccount')  == false ){?>
<div class="footer_baner test">
  <div class="grid">
  <?php
  if(isset($page_content['footer_banners'])){
   // $top_icons    = $page_content['footer_banners']['top_icons'];
    $bottom_icons = $page_content['footer_banners']['bottom_icons'];
  }else{
    $top_icons    = get_field('home_page_footer_banners_top_icons', 85);
    $bottom_icons = get_field('home_page_footer_banners_bottom_icons', 85);
  }
  if(is_checkout() || is_cart() || is_front_page()){
    if(!empty($top_icons)){
      ?>
       <div class="top">
        <?php
       // foreach($top_icons as $top_icon){
          ?>
          <div class="single_top">
          <img src="<?php //echo $top_icon['icon'];?>">
            <span class="bk">

            </span>
            <h5 class="text">
              <?php //echo $top_icon['title'];?>
              <p><?php //echo $top_icon['content'];?></p>
            </h5>
          </div>
          <?php
        }
        ?>
      </div> 
      <?php
    }
  //}
  $bottom_icons =  $page_content['footer_banners']['bottom_icons'] ;
  if(!empty($bottom_icons)){
    ?>
    <div class="bottom">
      <?php
      $count = 1;
      foreach($bottom_icons as $bottom_icon){
        ?>
        <div class="single_bottom">
          <div class="text">
            <?php
            if($count == 4){
              ?>
              <p><?php echo $bottom_icon['title'];?></p>
              <span class="icon"><img src="<?php echo $bottom_icon['icon'];?>" alt=""></span>
              <?php
            }else{
              ?>
              <span class="icon"><img src="<?php echo $bottom_icon['icon'];?>" alt=""></span>
              <p><?php echo $bottom_icon['title'];?></p>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
        $count++;
      }
      ?>
    </div>
    <?php
  }
  ?>
    </div>
</div>
<?php } ?> -->

<?php 
$page_content = get_field('footer_builder_en', 'options');

if(!empty($page_content['footer_banners']['icons_repeater'])){


?>

<div class="footer-icons">
    <h2><?php echo $page_content['footer_banners']['title']; ?></h2>
    <div class="image">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.png" alt="">
    </div>

    <div class="repeater-icons">
        <?php
        if(!empty($page_content['footer_banners']['icons_repeater'])){
        foreach($page_content['footer_banners']['icons_repeater'] as $single){
        ?>
        <div class="singleIcon">
            <div class="icon">
                <img src="<?php echo $single['icon'];?>" alt="">
            </div>
            <p><?php echo $single['text'];?></p>

        </div>

        <?php 
        }
    } 
    ?>
    </div>
</div>

<?php 
}
?>