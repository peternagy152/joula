<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $language,$if_ar;
// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<div class="checkout-content">
	<div class="page-title">
		<h1>Checkout</h1>
		<?php if(get_field('notification_on','option')): ?>
			<p class="store-announcement" style="background-color:<?php echo get_field('notification_background_color','option') ?>;color:<?php echo get_field('notification_font_color','option') ?>;"><?php echo ($language=="en")? get_field('store_notification_en','option') : get_field('store_notification_ar','option'); ?></p>
		<?php endif; ?>
	</div>


	<!-- <div class="coupon-form-checkout">
		<span class="close-form" style="display:none">
			<i class="material-icons">close</i>
		</span>
		<?php //do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
	</div> -->

	<div class="checkout-form">

		<div class="login-top-part">

			<?php if ( !is_user_logged_in()) :?>
				<div class="title_login_in_checkout">
					<p>
						Already Have an account?
						<span>Sign in to checkout faster</span>
					</p>
					<a href="<?php echo home_url('myaccount/user-login.php')?>" class="checkout-login js-popup-opener"><?php echo(!$if_ar)? 'Sign In':'Login Now'?></a>
				</div>

			<?php endif; ?></h1>

			<?php if ( !is_user_logged_in()) :?>
				<div class="checkout-login-tabs">
					<div class="rows">
						<div class="row guest">
							<!-- <div class="icon">
								<img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/icons/users-avatar-user-profile-female.png" alt="icon">
							</div> -->
							<div class="content">
								<p>تسوق بدون تسجيل</p>
								<span>تسوق سريع</span>
							</div>
						</div>
						<div class="row login trig-signup">
							<!-- <div class="icon">
								<img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/icons/sports-and-fitness-badge-reward-medal.png" alt="icon">
							</div> -->
							<div class="content">
								<p>تسجيل حساب جديد</p>
								<!-- <span>أعملي حساب جديد
									<strong>وأكسبي 100 نقطة</strong>
								</span> -->
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<form name="checkout" method="post" class="checkout woocommerce-checkout remove_border_on_first_load" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="col2-set" id="customer_details">
					<div class="col-1">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<div class="col-2">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>
		</form>

	</div>

	<div class="order_review-content">
		<div class="box-con sticky-box">
			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<div class="order-title">
					<div class="right">
						<h3>  <div class="cart">
                <!-- <a href="<?php// echo home_url('cart');?>"> -->
                <a href="<?php echo home_url('/cart')?>" class="js-popup-opener">
                    <div class="section_icon_cart">
                    <?php //echo WC()->cart->get_total();?>
                        <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <img src="https://www.cloudhosta.com:61/wp-content/themes/joula/assets/img/new-icons/cart.png" alt="">
                    </div>
                </a>
            </div>Your Cart </h3>
						<p>
							<?php
							$instock_items   = 0;
							$backorder_items = 0;
							foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
								if(!empty($cart_item['variation_id'])){
									$product_id = $cart_item['variation_id'];
								}else{
									$product_id = $cart_item['product_id'];
								}
								if(get_post_meta($product_id, '_backorders', true) == 'yes' || get_post_meta($product_id, '_stock_status', true) == 'onbackorder'){
									$backorder_items++;
								}else{
									$instock_items++;
								}
							}
							// echo '<pre>';
							// var_dump($instock_items);
							// echo '</pre>';
							/*if($instock_items > 0 && $backorder_items > 0){
								echo 'There is a product(s) in your cart that will be delivered within 7-12 Working Days in Cairo & 7-15 Working Days Outside Cairo';
							}elseif($backorder_items > 0){ //isset($_COOKIE['backorder_in_cart']) && $_COOKIE['backorder_in_cart'] == 'yes'
								echo 'Next Day Delivery in Cairo & 3-5 Days Outside Cairo';
							}else{
								echo 'Next Day Delivery in Cairo & 3-5 Days Outside Cairo';
							}*/
							?>
						</p>
						<p class="message">Next Day Delivery in Cairo & 3-5 Days Outside Cairo</p>
					</div>
					<div class="left">
						<!-- <a href="<?php //echo wc_get_cart_url();echo($if_ar)? '' : ''; ?>" target="" class="btn">تعديل</a> -->
						<!-- <a href="#popup-min-cart" class="js-popup-opener">اعرض المنتجات</a> -->
					</div>
				</div>
				<?php
				do_action( 'woocommerce_checkout_order_review' );
				?>
			</div>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
