<?php
function send_posttagy_notification($order_id, $old_status, $new_status, $order)
{
    require_once get_template_directory() . '/includes/createsend-php-master/csrest_transactional_smartemail.php';

    $api_key = '8Eym/4zx8FueYOOwtka/MO7PC6V5xedmsCpOfJP95EvPBH7NLtJcr+hGny/JFKGXE0NQDBi+Fi4qWyBciqQHY9d1m2D90XEm1QLy2HpqOJkkjMWcEfNIFrp7Fq81c3gRj+i9bX5hYhPHzA7CH6PIzA==';
    $processing = 'b4b2eea0-64c2-40a3-9be9-77a88786e17f';
    $ready_to_ship = 'ccfb0c9c-e9c6-4d5a-979f-ee3d86980520';
    $shipped = 'b92de430-7b22-424f-ba5c-5e7d9644084d';
    $completed = 'ce872f79-977b-49d4-aaf6-b6012b1675d6';
    $cancelled = 'd6fd63f1-52f7-48cf-aa21-e36a9786dffa';
    $failed = '5dde2613-97cb-45b3-a845-ace8cda2f1ce';
    $refunded = '8977870d-650b-4b10-868e-d438e60c58f9';
    $auth = array('api_key' => $api_key);
    $facebook_link = "https://www.facebook.com/profile.php?id=61552903983964&mibextid=ZbWKwL";
    $twitter_link = "www.twitter.com";
    $instagram_link = "https://www.instagram.com/joulajewelry?igsh=MWpwdzNlY2Y3NnA5aQ==";
    $website_link = "https://www.cloudhosta.com:72/";

    //Order Data
    $order = wc_get_order($order_id);
    $items = $order->get_items();

    //items
    $items_data = [];
    foreach ($items as $item) {
        $parent_id = 0;

        if ($item->get_variation_id() == 0) {
            $product_id = $item->get_product_id();
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full')[0] ?? false;
        } else {
            $product_id = $item->get_variation_id();
            $parent_id = $item->get_product_id();
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($parent_id), 'full')[0] ?? false;
        }
        $product = wc_get_product($product_id);
        $items_data[] = [
            'thumbnail' => $thumbnail,
            'name' => $product->get_name(), //get_post_meta("$product_id" , "title_ar" , true),//$product->get_meta('title_ar', true),
            'price' => number_format($product->get_regular_price()),
            'variation' => "" ,
            'quantity' => $item->get_quantity(),
            'subtotal' => number_format($item->get_subtotal())  ,
            "total" => number_format($item->get_total()),
        ];
    }

    //order info
    $msg_data = array(
        'order_total' => number_format($order->get_total()),
        'order_number' => $order_id,
        'order_currency' => "EGP",
        'items' => $items_data,
        'first_name' => $order->get_billing_first_name(),
        'last_name' => $order->get_billing_last_name(),
        'email' => $order->get_billing_email(),
        'phone' => $order->get_billing_phone(),
        //'shipping_method' => $order->get_shipping_method(),
        'billing_address' => $order->get_billing_address_1(), // Building & street number
        'billing_area' => $order->get_billing_city() ?? '',  //Area
        'billing_city' => $order->get_billing_state() ?? '', // City
        'billing_floor' => $order->get_meta('_billing_building'), //Floor
        'billing_apart' => $order->get_meta('_billing_building_2') , //Aprtment number
        'billing_country' => "Egypt",
        'order_date' => $order->get_date_created()->date('d M Y') ,
        'order_subtotal_to_display' => number_format($order->get_subtotal()),
        'shipping_to_display' => $order->get_shipping_to_display(),
        'order_total_discount' => number_format($order->get_discount_total()),
        'facebook' => $facebook_link,
        'twitter' => $twitter_link,
        'instagram' => $instagram_link,
        'website' => $website_link,
    );

    switch ($new_status) {
        case 'completed':
            $smart_email_id = $completed;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;
        case 'processing':
            $smart_email_id = $processing;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;
        case 'ready-to-ship':
            $smart_email_id = $ready_to_ship;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;
        case 'shipped':
            $smart_email_id = $shipped;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;
        case 'cancelled':
            $smart_email_id = $cancelled;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;
        case 'refunded':
            $smart_email_id = $refunded;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;
        case 'failed':
            $smart_email_id = $failed;
            $message = array(
                "To" => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '<' . $order->get_billing_email() . '>',
                "Data" => $msg_data,
            );
            break;

    }
    $wrap = new CS_REST_Transactional_SmartEmail($smart_email_id, $auth);
    $consent_to_track = 'yes';
    $wrap->send($message, $consent_to_track);
}

add_action('woocommerce_order_status_changed', 'send_posttagy_notification', 10, 4);
