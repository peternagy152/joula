<?php
add_action('wp_ajax_customized_product_add_to_cart', 'mitch_customized_product_add_to_cart');
add_action('wp_ajax_nopriv_customized_product_add_to_cart', 'mitch_customized_product_add_to_cart');
function mitch_customized_product_add_to_cart(){
  $added              = array();
  $parent_id          = intval($_POST['parent_id']);
  $variations_ids     = (array)$_POST['variations_ids'];
  $visit_type         = sanitize_text_field($_POST['visit_type']);
  $visit_branch       = sanitize_text_field($_POST['visit_branch']);
  $visit_home         = sanitize_text_field($_POST['visit_home']);
  $custom_cart_data   = array(
    'custom_cart_data' => array(
      'attributes_keys' => (array)$_POST['attributes_keys'],
      'attributes_vals' => (array)$_POST['attributes_vals'],
      'variations_ids'  => $variations_ids,
      'visit_type'      => $visit_type,
      'visit_branch'    => $visit_branch,
      'visit_home'      => $visit_home
    )
  );
  // mitch_test_vars(array($visit_type, $visit_branch, $visit_home));
  // exit;
  // $product_attributes = array_keys(get_post_meta($parent_id, '_product_attributes', true));
  if(!empty($variations_ids)){
    //$i = 0;
    $total_price = 0;
    foreach($variations_ids as $variation_id){
      $total_price = $total_price + (float)get_post_meta($variation_id, '_price', true);
      // $product_attributes = wc_get_product_variation_attributes($variation_id);
      // $variation_attributes = array();
      // if(!empty($product_attributes)){
      //   foreach($product_attributes as $attribute_key){
      //     if($attribute_key == $attributes_keys[$i]){
      //       $variation_attributes['attribute_'.$attribute_key] = $attributes_vals[$i];
      //     }else{
      //       $variation_attributes['attribute_'.$attribute_key] = 'none';
      //     }
      //   }
      // }
      // echo '<pre>';
      // var_dump($variation_attributes);
      // echo '</pre>';
      //if(!empty($variation_attributes)){
      //  $added[] = WC()->cart->add_to_cart($parent_id, 1, $variation_id, wc_get_product_variation_attributes($variation_id));//14, 1,$variation_attributes
      //}
      //$i++;
    }
  }

  $custom_cart_data['custom_cart_data']['custom_total'] = $total_price;
  $cart_item_key = WC()->cart->add_to_cart($parent_id, 1, $variation_id, wc_get_product_variation_attributes($variation_id), $custom_cart_data); //
  WC()->cart->calculate_totals();

  if($cart_item_key){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content(),
      'redirect_to'  => home_url('cart'),
      'msg'          => 'Added To Cart Successfully.',
    );
  }else{
    $response = array(
      'status' => 'error',
      'msg'    => wc_print_notices(),
    );
  }
  // var_dump($response);
  // exit;
  echo json_encode($response);
  wp_die();
}

add_action('woocommerce_before_calculate_totals', 'mitch_recalculate_cart_item_price');
function mitch_recalculate_cart_item_price($cart_object){
	foreach($cart_object->get_cart() as $hash => $values){
    if(!empty($values['custom_cart_data'])){
      $values['data']->set_price($values['custom_cart_data']['custom_total']);
    }
	}
}

add_action('wp_ajax_simple_product_add_to_cart', 'mitch_simple_product_add_to_cart');
add_action('wp_ajax_nopriv_simple_product_add_to_cart', 'mitch_simple_product_add_to_cart');
function mitch_simple_product_add_to_cart(){
  $product_id      = intval($_POST['product_id']);
  $quantity_number = intval($_POST['quantity_number']);
  if(empty($quantity_number)){
    $quantity_number = 1;
  }
  // echo '<pre>';
  // var_dump($product_id);
  // var_dump($quantity_number);
  // var_dump($added_to_cart);
  // echo '</pre>';
  // exit;
  $backorders = get_post_meta($product_id, '_backorders', true);
  if($backorders == 'yes'){
    setcookie('backorder_in_cart', 'yes', time() + (86400 * 30), "/"); // 86400 = 1 day
  }
  $msg             = '';
  $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number);
  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content(),
      'msg'          => 'Added To Cart Successfully.',
    );
  }else{
    $errors = WC()->session->get('wc_notices', array())['error'];
    $count  = count($errors);
    if(isset($errors) && !empty($errors)){
      foreach($errors as $key => $error_data){
        $msg .= $error_data['notice'];
        if($count > 1){
          $msg = $msg.', ';
        }
      }
    }
    $response = array(
      'status'  => 'error',
      'code'    => 401,
      'msg'     => $msg,
    );
    wc_clear_notices();
  }
  // WC()->cart->set_shipping_total(50);
  // WC()->cart->calculate_totals();
  // WC()->cart->calculate_shipping();
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_get_availablility_variable_product', 'mitch_get_availablility_variable_product');
add_action('wp_ajax_nopriv_get_availablility_variable_product', 'mitch_get_availablility_variable_product');
function mitch_get_availablility_variable_product(){
  $attributes      = array();
  $quantity      = array();
  $variation_id    = 0;
  $product_id      = intval($_POST['product_id']);
  $selected_items  = $_POST['selected_items'];
  // $quantity_number = intval($_POST['quantity_number']);
  // var_dump($quantity_number);
  // exit;
  $product_obj     = wc_get_product($product_id);
  if(!empty($selected_items)){
    foreach($selected_items as $key => $value){
      foreach($value as $arr_k => $arr_v){
        $attributes[$arr_k] = urldecode($arr_v);
      }
    }
  }
  if(!empty($product_obj->get_available_variations())){
    foreach($product_obj->get_available_variations() as $variation_obj){
      if($variation_obj['attributes'] == $attributes){
        $variation_id = $variation_obj['variation_id'];
      }
    }
  }
  if(!empty($variation_id)){
    $variation = new WC_Product_Variation($variation_id);
    $quantity[] = $variation->get_stock_quantity();
    $response = array(
      'status'       => 'success',
      'quantity'   => array_sum($quantity),
      'price'   => $variation->get_price().' EGP',
      'msg'          => 'Added To Cart Successfully.'
    );
  }
  else{
    $response = array(
      'status' => 'error',
      'msg'    => wc_print_notices()
    );
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_variable_product_add_to_cart', 'mitch_variable_product_add_to_cart');
add_action('wp_ajax_nopriv_variable_product_add_to_cart', 'mitch_variable_product_add_to_cart');
function mitch_variable_product_add_to_cart(){ 
  $attributes      = array();
  $variation_id    = 0;
  $product_id      = intval($_POST['product_id']);
  $selected_items  = $_POST['selected_items'];
  $quantity_number = intval($_POST['quantity_number']);
  if(empty($quantity_number)){
    $quantity_number = 1;
  }
  $product_obj     = wc_get_product($product_id);
  // $match_attribute = false;
  if(!empty($selected_items)){
    foreach($selected_items as $key => $value){
      foreach($value as $arr_k => $arr_v){
        $attributes[$arr_k] = urldecode($arr_v);
      }
    }
  }
  if(!empty($product_obj->get_available_variations())){
    foreach($product_obj->get_available_variations() as $variation_obj){
      if($variation_obj['attributes'] == $attributes){
        $variation_id = $variation_obj['variation_id'];
      }
    }
  }
  $error_msg = '';
  if(!empty($variation_id)){
    $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number, $variation_id, wc_get_product_variation_attributes($variation_id));
  }else{
    $error_msg = 'Sorry, Your selected attributes not match!';
  }

  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content(),
      'msg'          => 'Added To Cart Successfully.'
    );
  }else{
    if(!empty($error_msg)){
      $response = array(
        'status' => 'error',
        'msg'    => $error_msg
      );
    }else{
      $response = array(
        'status' => 'error',
        'msg'    => wc_print_notices()
      );
    }
    
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_cart_remove_item', 'mitch_cart_remove_item');
add_action('wp_ajax_nopriv_cart_remove_item', 'mitch_cart_remove_item');
function mitch_cart_remove_item(){
  $product_id = intval($_POST['product_id']);
  if(!empty($product_id)){
    foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
      if($cart_item['product_id'] == $product_id){
        WC()->cart->remove_cart_item($cart_item_key);
      }
    }
  }else{
    WC()->cart->remove_cart_item(sanitize_text_field($_POST['cart_item_key']));
  }
  echo json_encode(array(
    'success'      => true,
    'cart_count'   => WC()->cart->get_cart_contents_count(),
    'cart_total'   => 'EGP ' . number_format(WC()->cart->cart_contents_total),
    'cart_content' => mitch_get_cart_content() 
    )
  );
  wp_die();
}
function check_stock_allowence($product_id, $quantity_number, $reqType){
    $backorders = get_post_meta($product_id, '_backorders', true);
    $allStock = get_post_meta($product_id, '_stock', true);
    $product_manage_stock = get_post_meta( $product_id , '_manage_stock' , true );
    $product_type = get_post_type( $product_id );
    $backorder_limit = 0;
    $cart_item_quantity=0;

    if($backorders == "yes"){
        setcookie('backorder_in_cart', 'yes', time() + (86400 * 30), "/"); // 86400 = 1 day

        if($product_type == "product_variation"){
            $backorder_limit = get_post_meta($product_id, '_backorder_limit', true) * -1;
        }else{
            $backorder_limit = get_post_meta($product_id, 'product_data_single_product_backorder_limit', true) * -1;
        }

        $allStock = $allStock + $backorder_limit;
    }

    if($reqType == "add"){
        foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
            if($cart_item['variation_id'] == 0){
                if($cart_item['product_id'] == $product_id){
                    $cart_item_quantity += $cart_item['quantity'];
                }
            }else{
                if($cart_item['variation_id'] == $product_id){
                    $cart_item_quantity += $cart_item['quantity'];
                }
            }
        }

        $allQuantityNeeded = $cart_item_quantity + $quantity_number;

        if($product_manage_stock == "yes"){
            if($allStock < $allQuantityNeeded){
                $added_to_cart = "overlimit";
            }else{
                $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number);
            }
        }else{
            $added_to_cart = WC()->cart->add_to_cart($product_id, $quantity_number);
        }
        // echo "<pre>";var_dump($added_to_cart);echo "</pre>";exit;
        $res = [
            "msg"                 => $added_to_cart,
            "allowed_limit"       => $allStock,
            "in_cart"             => $cart_item_quantity,
            "all_needed_quantity" => $allQuantityNeeded
        ];
    }else if($reqType == "update"){
        $allQuantityNeeded = $quantity_number;
        // echo "<pre>";var_dump(WC()->cart->get_cart());echo "</pre>";
        foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
            if($cart_item['variation_id'] == 0){$cart_item_id = $cart_item['product_id'];}
            else{$cart_item_id = $cart_item['variation_id'];}
            if($cart_item_id == $product_id){
                if($product_manage_stock == "yes"){
                    if($allQuantityNeeded > $allStock){
                        // $msg = "Cannot update cart the needed quantity greater than stock {$allStock}";
                        $msg = "Apologies, you've exceeded the product limit";
                        $success = false;
                    }else{
                        WC()->cart->set_quantity($cart_item_key, $quantity_number);
                        $msg = "Updated Successfully.";
                        $success = true;
                    }
                }else{
                    WC()->cart->set_quantity($cart_item_key, $quantity_number);
                    $msg = "Updated Successfully.";
                    $success = true;
                }

                $cart_item_quantity = $cart_item['quantity'];
                $item_total = $cart_item['line_subtotal'];
                $res = [
                    "success"      => $success,
                    'item_total'   => $item_total,
                    'msg'          => $msg ,
                    'in_cart'      => $cart_item_quantity
                ];

            }
        }
    }
    return $res;
}
add_action('wp_ajax_update_cart_items', 'mitch_update_cart_items');
add_action('wp_ajax_nopriv_update_cart_items', 'mitch_update_cart_items');
add_action('wp_ajax_update_cart_items', 'mitch_update_cart_items');
add_action('wp_ajax_nopriv_update_cart_items', 'mitch_update_cart_items');
function mitch_update_cart_items(){
    $item_total      = 0;
    $post_cart_key   = sanitize_text_field($_POST['cart_item_key']);
    $quantity_number = intval($_POST['quantity_number']);

    if(!empty($quantity_number)){
        foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
            // echo "<pre>";var_dump($product_id);echo "</pre>";exit;
            if($cart_item_key == $post_cart_key){
                if($cart_item['variation_id'] == 0){$product_id = $cart_item['product_id'];}
                else{$product_id = $cart_item['variation_id'];}

                $res = check_stock_allowence($product_id,$quantity_number,"update");
            }
        }
        echo json_encode(array(
            'success'      => $res['success'],
            'msg'          => $res['msg'],
            'item_quantity' => $res['in_cart'],
            'cart_count'   => WC()->cart->get_cart_contents_count(),
            'cart_total'   => WC()->cart->cart_contents_total,
            'cart_content' => mitch_get_cart_content(),
            'item_total'   => $res['item_total']));
    }
    wp_die();
}

add_action('wp_ajax_mitch_apply_coupon', 'mitch_apply_coupon');
add_action('wp_ajax_nopriv_mitch_apply_coupon', 'mitch_apply_coupon');
function mitch_apply_coupon(){
  global $fixed_string;
  $cart_discount_div = '';
  $coupon_code       = sanitize_text_field($_POST['coupon_code']);
  $coupon_id         = wc_get_coupon_id_by_code($coupon_code);
  //$coupon_data = new WC_Coupon($coupon_code);
  if(!empty($coupon_id)){
    WC()->cart->apply_coupon($coupon_code);
    WC()->cart->calculate_totals();
    $errors = WC()->session->get('wc_notices', array())['error'];
    $count  = count($errors);
    // echo '<pre>';
    // var_dump($errors);
    // echo '</pre>';
    // exit;
    $msg  = '';
    if(isset($errors) && !empty($errors)){
      foreach($errors as $key => $error_data){
        $error_trans = $fixed_string[$error_data['notice']];
        if(!empty($error_trans)){
          $msg .= $error_trans;
        }else{
          $msg .= $error_data['notice'];
        }
        if($count > 1){
          $msg = $msg.', ';
        }
      }
      $response = array(
        'status' => 'error',
        'code'   => 401,
        'msg'    => $msg
      );
      wc_clear_notices();
    }else{
      // echo '<pre>';
      // var_dump();
      // echo '</pre>';
      if($_POST['coupon_from'] == 'checkout'){
        global $theme_settings;
        $shipping_data     = mitch_get_shipping_data()['shipping_methods'][$theme_settings['default_shipping_method']];
        $shipping_cost     = $shipping_data['cost'];
        $coupon_discount   = WC()->cart->coupon_discount_totals[sanitize_title($coupon_code)];
        $cart_discount_div = '<div class="list_pay discount">
             <p>'.$fixed_string['checkout_page_discount'].'</p>
             <p><span id="cart_discount">- '.$coupon_discount.'</span> '.$theme_settings['current_currency'].'</p>
         </div>';
      }else{
        $shipping_cost = 0;
      }
      $response = array('status' => 'success', 'cart_total' =>  number_format(WC()->cart->cart_contents_total + $shipping_cost ) . " EGP", 'cart_discount_div' => $cart_discount_div);
    }
  }else{
    $response = array('status' => 'error', 'code' => 401, 'msg' => 'Coupon code is wrong!');
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_remove_coupon', 'mitch_remove_coupon');
add_action('wp_ajax_nopriv_mitch_remove_coupon', 'mitch_remove_coupon');
function mitch_remove_coupon(){
  $coupon_code   = sanitize_text_field($_POST['coupon_code']);
  if($_POST['coupon_from'] == 'checkout'){
    global $theme_settings;
    $shipping_data = mitch_get_shipping_data()['shipping_methods'][$theme_settings['default_shipping_method']];
    $shipping_cost = $shipping_data['cost'];
  }else{
    $shipping_cost = 0;
  }
  WC()->cart->remove_coupon($coupon_code);
  WC()->cart->calculate_totals();
  $response        = array(
    'status'       => 'success',
    'cart_total'   =>  number_format(WC()->cart->cart_contents_total + $shipping_cost) . " EGP",
    'cart_count'   => WC()->cart->get_cart_contents_count(),
    'cart_content' => mitch_get_cart_content(),
  );
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_bought_together_products', 'mitch_bought_together_products');
add_action('wp_ajax_nopriv_mitch_bought_together_products', 'mitch_bought_together_products');
function mitch_bought_together_products(){
  $msg          = '';
  $form_data    = $_POST['form_data'];
  $products_ids = (array)$form_data['products_ids'];
  foreach($products_ids as $product_id){
    $added_to_cart   = WC()->cart->add_to_cart($product_id, 1);
  }
  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content(),
      'msg'          => 'اضافة المنتجات الي سلة المشتريات',
    );
  }else{
    $errors = WC()->session->get('wc_notices', array())['error'];
    $count  = count($errors);
    if(isset($errors) && !empty($errors)){
      foreach($errors as $key => $error_data){
        $msg .= $error_data['notice'];
        if($count > 1){
          $msg = $msg.', ';
        }
      }
    }
    $response = array(
      'status'  => 'error',
      'code'    => 401,
      'msg'     => $msg,
    );
    wc_clear_notices();
  }
  echo json_encode($response);
  // if(!empty($products_ids)){
  //   echo '<pre>';
  //   var_dump($products_ids);
  //   echo '</pre>';
  // }
  wp_die();
}


function mitch_get_cart_content(){
  //var_dump("Peter , Here is Get Cart Content Function !");
  global $fixed_string, $theme_settings;
  $items            = WC()->cart->get_cart();
  $cart_total       = WC()->cart->cart_contents_total;
  $cart_items_count = WC()->cart->get_cart_contents_count();
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
  if($cart_items_count == 0){
    $mini_class = 'empty_min_cart';
  }else{
    $mini_class = 'min_cart';
  }
  $cart_content = '
  <div id="mini_cart" class="'.$mini_class.'">
    <div class="top">
      <div class="cart_info">
        <div class="title_min_cart">
          <div class="section_icon_cart">
              <span id="cart_total_count">'.$cart_items_count.'</span>
              <img src="'.$theme_settings['theme_url'].'/assets/img/new-icons/cart.png" alt="">
          </div>
          <h2>Your Cart</h2>
        </div>
        <div class="info_min_cart">
          <h4>Total
            <p class="price">'.number_format(WC()->cart->cart_contents_total).'</span> '.$theme_settings['current_currency'].'</p>
            <span class="qun">'.$cart_items_count.' Item</span>
          </h4>
        </div>
      </div>
      <div class="cart_action">
        <a class="open_checkout" href="'.home_url('checkout').'">
          <button type="button">Checkout</button>
        </a>
        <a class="open_cart" href="'.home_url('cart').'">
          <button type="button">View Cart</button>
        </a>
      </div>
    </div>
    <div class="all_item">';
      if(!empty($items)){
        $count_items = 0;
        foreach($items as $item => $values){
          $products_ids[]    = $values['product_id'];
          $cart_product_data = mitch_get_short_product_data($values['product_id']);
          $order             = $cart_items_count - $count_items;
          if(!empty($values['variation_id'])){
            $product_id = $values['variation_id'];
          }else{
            $product_id = $values['product_id'];
          }
          if(get_post_meta($product_id, '_backorders', true) == 'yes' || get_post_meta($product_id, '_stock_status', true) == 'onbackorder'){
            $product_backorder = '<br>(Pre Order)';
          }else{
            $product_backorder = '';
          }
          $item_product_id   = $values['product_id'];
          if(!empty($values['variation_id'])){
            $item_product_id = $values['variation_id'];
          }
          $item_stock        = get_post_meta($item_product_id, '_stock', true);
          $cart_content     .= '
          <div id="mini_cart_'.$item.'" class="single_item" style="order: '.$order.';">
              <div class="sec_item">
                  <div class="img">
                      <img height="100" src="'.$cart_product_data['product_image'].'" alt="'.$cart_product_data['product_title'].'">
                  </div>
                  <div class="info">
                      <div class="info_top">
                        <div class="text">
                            <a href="'.$cart_product_data['product_url'].'">
                            <h4>'.$cart_product_data['product_title'].' '.$product_backorder.'</h4></a>';
                            if(!empty($values['custom_cart_data'])){
                              $cart_content .= '<ul>';
                              foreach($values['custom_cart_data']['attributes_vals'] as $attr_val){
                                $cart_content .= '<li>'.mitch_get_product_attribute_name($attr_val).'</li>';
                              }
                              $cart_content .= '</ul>';
                            }elseif(!empty($values['variation'])){
                              $cart_content .= '<ul>';

                              Call_GLobal_Variables_For_Cart();
                              global $color_hex_data;
                              $remove = "attribute_pa_";
                              foreach($values['variation'] as $key => $value){

                                $attribute_name = str_replace($remove , '' , $key);
                                $Current_color = str_replace(' ', '', $value);
                                $Current_color = str_replace('-' , '' ,$Current_color); 

                                if($attribute_name == 'color'){
                                  $cart_content .= '<li> Color : <span style = "background-color: ' .get_field('color_hex_code','term_'.$color_hex_data[$Current_color].'') . '"> </span> </li>';
                                } 
                                else{
                                  $cart_content .= '<li>'.$attribute_name. ' : ' .  ucfirst($value) .'</li>';
                                }
                              
                              }
                              $cart_content .= '</ul>';
                            }
                            $cart_content .= '
                        </div>
                        <a class="remove_min_cart href="javascript:void(0);" onclick="cart_remove_item(\''.$item.'\', \'\', \'mini_cart\');"></a>

                      </div>
                      <div class="info_bottom">
                        <div class="section_qty">
                       
                            <div class="select_arrow">
                              <select class="number_count" name="product_quantity" id="number_'.$item.'" onchange="update_cart_items(\''.$item.'\', \'mini_cart\', \''.$item_stock.'\');">';
                                $quantity_numbers = array('1', '2', '3', '4');
                                foreach($quantity_numbers as $quantity_number){
                                  if($quantity_number == $values['quantity']){
                                    $selected = 'selected';
                                  }else{
                                    $selected = '';
                                  }
                                  $cart_content .= '<option value="'.$quantity_number.'" '.$selected.'>'.$quantity_number.'</option>';
                                }
                                $cart_content .= '
                              </select>
                            </div>
                        </div>
                        <div class="price">
                        <p class="total_price"><span id="line_subtotal_'.$item.'">'.number_format($values['line_subtotal']).'</span> '.$theme_settings['current_currency'].'</p>

                        </div>

                      </div>
                  </div>
              </div>
          </div>';
          $count_items++;
        }
        //"'.$item.'", ''
      }else{
        $cart_content .= '
        <div class="section_emty">
            <img src="'.$theme_settings['theme_url'].'/assets/img/new-icons/cart.png" alt="">
            <p>There are no products added for sale</p>
            <a class="shop" href="'.home_url('shop').'">
              <button type="button">Shop Now</button>
            </a>
        </div>';
      }
      $cart_content .= '
    </div>
    <div class="bottom">
      <div class="bottom_info">
        <div class="info_min_cart">
          <h4>Total
            <p class="price">'.number_format(WC()->cart->cart_contents_total).'</span> '.$theme_settings['current_currency'].'</p>' ;
            if(WC()->cart->cart_contents_total != WC()->cart->subtotal){
              $cart_content = $cart_content . '
            <p class="price-discount">'.number_format(WC()->cart->subtotal).'</span> '.$theme_settings['current_currency'].'</p> ' ;
            }
            $cart_content = $cart_content . '
            <span class="qun">'.$cart_items_count.' Item</span>
          </h4>
        </div>
      </div>
      <a class="open_checkout" href="'.home_url('checkout').'">
        <button type="button">Checkout</button>
      </a>
  </div>
  </div>
  ';
    return $cart_content;
}

function mitch_repeat_order(){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['action'] == 'repeat_order'){
      // $new_order_id = mitch_create_order_from(intval($_POST['order_id']));
      // if($new_order_id){
      //   wp_redirect(home_url('my-account/orders-list/?order_id='.$new_order_id.''));
      //   exit;
      // }
      // var_dump($_POST);
      // exit;
      if($_POST['repeat_action'] == 'no_items'){
        WC()->cart->empty_cart();
      }
      $custom_cart_data = array();
      $r_order_obj      = wc_get_order(intval($_POST['order_id']));
      foreach($r_order_obj->get_items() as $cart_item_key => $values){
        if(!empty($values['custom_cart_data'])){
  				$items_data = $values['custom_cart_data'];
  				if(!empty($items_data['visit_type'])){
            $custom_cart_data['visit_type'] = $items_data['visit_type'];
  				}
  				if(!empty($items_data['visit_branch'])){
            $custom_cart_data['visit_branch'] = $items_data['visit_branch'];
  				}
  				if(!empty($items_data['visit_home'])){
            $custom_cart_data['visit_home'] = $items_data['visit_home'];
  				}
          if(!empty($items_data['attributes_keys'])){
            $custom_cart_data['attributes_keys'] = $items_data['attributes_keys'];
  				}
          if(!empty($items_data['attributes_vals'])){
            $custom_cart_data['attributes_vals'] = $items_data['attributes_vals'];
  				}
          $total_price = 0;
          // echo '<pre>';
          // var_dump($values);
          // echo '</pre>';
          // exit;
          if(!empty($items_data['variations_ids'])){
            foreach($items_data['variations_ids'] as $variation_id){
              $total_price = $total_price + (float)get_post_meta($variation_id, '_price', true);
            }
          }
          $custom_cart_data['custom_total'] = $total_price;
          $custom_cart_data_arr             = array('custom_cart_data' => $custom_cart_data);
          // echo '<pre>';
          // var_dump($custom_cart_data_arr);
          // echo '</pre>';
          // exit;
          $added_to_cart = WC()->cart->add_to_cart($values['product_id'], 1, $variation_id, wc_get_product_variation_attributes($variation_id), $custom_cart_data_arr);
  			}else{
          if(!empty($values['variation_id'])){
            $product_id = $values['variation_id'];
          }else{
            $product_id = $values['product_id'];
          }
          $added_to_cart   = WC()->cart->add_to_cart($product_id, $values['quantity']);
        }
      }
      if($added_to_cart){
        wp_redirect(home_url('cart'));
        exit;
      }
    }
    wp_redirect(home_url('my-account/orders-list/?order_id='.intval($_POST['order_id']).'&response=error'));
    exit;
  }
}

//update cart prices to rate price
/*add_action( 'woocommerce_before_calculate_totals', 'add_custom_item_price', 10 );
function add_custom_item_price($cart_object){
  foreach($cart_object->get_cart() as $item_values){
    ## Set the new item price in cart
    // $item_values['data']->set_price(mitch_get_product_price_after_rate($item_values['data']->price));
    @$item_values['data']->set_price($item_values['data']->price);
  }
}*/

function mitch_get_cart_content_fresh(){
  $response = array(
    'status'       => 'success',
    'cart_count'   => WC()->cart->get_cart_contents_count(),
    'cart_content' => mitch_get_cart_content(),
  );
  echo json_encode($response);
  wp_die();
}
add_action('wp_ajax_get_cart_content_fresh', 'mitch_get_cart_content_fresh');
add_action('wp_ajax_nopriv_get_cart_content_fresh', 'mitch_get_cart_content_fresh');
