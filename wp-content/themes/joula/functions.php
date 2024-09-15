<?php
//thired party integrations
require_once 'includes/campaign-monitor/csrest_subscribers.php';
//internal functions
require_once 'includes/global-functions.php';
require_once 'includes/translate-functions.php';
require_once 'includes/products-functions.php';
require_once 'includes/wishlist-functions.php';
require_once 'includes/cart-functions.php';
require_once 'includes/checkout-functions.php';
require_once 'includes/myaccount-functions.php';
require_once 'includes/wpadmin-functions.php';
require_once 'includes/pages-functions.php';
require_once 'includes/backorders-functions.php';
require_once 'includes/thankspage-functions.php';

//Posttagy Mails
require_once 'includes/posttagy.php';

// Global Variables 
require_once 'includes/global-variables.php';


// Include All My Account Functions 
require_once( ABSPATH . 'myaccount/myaccount-global-functions/myaccount-translation.php' );
require_once( ABSPATH . 'myaccount/myaccount-global-functions/new-myaccount-functions.php' );
// require_once( ABSPATH . 'myaccount/myaccount-global-functions/points-system-dashboard.php' );
// require_once( ABSPATH . 'myaccount/myaccount-global-functions/points-system-functions.php' );
// require_once( ABSPATH . 'myaccount/myaccount-global-functions/wallet-payment.php' );
