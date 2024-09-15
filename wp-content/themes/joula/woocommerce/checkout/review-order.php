<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
global $theme_settings;
$language = $theme_settings['current_lang'];
?>
<?php

?>

<table class="shop_table woocommerce-checkout-review-order-table">
    <!-- <thead>
		<tr>
			<th class="product-name"></th>
			<th class="product-total"></th>
			<th class="product-quantity"></th>
		</tr>
	</thead> -->
    <tbody>
    <?php
    do_action('woocommerce_review_order_before_cart_contents');
    //var_dump(WC()->cart->get_fees());

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
            ?>
            <tr
                    class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                <td class="product-name">

                    <div class="product-thumb-name">
                        <?php
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                        if (!$product_permalink) {
                            echo $thumbnail;
                        } else {
                            printf('<a href="%s" class="cart_pic">%s</a>', esc_url($product_permalink), $thumbnail);
                        }
                        ?>
                        <div class="product-name-container">
                            <div class="right">
                                <?php $product_name = $_product->get_name();
                                if (strpos($product_name, "-") !== false) {
                                    //$index =
                                    $product_name = substr($product_name, 0, strpos($product_name, "-"));
                                }
                                ?>
                                <h3 class="product-title">
                                    <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $product_name, $cart_item, $cart_item_key)) . '&nbsp;'; ?>
                                </h3>
                                <ul class="variations">
                                    <?php


                                    $item_id = (!empty($cart_item['variation_id'])) ? $cart_item['variation_id'] : '';
                                    if (!empty($item_id)) {
                                        // $_pf = new WC_Product_Factory();
                                        // $product = $_pf -> get_product($cart_item['product_id']);
                                        $pp = new WC_Product_Variation($item_id);
                                        $variation_data = $pp->get_variation_attributes();
                                        $variation_detail = woocommerce_get_formatted_variation($variation_data, true);
                                        //var_dump($variation_data);
                                        $remove = "attribute_pa_";
                                        $terms = get_terms([
                                            'taxonomy' => 'pa_color',
                                            'hide_empty' => false,
                                        ]);
                                        foreach ($variation_data as $key => $value) {
                                            $attribute_name = str_replace($remove, '', $key);
                                            $Current_color = str_replace(' ', '', $value);
                                            $Current_color = str_replace('-', '', $Current_color);

                                            ?>
                                            <?php if ($attribute_name == 'color') { ?>
                                                <?php
                                                $color_hex_id = 0;
                                                foreach ($terms as $one_term) {
                                                    $Loop_color = str_replace(' ', '', $one_term->name);
                                                    $Loop_color = str_replace('-', '', $Loop_color);

                                                    if (strtolower($Loop_color) == strtolower($Current_color)) {

                                                        //var_dump($Current_color);
                                                        $color_hex_id = $one_term->term_id;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <li> Color: <span
                                                            style="background-color:<?php echo get_field('color_hex_code', 'term_' . $color_hex_id . ''); ?>"></span>
                                                </li>
                                            <?php } else { ?>
                                                <li> <?php echo $attribute_name ?> : <?php echo ucfirst($value); ?></li>
                                            <?php } ?>

                                            <?php

                                        }
                                    }
                                    ?>
                                </ul>
                                <h4 class="quantity">
                                    <?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </h4>
                                <div class="prices">
                                    <div class="single-price">
                                        <p><span class="woocommerce-Price-amount amount">
                                            <?php echo number_format($cart_item['data']->price); ?>
                                            <span class="woocommerce-Price-currencySymbol"> EGP </span>
                                        </span></p>
                                        <?php $show_regular_price = true ;  ?>
                                        <?php if ($cart_item['data']->price != $cart_item['data']->get_regular_price()) { ?>
                                                <?php $show_regular_price = false ; ?>
                                            <p class="sale"> <?php echo number_format($cart_item['data']->get_regular_price()) . ' EGP'; ?></p>
                                        <?php } ?>

                                    </div>
                                    <div class="total-price">
                                        <p><?php $Line_Price = (WC()->cart->get_product_subtotal($_product, $cart_item['quantity'])); ?>
                                            <?php echo apply_filters('woocommerce_cart_item_subtotal', $Line_Price, $cart_item, $cart_item_key); ?>
                                        </p>
                                        <?php if (!$show_regular_price) { ?>
                                            <p class="sale"><?php echo number_format($cart_item['data']->get_regular_price() * $cart_item['quantity']) . " EGP" ?></p>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- - -------------------------- Variation Data ----------------------- -->

                                <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <!-- <div class="left">
                               WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) -->
                            <!-- <?php //$Line_Price = (WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] )) ; ?>
                            <?php //echo apply_filters( 'woocommerce_cart_item_subtotal', $Line_Price , $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> -->
                            <!-- </div> -->
                        </div>
                    </div>


                </td>
            </tr>
            <?php
        }
    }

    do_action('woocommerce_review_order_after_cart_contents');
    ?>
    </tbody>
    <tfoot>

    <tr class="cart-subtotal">
        <th><?php echo 'Subtotal';//esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
        <?php
        $cart_subtotal = str_replace('.00', '', WC()->cart->get_cart_subtotal());
        //$cart_subtotal = number_format($cart_subtotal) ;
        ?>
        <td><?php echo $cart_subtotal; ?></td>
    </tr>


    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

        <?php do_action('woocommerce_review_order_before_shipping'); ?>

        <?php wc_cart_totals_shipping_html(); ?>

        <?php do_action('woocommerce_review_order_after_shipping'); ?>

    <?php endif; ?>

    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
        <tr class="fee">
            <th><?php echo esc_html($fee->name); ?></th>
            <td><?php wc_cart_totals_fee_html($fee); ?></td>
        </tr>
    <?php endforeach; ?>

    <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
        <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
            <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                    <th><?php echo esc_html($tax->label); ?></th>
                    <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr class="tax-total">
                <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
                <td><?php wc_cart_totals_taxes_total_html(); ?></td>
            </tr>
        <?php endif; ?>
    <?php endif; ?>

    <?php do_action('woocommerce_review_order_before_order_total'); ?>
    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
        <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
            <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
            <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty(WC()->cart->applied_coupons)) { ?>
        <tr class="coupon-section">
            <td colspan="100%">
                <?php if (wc_coupons_enabled()) { ?>
                    <div class="coupon-row">
                        <form class="checkout_coupon woocommerce-form-coupon" method="post" action="">
                            <button type="button" class="close-coupon"><i class="material-icons">close</i></button>
                            <div class="coupon">
                                <input type="text" name="coupon_code" class="input-text"
                                       placeholder="<?php echo ($language == 'en') ? 'Enter Promocode' : 'بروموكود' ?>"
                                       id="coupon_code" value=""/>
                                <button type="submit" id="apply_coupon" class="button btn blue" name="apply_coupon"
                                        value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php echo ($language == 'en') ? 'Apply Now' : 'أدخلي الكود' ?></button>
                            </div>
                        </form>
                        <p class="open-coupon">
                            <?php echo ($language == 'en') ? 'Do you have a promo-code?' : 'هل لديكي بروموكود ؟' ?>
                            <!-- <a href="#" class="btn blue"><?php //echo($language == 'en')? 'Apply Now' : 'أدخلي الكود'?></a></p> -->
                    </div>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    <tr class="order-total">
        <th><?php esc_html_e('Total', 'woocommerce'); ?></th>
        <?php
        $cart_total = str_replace('.00', '', WC()->cart->get_total());
        ?>
        <td> <?php echo $cart_total ?></td>
        <!-- <td><?php //wc_cart_totals_order_total_html(); ?></td> -->
    </tr>
    <!-- <tr>
        <th></th>
        <td>السعر شامل الضريبة</td>
    </tr> -->

    <?php do_action('woocommerce_review_order_after_order_total'); ?>

    </tfoot>
</table>