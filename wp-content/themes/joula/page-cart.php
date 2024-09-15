<?php require_once 'header.php';?>
<?php
$items  = WC()->cart->get_cart();
if(empty($items)){
  wp_redirect(home_url());
  exit;
}
if(!empty(WC()->cart->applied_coupons)){
  $coupon_code    = WC()->cart->applied_coupons[0];
  $active         = 'active';
  $dis_form_style = 'display:block;';
  $dis_abtn_style = 'display:none;';
  $dis_rbtn_style = 'display:block;';
}else{
  $coupon_code    = '';
  $active         = '';
  $dis_form_style = '';
  $dis_abtn_style = 'display:block;';
  $dis_rbtn_style = 'display:none;';
}
// $new_order = wc_get_order(200);
// $new_order->calculate_totals();
// global $wpdb;
// $wpdb->query("DELETE FROM wp_woocommerce_order_itemmeta WHERE order_item_id = 39 AND (meta_key = '_line_subtotal' OR meta_key = '_line_total');");
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="page_cart">
      <div class="cart">
          <div class="grid">
              <!-- <div class="sectio_title_cart">
                  <h2>
                    <p class="cart_subtitle">
                    <?php //echo $fixed_string['cart_sub_title'];?>
                    </p>
                    <?php //echo $fixed_string['cart_main_title'];?>
                  </h2>
              </div> -->
              <div class="sectio_title_cart">
                <div class="section_icon_cart">
                    <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    <img src="<?php echo $theme_settings['theme_url']; ?>/assets/img/new-icons/cart.png" alt="">
                </div>
                <h2>Your Cart</h2>
              </div>
              <div class="section_cart">
              <div class="table-title">
                      <p>Item</p>
                      <p>Quantity</p>
                      <p>Total</p>
                    </div>
                  <div class="cart_list">
                   
                    <?php
                      $products_ids = array();
                      if(!empty($items)){

                      foreach($items as $item => $values){
                      $products_ids[]    = $values['product_id'];
                      $cart_product_data = mitch_get_short_product_data($values['product_id']);
                     // var_dump($cart_product_data);
                      $item_product_id   = $values['product_id'];
                      if(!empty($values['variation_id'])){
                        $item_product_id = $values['variation_id'];
                      }
                    ?>
                      <div id="cart_page_<?php echo $item;?>" class="single_item">
                          <div class="sec_item size">
                              <div class="img">
                                  <img height="100px" src="<?php echo $cart_product_data['product_image'];?>" alt="<?php echo $cart_product_data['product_title'];?>">
                              </div>
                              <div class="info">
                                  <div class="text">
                                      <a class="title_link" href="<?php echo $cart_product_data['product_url'];?>"><h4><?php echo $cart_product_data['product_title'];?></h4></a>
                                      <?php
                                      if(!empty($values['custom_cart_data'])){
                                        ?>
                                        <ul>
                                        <?php
                                        foreach($values['custom_cart_data']['attributes_vals'] as $attr_val){
                                          ?>
                                          <li><?php echo mitch_get_product_attribute_name($attr_val);?></li>
                                          <?php
                                        }
                                        ?>
                                        </ul>
                                      <?php }elseif(!empty($values['variation'])){
                                        ?>
                                        <ul>
                                        <?php
                                        $remove = "attribute_pa_";
                                        $terms = get_terms([
                                          'taxonomy' => 'pa_color',
                                          'hide_empty' => false,
                                      ]);
                                         //var_dump($terms);
                                        
                                        foreach($values['variation'] as $key => $value){
                                          $attribute_name = str_replace($remove , '' , $key);
                                          $Current_color = str_replace(' ', '', $value);
                                          $Current_color = str_replace('-' , '' ,$Current_color); 


                                         // $Variation_line = $attribute_name . " : " . $value ;
                                          ?>
                                          <?php if($attribute_name == 'color'){ ?>
                                            <?php
                                               $color_hex_id = 0;
                                               foreach($terms as $one_term){
                                                $Loop_color =  str_replace(' ', '', $one_term->name);
                                                $Loop_color = str_replace('-' , '' , $Loop_color);
                                              
                                                if(strtolower($Loop_color)  == strtolower($Current_color)){
                                                  
                                                   //var_dump($Current_color);
                                                  $color_hex_id = $one_term->term_id ; 
                                                  break;
                                                }
                                               }
                                              ?>
                                          <li> Color: <span style="background-color:<?php echo get_field('color_hex_code', 'term_'.$color_hex_id.''); ?>"></span></li>
                                          <?php } else { ?>
                                            <li> <?php echo $attribute_name ?> : <?php echo ucfirst($value);?></li>
                                            <?php } ?>
                                            
                                         
                                          <?php
                                        }
                                        ?>
                                        </ul>
                                      <?php }?>
                                      <div class="price">
                                      <p>
                                        <?php
                                        echo number_format($values['data']->price ); ?>
                                        <?php echo $theme_settings['current_currency'];?>
                                      </p>
                                      <?php if($cart_product_data['product_price'] != $values['data'] -> get_regular_price() ){ ?>
                                      <p class="sale_price">
                                        <?php
                                          echo number_format($values['data'] -> get_regular_price());
                                        ?>
                                        <?php echo $theme_settings['current_currency'];?>
                                      </p>
                                      <?php  } ?>
                                      </div>
                                     
                                  </div>
                                  
                              </div>
                          </div>
                          <div class="section_count size">
                                <!-- <div class="qib-container">
                                  <button type="button" class="minus qib-button disabled">-</button>
                                  <div class="quantity buttons_added">
                                        <input type="number" id="quantity_63a9749e6e129" class="input-text qty text" step="1" min="1" max="2" name="quantity" value="1" title="الكمية" size="4" placeholder="" inputmode="numeric">
                                  </div>
                                  <button type="button" class="plus qib-button">+</button>
                              </div> -->
                                  <select class="number_count" name="product_quantity" id="number_<?php  echo $item;?>" onchange="update_cart_items('<?php echo $item;?>', 'cart_page', <?php echo get_post_meta($item_product_id, '_stock', true);?>);">
                              <?php
                              $quantity_numbers = array('1', '2', '3', '4');
                              foreach($quantity_numbers as $quantity_number){
                                if($quantity_number == $values['quantity']){
                                  $selected = 'selected';
                                }else{
                                  $selected = '';
                                }
                                echo '<option value="'.$quantity_number.'" '.$selected.'>'.$quantity_number.'</option>';
                             }
                              ?>
                            </select>
                          </div>
                          <div class="last size">
                            <p class="total_price">
                              <span id="line_subtotal_<?php echo $item;?>"><?php echo number_format($values['line_subtotal']);?></span>
                              <?php echo $theme_settings['current_currency'];?>
                            </p>
                            <a class="remove_page_cart" href="javascript:void(0);" onclick="cart_remove_item('<?php echo $item;?>', '');">Remove</a>

                          </div>
                        
                      </div>
                    <?php
                  } } 
                   ?>
                  </div>
                  <div class="cart_action">
                      <div class="left">
                        <div class="coupon_cart">
                            <h4 class="open-coupon ">Do you have a promocode?</h4>
                            <div class="discount-form" style="<?php echo $dis_form_style;?>">
                                <button class="close-coupon"><i class="material-icons">close</i></button>
                                <div class="coupon">
                                  <label for="coupon_code">Enter Promocode</label>
                                  <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="<?php echo $coupon_code;?>" placeholder="<?php echo 'Code';?>" />
                                  <button style="<?php echo $dis_abtn_style;?>" id="apply_coupon" type="submit" class="button btn">
                                    <?php echo 'Apply';?>

                                  </button>
                                  <button style="<?php echo $dis_rbtn_style;?>" id="remove_coupon" type="submit" class="button btn">
                                    <?php echo 'Remove Coupon';?>

                                  </button>
                                  <input type="hidden" name="lang" id="lang" value="">
                                </div>
                                <div class="message-container">
                                <p  id = "message-success" class="message success">The promo code is applied successfully</p>
                                <p   id = "message-fail" class="message error ">The Promo Code You Entered is no longer valid </p>
                                </div>
                               
                            </div>
                        </div>
                      </div>
                      <div class="right">
                        <div class="total_price">
                          <p>Total</p>
                          <div class="sec_price">
                            <span class="cart_total" id="cart_total">
                              <?php echo number_format(WC()->cart->cart_contents_total);?> 
                              <?php echo $theme_settings['current_currency'];?>
                            </span>
                            <!-- <span id="cart_total" class="cart_total discount"><?php //echo WC()->cart->cart_contents_total;?> <?php //echo $theme_settings['current_currency'];?></span>  -->
                          </div>

                        </div>
                        <a href="<?php echo home_url('checkout');?>">
                          <button type="button">Checkout</button>
                        </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <?php
      shuffle($products_ids);
      $product_id        = $products_ids[0];
      // // mitch_test_vars(array($product_id));
      // $new_related_title = $fixed_string['cart_related_products_title'];
      // include_once 'theme-parts/related-products.php';
      ?>
  </div>
  <!--end page-->
</div>
<!--  --------------------------------- You May Also Like Section  ---------------------------------  -->
<?php 
// Get Id of First Prodcut In Cart 
$first_Product_In_Cart_ID = 0 ;
foreach( WC()->cart->get_cart() as $cart_item ){
  $first_Product_In_Cart_ID = $cart_item['product_id'];
  break;
}

$single_product_data = mitch_get_product_data($first_Product_In_Cart_ID);
mitch_validate_single_product($single_product_data['main_data']);
 $product_categories_ids = $single_product_data['main_data']->get_category_ids();
 shuffle($product_categories_ids);
 $first_product_category  = $product_categories_ids[0];
 if(isset($product_categories_ids[1])){$second_product_category = $product_categories_ids[1] ; }else{$second_product_category = 0 ; } ;
?>
    <?php //include_once 'theme-parts/single-product/might-products.php';?>
    <?php include_once 'theme-parts/related-products.php';?>
<?php require_once 'footer.php';?>
