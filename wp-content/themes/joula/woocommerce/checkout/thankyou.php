<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */
defined( 'ABSPATH' ) || exit;
global $theme_settings;
require_once get_template_directory().'/includes/thankyou-actions.php';
?>
<style>
.alert {
    margin-bottom: 10px;
}
</style>
<div class="woocommerce-order">
    <?php
	if($order) :
		do_action('woocommerce_before_thankyou', $order->get_id());
		$backorder_id = get_post_meta($order->get_id(), 'backorder', true);
		if($backorder_id){
			$backorder_obj = wc_get_order($backorder_id);
		}else{
			$backorder_obj = '';
		}
		?>
    <?php if($order->has_status('failed')) : ?>
    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
        <?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
    </p>
    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
            class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
        <?php if ( is_user_logged_in() ) : ?>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
            class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
        <?php endif; ?>
    </p>

    <?php else : ?>
    <div class="thanks_page">
        <div class="left">
            <p class="title woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received title">
                <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank You', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </p>
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received subtitle">
                <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Your order has been successfully placed', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </p>
            <?php global $wpdb ;  ?>

            <div class="woocommerce-customer-details">

                <div class="first">
                    <h4>Your Info.</h4>
                    <div class="row">
                        <label for="">First Name</label>
                        <p><?php echo $order->get_billing_first_name();?></p>
                    </div>
                    <div class="row">
                        <label for="">Last Name</label>
                        <p><?php echo $order->get_billing_last_name();?></p>
                    </div>
                    <div class="row full">
                        <label for="">E-mail Address</label>
                        <p><?php echo $order->get_billing_email();?></p>
                    </div>
                    <div class="row full">
                        <label for="">Mobile Number</label>
                        <p><?php echo $order->get_billing_phone();?></p>
                    </div>
                </div>
                <div class="first">
                    <h4>Shipping Info.</h4>
                    <div>
                        <div class="row">
                            <label for="">City</label>
                            <p><?php echo $order->get_billing_state();?></p>
                        </div>
                        <div class="row">
                            <label for="">Area</label>
                            <p><?php echo $order->get_billing_city(); //echo get_post_meta($order->get_id(), '_billing_area', true);?>
                            </p>
                        </div>

                    </div>

                    <div>
                        <div class="row">
                            <label for="">Street & Building No</label>
                            <p><?php echo $order->get_billing_address_1();?></p>
                        </div>
                        <div class="row">
                            <label for="">Floor</label>
                            <p><?php echo $order->get_meta('_billing_building')  ?></p>
                        </div>

                        <div class="row">
                            <label for="">Apartment</label>
                            <p><?php echo $order->get_meta('_billing_building_2') ;?> </p>
                        </div>
                    </div>

                </div>
                <div class="first">
                    <?php
                    $order_object  =$wpdb->get_row("SELECT * FROM md_wc_orders WHERE id = '" . $order->get_id() . "';");
                    $payment_method = $order_object->payment_method ;
                    $row_payment_method = $payment_method ;
                    if($payment_method == "cod")
                    $payment_method = "Cash On Delivery";
                    ?>
                    <h4> Payment Method </h4>
                    <p> <?php echo $payment_method ?></p>
                    <?php if($row_payment_method != "cod") {?>
                    <div class="row payment">
                        <label for="">Credit / Debit Card</label>
                        <p>8766 7722 8821 1255
                            <span>
                                02/26
                            </span>
                        </p>
                    </div>
                    <?php  } ?>

                </div>
                <div class="note">
                    <p>If you have questions about your order, you can email us at info@joula.com
                        or call us at <a href="tel:012 9857 3984">012 9857 3984</a> </p>
                    <a href="<?php echo home_url('/myaccount/order-details.php?order_id='.$order->get_id());?>"
                        class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received track_order">
                        <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Order Status', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>

                </div>
            </div>
            <div class="thanks_grid congratulations">
                <div class="section_congratulations">
                    <?php
							$count_widgets = 0;
							/*$points_no     = get_post_meta($order->get_id(), '_order_earned_points_no', true);
							if(!empty($points_no)){
								$count_widgets++;
								?>
                    <div class="top">
                        <div class="text">
                            <h3>Congratulations!</h3>
                            <p>
                                You’ve earned
                                <?php echo $points_no;?>
                                rewards points for your purchase today, and these points will be credited to your
                                account immediately.
                            </p>
                        </div>
                        <div class="icon">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thank_gift_01.png"
                                alt="">
                        </div>
                    </div>
                    <?php
							}*/
							?>
                </div>
            </div>
            <?php
					if($count_widgets == 0){
						?>
            <style>
            .thanks_grid.congratulations {
                display: none;
            }
            </style>
            <?php
					}
					?>
        </div>
        <div class="order_review-content">
            <div class="box-con sticky-box">
                <div id="order_review_thanks" class="woocommerce-checkout-review-order">
                    <div class="order-title">
                        <h3>
                            <?php
									if(!empty($backorder_obj)){
										echo 'Processing Order <span> #'.$order->get_order_number().' </span><br>';
										echo 'Pre Order #'.$backorder_id;
									}else{
										echo 'Order <span> #'.$order->get_order_number().'</span>';
									}
									?>
                            <!--<span>
										<?php
										/*if(!empty($backorder_obj) || $order->get_status() == 'backorder'){
											echo 'Next Day Delivery in Cairo & 3-5 Days Outside Cairo';
										}else{
											echo 'Next Day Delivery in Cairo & 3-5 Days Outside Cairo';
										}*/
										?>
									</span>-->
                        </h3>
						<p>Next Day Delivery in Cairo & 3-5 Days Outside Cairo</p>
                        <!-- <a href="">Cash on Delivery</a> -->
                    </div>
                    <table class="shop_table woocommerce-checkout-review-order-table">
                        <tbody>
                            <tr class="cart_item">
                                <?php
									$order_items = $order->get_items();
									if(!empty($backorder_obj)){
										$backorder_items = $backorder_obj->get_items();
										$order_items     = array_merge($order_items, $backorder_items);
									}
                                    // Get ALL Colors Hexa Code 
                                    $ALL_Colors = get_terms([
                                        'taxonomy' => 'pa_color',
                                        'hide_empty' => false,
                                    ]);

									foreach($order_items as $item_id => $item){
										$product    = $item->get_product();
										$price      = $product->get_price();
										$product_id = $item->get_product_id();
										$data       = $item->get_data();    
                                        
                                        //var_dump($product);
										// $order_items_data = array_map( );
										// $custom_field = get_post_meta( $product_id, '_tmcartepo_data', true);
										// print_r($data);
										?>
                                <td class="product-name">
                                    <div class="product-thumb-name">
                                        <a href="<?php echo get_the_permalink($product_id);?>" class="cart_pic">
                                            <?php 
												$product_img = get_the_post_thumbnail_url($product_id);
												if(empty($product_img)){
													$product_img = wc_placeholder_img_src('100');
												}
												?>
                                            <img width="300" height="300" src="<?php echo $product_img;?>"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="" sizes="(max-width: 300px) 100vw, 300px"></a>
                                        <div class="product-name-container">
                                            <div class="right">
                                                <!-- Product Name -->
                                                <?php 
                                                     $product_name = $product->get_name();
                                                    if(strpos($product_name , "-") !== false){
                                                        //$index = 
                                                        $product_name = substr($product_name , 0 , strpos($product_name , "-"));
                                                    }
                                                    ?>
                                                <h3 class="product-title"><?php echo $product_name ; ?></h3>

                                                <?php 
                                                //Check if Product is Variable or Not 
                                                if( $product->is_type('variation') ){
                                                ?>
                                                <ul class = "variations">
                                                    <!-- ------- Variations HERE  ------------  -->
                                                    <?php
                                                    	$variation_attributes = $product->get_variation_attributes();
                                                            foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                                                $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                                                $attribute_name = wc_attribute_label( $taxonomy, $product );
                                                                if( taxonomy_exists($taxonomy) ) {
                                                                    $attribute_value = get_term_by( 'slug', $term_slug, $taxonomy )->name;
                                                                } else {
                                                                    $attribute_value = $term_slug; // For custom product attributes
                                                                }

                                                                ?>
                                                                
                                                                <?php 
                                                                if($attribute_name == "color"){
                                                                         $Color_Hex_ID = 0 ;
                                                                         $Current_Color =  str_replace(' ', '', $attribute_value);
                                                                         $Current_Color = str_replace('-' , '' , $Loop_color);
                                                                    foreach ($ALL_Colors as $One_Color) {  
                                                                        $Loop_color =  str_replace(' ', '', $One_Color->name);
                                                                        $Loop_color = str_replace('-' , '' , $Loop_color);
                                                                      
                                                                        if(strtolower($Loop_color)  == strtolower($attribute_value)){
                                                                            $Color_Hex_ID = $One_Color->term_id ; 
                                                                            break;
                                                                        }
                                                                          
                                                                    }
                                                                        ?>

                                                                        <li> Color: <span style="background-color:<?php echo get_field('color_hex_code', 'term_'.$Color_Hex_ID.''); ?>"></span></li>
                                                                    <?php } else {   ?>
                                                                <li> <?php echo $attribute_name ?> : <?php echo $attribute_value ?></li>
                                                                <?php } ?>
                                                                <?php 

                                                            }
                                                    
                                                    ?>

                                                </ul>
                                                <?php } // if Product Variable ?>
                                                <h4 class="quantity">
                                                X<?php echo $item->get_quantity();?>
                                                </h4>
                                                <div class="prices">
                                                    <div class="single-price">
                                                        <p><span class="woocommerce-Price-amount amount">
                                                        <?php echo number_format($price);?>
                                                                <span class="woocommerce-Price-currencySymbol"> EGP </span>
                                                            </span></p>
                                                            <?php  echo number_format($item->get_subtotal()); ?>
                                                        </p>
                                                        <?php $regular_price = $product-> get_regular_price(); ?>
                                                        <?php $Show_Sale_price = false ; ?>
                                                        <?php if($regular_price != $item->get_subtotal()) { ?>
                                                            <?php $Show_Sale_price = true ; ?>
                                                            <p class="sale"> <?php  echo number_format($regular_price) . ' EGP' ; ?> </p>
                                                         <?php } ?>
                                                       
                                                    </div>
                                                    <div class="total-price">
                                                        <p>
                                                        <?php  echo  number_format($item->get_subtotal()) . ' EGP' ; ?>
                                                        </p>
                                                        <?php if($Show_Sale_price) { ?>
                                                        <p class="sale">  <?php echo   number_format($item->get_quantity() * $regular_price ) . ' EGP' ; ?> </p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- -------------- This Is For Basma -------------------- -->
                                            <!--  Product Base Price [Sale]  -->
                                            <?php echo number_format($price);?>
                                            <!--  ------- Regular Price  -------  -->
                                            <?php
                                            $regular_price = $product-> get_regular_price();
                                            echo number_format($regular_price) ;
                                             ?>
                                            <!-- Product Quantity  -->
                                            <?php echo $item->get_quantity();?>
                                            <!--  Product Total Price [Quantity x price] -->
                                            <?php  echo number_format($item->get_subtotal()); ?>
                                            <!-- ------ Product Total Regualar Price ------ -->
                                            <?php echo number_format($item->get_quantity() * $regular_price ); ?>

                                            <!-- <div class="left">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi><?php //echo $price;?>
                                                        <span
                                                            class="woocommerce-Price-currencySymbol"><?php //echo $theme_settings['current_currency'];?></span>
                                                    </bdi>
                                                </span>
                                            </div> -->
                                            <!-- <strong class="product-quantity">×&nbsp;1</strong> -->
                                        </div>
                                    </div>
                                </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr class="order-total">
                                <th>Subtotal</th>
                                <td><?php echo number_format($order->get_subtotal()).' '.$theme_settings['current_currency'];?>
                                </td>
                        </tr>
                        
                        <tr class="order-total">
                            <th>Shipping</th>
                            <?php if($order->get_shipping_total() == 0) {?>
                                <td> Free Shipping </td>
                            <?php }else{?>
                                <td><?php echo ($order->get_shipping_total()).' '.$theme_settings['current_currency'];?></td>
                            <?php } ?>

                        </tr>
                        <?php if($order->get_total_fees() < 0){ ?>
                        <tr class="order-total">
                            <th>Wallet Redeem </th>
                            <td><?php echo ($order->get_total_fees()).' '.$theme_settings['current_currency'];?>
                            </td>
                        </tr>
                        <?php }  ?>

                      <?php foreach( $order->get_coupon_codes() as $coupon_code ) { ?>
                        <?php   $coupon = new WC_Coupon($coupon_code); ?>
                        <tr class="order-total">
                            <th>Coupon  </th>
                            <td> -<?php echo  number_format($order->get_total_discount()).' '.$theme_settings['current_currency'];?></td>
                        </tr>
                        <?php }  ?>

                        <tr class="order-total">
                            <th>Total</th>
                            <td>
                                <?php
                                            echo   number_format($order->get_total()) . ' EGP' ;
                                        ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    <?php //include_once '../../theme-parts/home/trending-products.php';?> 
    <?php// var_dump(get_template_directory()) ?>
    <?php endif; ?>
    <?php else : ?>
    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
        <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </p>
    <?php endif; ?>
</div>
<?php include_once get_template_directory().'/theme-parts/home/trending-products.php' ?>
