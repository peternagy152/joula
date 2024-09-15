<?php
$exclude_ids = array();
if(!isset($product_id)){
  $product_id = get_the_id();
}

if(isset($thankyou_products_ids)){
  $related_products_ids = $thankyou_products_ids;
}else{
  //$related_products_ids = wc_get_related_products($product_id, 4, $exclude_ids);
  if(!empty($first_product_category)){
    // $first_product_category = $single_product_data['main_data']->get_category_ids()[0];
    $first_category_obj     = get_term_by('id', $first_product_category, 'product_cat');
    $related_products_ids   = mitch_get_related_products($product_id, array($first_product_category));
  }
}

if(!empty($related_products_ids)){
  ?>
  <div class="product related <?php if(is_checkout() && !empty(is_wc_endpoint_url('order-received'))){echo 'thankyou-page';}?>">
    <div class="grid">
      <div class="section_title">
        <h2><?php if(isset($new_related_title)){echo $new_related_title;}else{echo $fixed_string['product_related_section_title'];}?></h2>
        <?php if(!empty($first_category_obj)){ ?>
        <p>See more items in <a href="<?php echo home_url('/product-category/'.$first_category_obj->slug.'');?>"><?php echo $first_category_obj->name;?></a></p>
        <?php }?>
      </div>
      <div class="product_container">
        <ul class="products_list edit">
        <?php
        foreach($related_products_ids as $r_product_id){
          $product_data = mitch_get_short_product_data($r_product_id);
          include 'product-widget.php';
        }
        ?>
        </ul>
      </div>
    </div>
  </div>
  <?php
}
?>
