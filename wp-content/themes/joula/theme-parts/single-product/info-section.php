
<div class="sec_info">
<?php
      woocommerce_breadcrumb(array(
        'delimiter'   => '',
        'wrap_before' => '<ul class="breadcramb">',
        'wrap_after'  => '</ul>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => $fixed_string['product_single_breadcrumb']
      ));
?>
    <div class="top">
      <div class="first">
      <h3 class="single_title_item">
          <?php echo $single_product_data['main_data']->get_title();?>
        </h3>
      <div class="section_wishlist">
        <div class="link">
            <?php if(mitch_check_wishlist_product(get_current_user_id(), $single_product_data['main_data']->get_id())){?>
              <button onclick="remove_product_from_wishlist(<?php echo $single_product_data['main_data']->get_id();?>, '', 'yes')" class="remove-from-wishlist"></button>
            <?php }else{ ?>
              <button onclick="add_product_to_wishlist(<?php echo $single_product_data['main_data']->get_id();?>, 'yes')" class="add-to-wishlist"></button>
            <?php } ?>
        </div>
      </div>
      </div>
        
        <div class="content_description">
          <div class="description">
              <?php 
               echo $single_product_data['main_data']->get_short_description();
//              echo $single_product_data['main_data']->get_description();
              ?>
          </div>
          <span class="btnn more">More</span>
          <span class="btnn less hidee">less</span>
        </div>
       

        <p id="product_price" class="price">
          <?php echo number_format($single_product_data['main_data']->get_price());?> <?php echo $theme_settings['current_currency'];?>
          <?php
          if($single_product_data['main_data']->is_on_sale()){
            if($single_product_data['main_data']->get_type() == 'simple'){
              $product_price = $single_product_data['main_data']->get_regular_price();
            }else{
              $product_price = $single_product_data['main_data']->get_variation_regular_price('min', true);
            }
            if(!empty($product_price)){
              ?>
              <span class="discount"><?php echo number_format($product_price).' '.$theme_settings['current_currency'];?></span>
              <?php
            }
          }
          ?>
        </p>
       
    </div>
    <div class="min_middle">
      <div class="first_min_middle">
         <?php

          if($single_product_data['main_data']->get_type() == 'variable'){


            // Parent Product ID 
            $var_product_id     = $single_product_data['main_data']->get_id();
            $add_to_cart_button = '<button class="add_to_cart" id="variable_add_product_to_cart" onclick="variable_product_add_to_cart('.$var_product_id.')"> <span>'.$fixed_string['product_single_page_add_to_cart'].' </span></button>';

            // Product Attributes 
            $default_attributes = $single_product_data['main_data']->get_default_attributes();
            if(empty($default_attributes)){
              $default_attributes = array();
            }

            $variations_attr    = array();
            $variations_data    = array();

            
            $product_attributes = $single_product_data['main_data']->get_attributes();
            $product_variations = $single_product_data['main_data']->get_available_variations();

            if(!empty($product_variations)){
                  foreach($product_variations as $variation_obj){
                      $variation_price = number_format($variation_obj['display_price']) ;
                      $variation_regular_price = number_format($variation_obj['display_regular_price']) ;
                      $variation_stock = (int) filter_var($variation_obj['availability_html'], FILTER_SANITIZE_NUMBER_INT) * -1;

                      foreach($variation_obj['attributes'] as $var_attr_key => $var_attr_value){
                          $variations_attr[] = mitch_get_product_attribute_name($var_attr_value);

                          $variations_data[$var_attr_value] = array(
                              'price' => $variation_price,
                              "regular_price" => $variation_regular_price,
                              'stock' => $variation_stock
                          );
                      }
                  }
              }

            $empty_color = 0;
            if(!empty($product_attributes)){

              foreach($product_attributes as $attribute_key => $attribute_arr){

                $attribute_name = str_replace('pa_', '', $attribute_arr['name']);
                if($attribute_key == 'pa_color'){
                  ?>

                  <div class="section_color section_size">
                    <label><?php echo $fixed_string[$attribute_name];?></label>
                    <div class="colores size" id="product_size">
                      <?php
                      if(!empty($attribute_arr['options'])){
                        $count = 0;
                        foreach($attribute_arr['options'] as $option_id){
                          $active     = '';
                          $color_code = get_field('color_hex_code', 'term_'.$option_id.'');
                          $color_name = mitch_get_product_attribute_name_by_id($option_id);
                          if(isset($default_attributes['pa_color'])){
                            if($default_attributes['pa_color'] == sanitize_title($color_name)){
                              $active = 'active';
                            }
                          }


                          if(in_array($color_name, $variations_attr)){
                              $variation_data = $variations_data[str_replace(' ', '-', strtolower($color_name))];
                              if(!empty($variation_data)){
                                $variation_price = $variation_data['price'];
                                $variation_stock = $variation_data['stock'];
                                $variation_regular_price = $variation_data['regular_price'];
                              }else{
                                $variation_price = 0;
                                $variation_stock = 0;
                              }
                            ?>
                            <div class="div_block single_color variation_option <?php echo $active;?>" 
                            data-price="<?php echo $variation_price;?>"
                                 data-regular-price = "<?php echo $variation_regular_price ?>"
                            data-stock="<?php echo $variation_stock;?>"
                            data-value="<?php echo sanitize_title($color_name);?>" 
                            data-key="<?php echo 'attribute_'.$attribute_key;?>">
                                <span style="<?php if($color_name == 'White'){echo 'border: 2px solid #000;';}?>background-color: <?php echo $color_code;?>;"></span>
                                <?php 
                                if(empty($color_code)){
                                  $empty_color++;
                                  ?>
                                  <p><?php echo $color_name;?></p>
                                  <?php  
                                }
                                ?>
                            </div>
                            <?php
                            $count++;
                          }
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <?php
                }else{
                  ?>
                  <div class="select_size section_size">
                    <label><?php echo $fixed_string[$attribute_name];?></label>
                    <div class="second">
                       <div class="sizes size" id="product_size">
                        <?php
                        if(!empty($attribute_arr['options'])){
                          $count = 0;
                          foreach($attribute_arr['options'] as $option_id){
                            $active     = '';
                            $color_name = mitch_get_product_attribute_name_by_id($option_id);
                            if(isset($default_attributes[$attribute_key])){
                              if($default_attributes[$attribute_key] == sanitize_title($color_name)){
                                $active = 'active';
                              }
                            }
                            if(in_array($color_name, $variations_attr)){
                              $variation_data = $variations_data[strtolower($color_name)];
                              if(!empty($variation_data)){
                                $variation_price = $variation_data['price'];
                                $variation_stock = $variation_data['stock'];
                              }else{
                                $variation_price = 0;
                                $variation_stock = 0;
                              }
                              ?>
                              <div class="single_size variation_option <?php echo $active;?>" 
                              data-price="<?php echo $variation_price;?>" 
                              data-price-format="<?php echo number_format($variation_price );?>"
                            
                              data-value="<?php echo sanitize_title($color_name);?>" 
                              data-key="<?php echo 'attribute_'.$attribute_key;?>">
                                  <p><?php echo $color_name;?></p>
                              </div>
                              <?php
                              $count++;
                            }
                          }
                        }
                        ?>
                      </div>
                      <div class="size-guide-link">

                      <a href="#size_guide_popup">Rings Size Guide</a>
                      </div>
                    </div>
                     
                  </div>
                  <?php
                }
              }
            }
 
          }else{

              if($single_product_data['main_data']->get_stock_status() == 'outofstock') {
                  $add_to_cart_button = '<button class="add_to_cart disabled "  id="simple_add_product_to_cart"><span> Out Of Stock </span></button>';
              }else{
                  $add_to_cart_button = '<button class="add_to_cart " id="simple_add_product_to_cart"><span> Add To Cart </span></button>';

              }
            ?>
            <input type="hidden" name="product_id" class="single_size active" value="<?php echo $single_product_data['main_data']->get_id();?>" data-product-id="<?php echo $single_product_data['main_data']->get_id();?>">
            <?php
          }
            // var_dump($single_product_data['product_childs']);
            // var_dump($product_attributes);
            if(empty($single_product_data['product_childs']) && empty($product_attributes)){
              ?>
              <style>
                .single_page .section_item .content .sec_info .min_middle .section_qty{
                  border-top: unset;
                  margin-top: 0px;
                  padding-top: 0px;
                }
              </style>
              <?php 
            }
          ?>
          <!-- <a href="#size_guide_popup" class="link_size js-popup-opener">Size Guide</a> -->
      </div>

      <!-- Stock Quantity To Lock Add To Cart  -->
      <?php
      if($single_product_data['main_data']->get_stock_quantity() > 0 || $single_product_data['main_data']->get_stock_status() == 'instock'){
        echo $add_to_cart_button;
      }elseif(($single_product_data['main_data']->get_stock_quantity() <= 0 && $single_product_data['main_data']->backorders_allowed()) || isset($single_product_data['extra_data']['backorder_product'])){
        echo '<button class="add_to_cart" id="simple_add_product_to_cart">Pre Order</button>';
      }else{
        echo '<button class="add_to_cart disabled" disabled>Out Of Stock</button>';
      }
      ?>
       <?php 
        $rating_avg = $single_product_data['main_data']->get_average_rating();
        ?>
        <div class="reviews-avg">
          <div class="first">
            <h4>Reviews</h4>
              <p class="bold">
                <?php echo mitch_remove_decimal_from_rating($rating_avg);?>
              </p>  
                <?php
                  // $rating_avg = 4.2;
                  mitch_get_reviews_stars($rating_avg);
                ?>
              
          </div>
          <div class="second">
            <a href="#review-section">
                Leave Review
            </a>
          </div>
       
        </div>
     
     
    </div>

    <?php include_once 'product-details.php';?> 
</div>
