<?php
require_once '../wp-content/themes/joula/header.php';
mitch_validate_logged_in();

//$user_points_info = MD_get_user_points_info($current_user->ID);
//$points_settings  = get_field('points_settings' , "options");
// $currency_to_points = $points_settings['groups'][$user_points_info->level_number]['currency_to_points'];
 
$terms = get_terms(array(
    'taxonomy' => 'cancelling_reasons',
    'hide_empty' => false,
));
global $wpdb ;
//if(isset($_GET['order_id']))
//{
//    $order_id  = intval($_GET['order_id']);
//    $order_stats = $wpdb->get_row("Select * from md_wc_order_stats where order_id = '$order_id' ;");
//    if($order_stats->customer_id != get_current_user_id()){
//        wp_redirect(home_url('myaccount/orders-list.php'));
//      exit;
//    }
//    $order_obj = wc_get_order($order_id);
//} else {
//    wp_redirect(home_url('myaccount/orders-list.php'));
//}
$order_obj = wc_get_order($_GET['order_id']);
$order_id = $_GET['order_id'];
if(empty($order_obj)){

    wp_redirect(home_url('myaccount/orders-list.php'));
}
else {

?>
<div id="page" class="site">
<?php require_once '../wp-content/themes/joula/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">

            <div class="page_content">
                <div class="section_nav">
                    <div class="section_title">
                    <span class="silver"> Silver </span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="order-details">
                        <ul class="MD-breadcramb">
                        <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $lang) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $lang) ?></li>
                            <li><?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $lang) ?></li>
                        </ul>
                        <h1 class="dashboard-title"> <a href="<?php echo home_url('myaccount/orders-list.php');?>"> <i class="material-icons">chevron_left</i></a> ORDER #<?php echo $order_id?></h1>
                        <div class="track-order section">
                            <div class="top">
                                <ul>
                                    <li class='status'><?php echo Myaccount_translation('overview_orders_return_table_titles_status' , $lang) ?>:<span class="<?php echo $order_obj->get_status(); ?>"> <?php echo $order_obj->get_status() ?></span></li>
                                    <li><?php echo Myaccount_translation('overview_orders_return_table_titles_date' , $lang) ?>: <span> <?php echo $order_obj->get_date_created()->date("F j, Y"); ?></span></li>
                                    <li><?php echo Myaccount_translation('Orders_items' , $lang) ?>:<span> <?php echo  $order_obj->get_item_count(); ?></span></li>
                                    <?php
                                        if($order_obj->get_payment_method() == 'wallet_payment' ){
                                        $full_payment = true;
                                        }
                                        if( $order_obj->get_total_fees()  < 0 ){
                                        $partial_payment = true;
                                        }
                                    ?>
                                    
                                </ul>
                            </div>
                            <div class="bottom">
                                <?php if($order_obj->get_status() != 'cancelled' &&  $order_obj->get_status() != 'failed'){ ?>
                                <div class="track-bar">
                                    <div class="order_setup">
                                        <div class="step one done">
                                            <div class="icon">
                                                <i class="material-icons">done</i>
                                            </div>
                                            <div class="text">
                                                <h4><?php echo Myaccount_translation('Orders_Order_placed' , $lang) ?></h4>

                                            </div>
                                        </div>
                                        <div class="step two <?php if($order_obj->get_status() != 'cancelled') echo "done" ;?>">
                                            <div class="icon">
                                                <i class="material-icons">done</i>
                                            </div>
                                            <div class="text">
                                                <h4><?php echo Myaccount_translation('Orders_order_preparing' , $lang) ?></h4>

                                            </div>
                                        </div>
                                        <div class="step three 
                                        <?php if($order_obj->get_status() == 'completed' ) {
                                            echo 'done' ;
                                        }
                                        else if($order_obj->get_status() == 'ready-to-ship'){
                                            echo 'done' ;
                                        }else if($order_obj->get_status() == 'shipped'){
                                            echo 'done' ;
                                        }

                                        ?> ">
                                            <div class="icon">
                                                <i class="material-icons">done</i>
                                            </div>
                                            <div class="text">
                                                <h4> <?php echo Myaccount_translation('Orders_ready_to_ship' , $lang) ?> </h4>

                                            </div>
                                        </div>
                                        <div class="step four  <?php if($order_obj->get_status() == 'completed' ) {
                                            echo 'done' ;
                                        } else if($order_obj->get_status() == 'shipped'){
                                            echo 'done' ;
                                        }
                                        ?>  ">
                                            <div class="icon">
                                                <i class="material-icons">done</i>
                                            </div>
                                            <div class="text">
                                                <h4><?php echo Myaccount_translation('Orders_order_shipped' , $lang) ?> </h4>

                                            </div>
                                        </div>
                                        <div class="step five <?php if($order_obj->get_status() == 'completed' ) echo "done"; ?>">
                                            <div class="icon">
                                                <i class="material-icons">done</i>
                                            </div>
                                            <div class="text">
                                                <h4><?php echo Myaccount_translation('Orders_order_delivery' , $lang) ?></h4>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php }  ?>
                            </div>
                        </div>
                        <div class="items-list section">

                            <?php  foreach($order_obj->get_items() as $key => $values){  ?>
                                <?php   $order_item_data = mitch_get_short_product_data($values['product_id']); ?>
                            <div class="single-item">
                                <div class="image">
                                    <a href=""><img
                                            src="<?php echo $order_item_data['product_image'];?>"
                                            alt="<?php echo $order_item_data['product_title'];?>"></a>
                                </div>
                                <div class="details">
                                    <h3 class="title"><?php echo $order_item_data['product_title'];?></h3>
                                    <ul class="variations">
                                        <?php  
                                        $product    = $values->get_product();
                                        if( $product->is_type('variation') ){
                                            $variation_attributes = $product->get_variation_attributes();

                                            Call_GLobal_Variables_For_Cart();
                                            global $color_hex_data;
                                            //var_dump($color_hex_data);

                                            foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                                $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                                $attribute_name = wc_attribute_label( $taxonomy, $product );
                                                if( taxonomy_exists($taxonomy) ) {
                                                    $attribute_value = get_term_by( 'slug', $term_slug, $taxonomy )->name;
                                                } else {
                                                    $attribute_value = $term_slug; 
                                                }

                                        ?>

                                      <?php  if($attribute_name == 'Color'){ ?>
                                        <?php
                                             $Current_color = str_replace(' ', '', $attribute_value);
                                             $Current_color = str_replace('-' , '' ,$Current_color); 
                                            // var_dump($Current_color);
                                            
                                            ?>
                                        <li class="color">Color: <span style="background:<?php echo get_field('color_hex_code','term_'.$color_hex_data[strtolower($Current_color)].'') ; ?>;"></span></li>
                                        <?php } else { ?>
                                            <li > <?php echo $attribute_name . " : " ?> <span><?php echo $attribute_value ;?></span></li>
                                            <?php } ?>
                                        <?php }  ?>
                                        <?php } ?>
                                    </ul>
                                    <h4 class="quantity">x<?php echo  $values['quantity'] ; ?></h4>
                                    <div class="prices">
                                        <div class="single-price">
                                            <p><?php echo 'EGP ' . number_format($values['line_total'] / $values['quantity']);?></p>
                                           <?php  $regular_price = $product-> get_regular_price(); ?>
                    
<!--                                            <p class="sale">--><?php // echo $theme_settings['current_currency'] .' '.  number_format( $regular_price) ?><!-- </p>-->
                                        </div>
                                        <div class="total-price">
                                            <p><?php echo $theme_settings['current_currency'] .' '.  number_format($values['line_total']) ;?> </p>
<!--                                            <p class="sale">--><?php // echo $theme_settings['current_currency'] .' '.  number_format( $regular_price) ?><!-- </p>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }  ?>
                        </div>
                        <div class="shipping-info section">
                            <h3  class="section-title"> <?php echo Myaccount_translation('Orders_shipping_info' , $lang) ?> </h3>
                            <div class="details">
                                <p class="MD-row"> <?php echo $order_obj->get_billing_first_name();?> <?php echo $order_obj->get_billing_last_name();?> </p>
                                <div class="MD-row half">
                                    <label> <?php echo Myaccount_translation('shipping_street' , $lang) ?></label>
                                    <span><?php echo $order_obj->get_billing_address_1();?></span>
                                </div>
                                <div class="MD-row small">
                                    <label><?php echo Myaccount_translation('shipping_floor' , $lang) ?></label>
                                    <span> <?php echo $order_obj->get_meta('_billing_building')  ; ?></span>
                                </div>
                                <div class="MD-row small">
                                    <label><?php echo Myaccount_translation('shipping_apartment' , $lang) ?></label>
                                    <span> <?php echo  $order_obj->get_meta('_billing_building_2') ;?> </span>
                                </div>

                            </div>
                        </div>
                        <div class="payment-method section">
                            <h3 class="section-title"> <?php echo Myaccount_translation('Orders_payment_method' , $lang) ?> </h3>
                            <div class="MD-row">
                                <label> <?php echo $order_obj->get_payment_method_title() ; ?></label>
                            </div>
                        </div>

                        <div class="final-price section">
                            <div class="subtotal MD-row">
                                <p class="title"><?php echo Myaccount_translation('Order_subtotal' , $lang) ?></p>
                                <p class="price"><?php echo  $theme_settings['current_currency'] .' '. number_format($order_obj->get_subtotal());?></p>
                            </div>
                            <div class="shipping MD-row">
                                <p class="title"><?php echo Myaccount_translation('Order_shipping' , $lang) ?></p>
                                <p class="price"><?php echo  $theme_settings['current_currency'] .' '. number_format($order_obj->get_shipping_total());?></p>
                            </div>
                            <?php if($order_obj->get_total_fees() < 0){ ?>
                                <div class="discount MD-row">
                                <p class="title"><?php echo Myaccount_translation('Order_wallet_redeem' , $lang) ?> </p>
                                <p class="price"><?php echo  $theme_settings['current_currency'] .' '. number_format($order_obj->get_total_fees());?></p>
                            </div>
                           <?php  } ?>
                            <?php foreach( $order_obj->get_coupon_codes() as $coupon_code ) { ?>
                                <?php   $coupon = new WC_Coupon($coupon_code); ?>
                            <div class="coupon MD-row">
                                <p class="title">Coupon</p>
                                <p class="price"><?php echo  $theme_settings['current_currency'] .' '. number_format( -$coupon->get_amount());?></p>
                            </div>
                            <?php }  ?>
                            <div class="total MD-row">
                                <p class="title"><?php echo Myaccount_translation('Order_total' , $lang) ?></p>
                                <p class="price"><?php echo  $theme_settings['current_currency'] .' '. number_format($order_obj->get_total());?></p>
                            </div>
                        </div>

                        <div class="buttons section">
                        <?php if($order_obj->get_status() == 'processing' || $order_obj->get_status() == 'ready' ) { ?>
                            <a href="#cancel-order" data-order = "<?php echo $order_id ; ?>" class="cancel-order MD-btn-white js-MD-popup-opener"><?php echo Myaccount_translation('Order_cancel' , $lang) ?></a>
                            <?php }  ?>
                            <?php if($order_obj->get_status() == 'completed'  || $order_obj->get_status() == 'shipped' ) { ?>
                            <a data-order="<?php echo $order_id ;  ?>" href="" class="order-again MD-btn js-MD-popup-opener"><?php echo Myaccount_translation('Order_again' , $lang) ?></a>
                            <?php 
                            $order_date = $order_obj->get_date_created();
                            $today = new DateTime();
                            $order_created_date = new DateTime($order_date);
                            $interval = $order_created_date->diff($today); 
                            if($interval->days < 14){
                                ?>
                            <a href="<?php echo home_url('myaccount/return-products.php?order_id=' . $order_id );?>" class="return-product MD-btn-white js-MD-popup-opener"><?php echo Myaccount_translation('Order_return_request' , $lang) ?></a>
                            <?php }  ?>
                            <?php }  ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end page-->
    <!-- <div id="overlay" class="overlay"></div> -->

</div>

<?php require_once '../wp-content/themes/joula/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>


<?php }  ?>