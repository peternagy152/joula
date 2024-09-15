<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
global $language;
/** @global WC_Checkout $checkout */
global $theme_settings;
$language = $theme_settings['current_lang'];
?>
<div class="woocommerce-billing-fields">
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper<?php echo(is_user_logged_in())? ' user-logged-in' : ''; ?>">
		<div class="billing-fileds-container">
			<?php 
			if(empty(is_user_logged_in())){
				?>
				<h2>Checkout As A Guest</h2>
				<?php
			}
			?>
			<h3><?php echo($language == 'en')? 'Your Info.' : 'بياناتي'; ?></h3>
				<?php if(is_user_logged_in()): global $current_user; wp_get_current_user(); ?>
					<div class="user-info" style="display: none;">
						<p class="user-name"><small><?php echo($language == 'en')? 'Full name' : 'الإسم'; ?></small><?php echo $current_user->user_firstname.' '.$current_user->user_lastname; ?></p>
						<?php if($current_user->user_email): ?><p class="user-email"><small><?php echo($language == 'en')? 'Email address' : 'البريد الإلكتروني'; ?></small><?php echo $current_user->user_email; ?></p><?php endif; ?>
						<?php if($current_user->phone): ?><p class="user-phone"><small><?php echo($language == 'en')? 'Phone number' : 'رقم المحمول'; ?></small><?php echo $current_user->phone; ?></p><?php endif; ?>
					</div>
				<?php endif; ?>
				<?php
					$fields = $checkout->get_checkout_fields( 'billing' );
					$mybillingfields=array(
						"billing_first_name",
						"billing_last_name",
						"billing_email",
						"billing_phone",
						// "billing_notes",
					);
					foreach ($mybillingfields as $key) {
						woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
					}
				?>
		</div>
		<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
			<div class="woocommerce-account-fields">
				<?php if ( ! $checkout->is_registration_required() ) : ?>

					<p class="form-row form-row-wide create-account">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" />
							<span class="create-acc"><?php echo ($language == "en")? 'Create New account?':'أريد إنشاء حساب جديد'; ?></span>
							<!-- <span class="instruction"><?php //echo ($language == "en")? 'Create a new account to subscribe to the points program and get special discount coupons':'قم بتسجيل حساب جديد للإشتراك في برنامج النقاط والحصول علي كوبونات خصم متميزة'; ?></span> -->
						</label>
					</p>

				<?php endif; ?>

				<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

				<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

					<div class="create-account">
						<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
							<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
						<?php endforeach; ?>
						<div class="clear"></div>
					</div>

				<?php endif; ?>

				<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
			</div>
		<?php endif; ?>
		<div class="shipping-fileds-container">
		<h3><?php echo($language == 'en')? 'Shipping Address' : 'عنوان الشحن'; ?></h3>
		<?php
			$fields = $checkout->get_checkout_fields( 'billing' );
			$mybillingfields=array(
				// "billing_country",
				"billing_state",
				"billing_city",
				"billing_address_1",
				"billing_building",
				"billing_building_2",
				// "billing_delivery_date",
				// "billing_time_slot",
				// "billing_notes",
			);
			foreach ($mybillingfields as $key) {
				//print_r($checkout->checkout_fields['billing'][$key]);
				woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
			}
		?>
		<!-- <input type="hidden" name="billing_country" id="billing_country" value="EG" autocomplete="country" class="country_to_state" readonly="readonly">	 -->
		<!-- <span class="description" id="billing_building-description" aria-hidden="true" style="font-size: 12px;padding-right: 5px;"> Please enter the property number and the floor and apartment number</span> -->
		</div>
		<?php
		// $fields = $checkout->get_checkout_fields( 'billing' );
		// $mybillingfields=array(
		// 	"billing_country",
		// );
		// foreach ($mybillingfields as $key) {
		// 	woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
		// }
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>
