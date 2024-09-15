<div class="section_best">

    <div class="product home">
        <div class="product_container">
            <ul class="products_list">
                <?php 
            $best_selling_ids = mitch_get_best_selling_products_ids(8);
            if(!empty($best_selling_ids)){
              foreach($best_selling_ids as $product_id){
                $product_data = mitch_get_short_product_data($product_id);
                include 'product-widget.php';
              }
            }
            // echo '<pre>';
            // var_dump($best_selling_ids);
            // echo '</pre>';
            ?>
                <!-- <a class="product_widget" href="">
              <div class="product_widget_box">
                <div class="img">
                    <img src="<?php// echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
                  </div>   
                  <div class="sec_info">
                    <h3 class="title">New York Times Custom</h3>
                    <h4 class="brand">Birthday Book</h4>
                    <p class="price">EGP 1100</p>
                  </div>
              </div>
            </a>  -->
            </ul>
        </div>
    </div>
</div>