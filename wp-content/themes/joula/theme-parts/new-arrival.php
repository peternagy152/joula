<div class="section_best">
  <div class="section_title">
    <h3 class="title"><?php echo $page_content['new_arrival']['title1'];?></h3>
    <p class="subtitle"><?php //echo $page_content['new_arrival']['title2'];?></p>
  </div>
  <div class="product home">
    <div class="product_container">
      <ul class="products_list">
        <?php
         $new_arrival_ids = mitch_get_new_arrival_products_ids($page_content['new_arrival']['products_limit']);
         // var_dump($new_arrival_ids);
         if(!empty($new_arrival_ids)){
           //$prod_anim_count = 1000;
           foreach($new_arrival_ids as $new_arrival_id){
             $product_data = mitch_get_short_product_data($new_arrival_id);
             include 'product-widget.php';
           }
         }
        ?>

      </ul>
    </div>
  </div>
</div>
