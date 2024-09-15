<?php
/*if(isset($args)){
  $product_data = $args;
}*/
if(empty($product_data)){
  global $product_data;
}
if(!isset($theme_settings)){
  global $theme_settings;
}
// var_dump($product_data);
$occasions_ids  = wp_get_post_terms($product_id, 'occasions', array('fields' => 'ids'));
$forwho_ids     = wp_get_post_terms($product_id, 'forwho', array('fields' => 'ids'));

?>
<div id="product_<?php echo $product_data['product_id'];?>_block" class="product_widget">
  <?php if(mitch_check_wishlist_product(get_current_user_id(), $product_data['product_id'])){ ?>
    <span class="fav_btn favourite" onclick="remove_product_from_wishlist(<?php echo $product_data['product_id'];?>, '<?php echo $wishlist_remove;?>');"></span>
  <?php }else{ ?>
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(<?php echo $product_data['product_id'];?>);"></span>
  <?php } ?>
  <?php
      /*$new_arrival_ids = mitch_get_new_arrival_products_ids($page_content['new_arrival']['products_limit']);
      if(!empty($new_arrival_ids)){*/ ?>
      <span class="label new">new</span>
  <?php /*}*/
  ?>
    <a class="product_widget_box" href="<?php echo $product_data['product_url'];?>">
        <div class="img <?php echo($product_data['product_flip_image'])? 'has-flip':'' ?>">
          <img class="original" src="<?php echo $product_data['product_image'];?>" alt="">
          <?php if(!empty($product_data['product_flip_image'])){ ?>
          <img  class="flip" src="<?php echo $product_data['product_flip_image'];?>" alt="">
          <?php }?>
        </div>   
        <div class="sec_info">
          <h3 class="title"><?php echo $product_data['product_title'];?></h3>
          <!-- <h4 class="brand"></h4> -->
          <p class="price"><?php echo number_format($product_data['product_price']);?> <?php echo $theme_settings['current_currency'];?></p>
        </div>
    </a> 
</div>
