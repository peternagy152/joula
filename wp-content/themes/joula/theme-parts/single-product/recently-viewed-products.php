<?php
//if(is_user_logged_in()){
  $recently_viewed_products_ids = mitch_get_recently_viewed_products_ids();
  // var_dump($recently_viewed_products_ids);
  if(!empty($recently_viewed_products_ids)){
    ?>
    <div class="product recently">
        <div class="grid">
            <div class="section_title">
              <h2><?php echo $fixed_string['product_recently_section_title'];?></h2>
              <p>You have viewed these items before</p>
            </div>
            <div class="product_container">
                <ul class="products_list edit">
                <?php
                $count         = 0;
                $count_same_id = 0;
                foreach($recently_viewed_products_ids as $rv_product){
                  if($rv_product != get_the_ID() && $count < 4){
                    $product_data = mitch_get_short_product_data($rv_product); //->product_id
                    // include 'product-widget.php';
                    include get_template_directory().'/theme-parts/product-widget.php';
                  }else{
                    $count_same_id++;
                  }
                  $count++;
                }
                // var_dump($count);
                // var_dump($count_same_id);
                if($count == 1 && $count_same_id == 1){
                  ?>
                  <style>.product.recently{display:none;}</style>
                  <?php 
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
  }
//}
?>
