<?php
require_once '../wp-content/themes/joula/header.php';
mitch_validate_logged_in();
global $current_user;
// Get Points General Settings 
// $points_settings  = get_field('points_settings' , "options");
// $level_name = $points_settings['groups'][0]['level_name'];
// if(empty($level_name)){
//     $level_name = 'Silver';
// }

// $account_start = $points_settings['general_settings']['account_creation_start_points'];
// if(empty($account_start)){
//     $account_start = 1;
// }

//User Data 
// $user_points_info = MD_get_user_points_info($current_user->ID);

// if(!empty($user_points_info)){
    
//Next Level Count 
// $next_level_name = "";
// $next_level_remaining_points = "";
// $level_available = true;
// if (array_key_exists($user_points_info->level_number + 1 ,$points_settings['groups'])){
//     $next_level_name = $points_settings['groups'][$user_points_info->level_number + 1]['level_name'];
//     $next_level_remaining_points = $points_settings['groups'][$user_points_info->level_number + 1]['start_from'] - $user_points_info->current_points ;
// }
// else {
//     $level_available = false ;
// }

// }

$user_orders = mitch_get_myorders_list();


?>

<div id="page" class="site">
    <?php require_once '../wp-content/themes/joula/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">
            <div class="page_content">
                <div class="section_nav">
                    <div class="section_title">
                        <!-- <img src="<?php // echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/login.png" alt=""> -->
                        <span
                            class="<?php //echo strtolower( $user_points_info->user_type) ; ?>"><?php //echo $user_points_info->user_type ; ?></span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="overview">

                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $lang) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $lang) ?></li>
                            <li><?php echo Myaccount_translation('myaccount_page_sidebare_overview' , $lang) ?></li>
                        </ul>
                        <h1 class="dashboard-title"> <?php echo  Myaccount_translation('myaccount_page_sidebare_overview', $lang) ; ?></h1>
                        <?php if( isset($_GET['register']) && $_GET['register'] == "true" ){  ?>
                        <div class=" callback-message success-message show-message  ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png"
                                alt="" class="success-icon">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png"
                                alt="" class="error-icon">
                            <p>Thank You For Joining Joula</p>
                        </div>
                        <?php } ?>
                        <div class="sharebutton section">
                            <h2>Share Joula With Family & Friends</h2>
                            <p>Share the below link with your beloved and get special offers</p>
                            <div class="details">
                                <div class="left">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/percent.png"
                                        alt="">
                                    <p>www.joula.com/ref=1-02o0;20409</p>
                                </div>
                                <div class="right">
                                    <button onclick="copyText()">
                                        Copy Link
                                    </button>
                                    <p class='copied-message'> Copied!</p>
                                </div>

                            </div>
                        </div>
                        <?php if(!empty($user_orders)){  ?>
                        <div class="order-details section">
                            <h3 class="section-title-basic"><?php echo Myaccount_translation('overview_orders_return_title' , $lang) ?></h3>


                            <?php if(!wp_is_mobile()) { ?>
                            <div class="MD-orders-list desktop">
                                <div class="section_tabel">
                                    <?php
                                   
                                    if(!empty($user_orders)){
                                    ?>
                                    <table>
                                        <tr>
                                            <th><?php echo  Myaccount_translation('overview_orders_return_table_titles_status' , $lang) ;?></th>
                                            <th><?php echo  Myaccount_translation('overview_orders_return_table_titles_order_no' , $lang) ;?></th>
                                            <th><?php echo  Myaccount_translation('overview_orders_return_table_titles_date' , $lang) ;?></th>
                                            <th><?php echo  Myaccount_translation('overview_orders_return_table_titles_price' , $lang) ;?></th>
                                            <th></th>
                                        </tr>
                                        <?php $order_counter = 0 ; ?>
                                        <?php $count=1; foreach($user_orders as $order_obj){
                                        if($order_counter == 5)
                                        break;
                                        $order_counter++;
                                        if( $order_obj->get_status() == 'pending')
                                        continue;
                                        
                                        ?>
                                        <tr class="<?php echo($count%2==0)?'even':'odd';?>">
                                            <td class="status">
                                                <span class="<?php echo $order_obj->get_status();?>">
                                                    <?php echo $order_obj->get_status(); ?>
                                                </span>
                                            </td>
                                            <td class="order_number"> <a
                                                    href="<?php echo home_url('my-account/orders-list/order-details');?>">#<?php echo $order_obj->get_id();?>
                                            </td>
                                            <td><?php echo $order_obj->get_date_created()->date("j/n/Y");?></a>
                                            </td>
                                            <td>
                                                <?php echo $theme_settings['current_currency'].' '. number_format($order_obj->get_total());?>

                                            </td>

                                            <td class="table_action">
                                                <a <?php $Query = "/myaccount/order-details.php?order_id=". $order_obj->get_id()  ;   ?>
                                                    href="<?php echo home_url($Query);?>">
                                                    <button class="show"
                                                        type="button"><?php echo  Myaccount_translation('overview_orders_return_table_titles_button' , $lang) ?></button>
                                                </a>

                                            </td>
                                        </tr>
                                        <?php
                                $count++;  }
                                    ?>
                                    </table>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php  if(wp_is_mobile()) {?>
                            <div class="MD-orders-list mobile">
                                <div class="section_tabel">
                                    <?php
                                    $user_orders = mitch_get_myorders_list();
                                    if(!empty($user_orders)){
                                    ?>
                                    <table>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <?php $count=1; foreach($user_orders as $order_obj){ ?>
                                        <tr class="<?php echo($count%2==0)?'even':'odd';?>">
                                            <td class="order_number"> <a
                                                    href="<?php echo home_url('my-account/orders-list/order-details');?>">#<?php echo $order_obj->get_id();?></a>
                                            </td>
                                            <td class="status mobile">
                                                <span class="<?php echo $order_obj->get_status();?>">
                                                    <?php echo $order_obj->get_status(); ?>
                                                </span>
                                                <span class="new">
                                                    <?php echo $order_obj->get_date_created()->date("j/n/Y");?>
                                                </span>
                                                <span class="new price">
                                                    <?php echo $theme_settings['current_currency'].' '.$order_obj->get_total();?>
                                                </span>

                                            </td>

                                            <td class="table_action">
                                                <a <?php $Query = "/myaccount/order-details.php?order_id=". $order_obj->get_id()  ;   ?>
                                                    href="<?php echo home_url($Query);?>">
                                                    <button class="show"
                                                        type="button"><?php echo $fixed_string['myaccount_page_orders_show'];?></button>
                                                </a>

                                            </td>
                                        </tr>
                                        <?php
                                $count++;  }
                                    ?>
                                    </table>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                            <?php } ?>


                        </div>
                        <?php }  ?>
                        <div class="account-info section">
                            <h3 class="section-title-basic"> <?php echo  Myaccount_translation('myaccount_page_sidebare_profile' , $lang) ?></h3>
                            <div class="boxes">
                                <div class="change-info yellow-box">
                                    <h4 class="yellow-box-title">Your Info.</h4>
                                    <div class="MD-row half">
                                        <label> <?php echo Myaccount_translation('account_first_name' , $lang)   ?></label>
                                        <span> <?php echo get_user_meta($current_user->ID, 'first_name', true);?></span>
                                    </div>
                                    <div class="MD-row half">
                                        <label> <?php echo Myaccount_translation('account_last_name' , $lang)   ?></label>
                                        <span> <?php echo get_user_meta($current_user->ID, 'last_name', true);?></span>
                                    </div>
                                    <div class="MD-row">
                                        <label><?php echo Myaccount_translation('account_email' , $lang)   ?> </label>
                                        <!-- static -->
                                        <span><?php echo $current_user -> user_email ?></span>
                                    </div>
                                    <div class="MD-row">
                                        <label> <?php echo Myaccount_translation('account_mobile' , $lang)   ?></label>
                                        <!-- static -->
                                        <span><?php echo get_user_meta($current_user->ID, 'phone_number', true)  ?></span>

                                    </div>
                                    <a href="<?php echo home_url('myaccount/profile.php');?>"><?php echo Myaccount_translation('Edit_keyword' , $lang); ?></a>
                                </div>
                                <?php $main_address    = mitch_get_user_main_address($current_user->ID);?>
                                <?php if(!empty($main_address)) { ?>
                                <div class="change-info yellow-box">
                                    <h4 class="yellow-box-title"><?php echo Myaccount_translation('shipping_default_address' , $lang)   ?></h4>
                                    <div class="MD-row half">
                                        <label><?php echo Myaccount_translation('shipping_city' , $lang)   ?></label>
                                        <span> <?php echo $main_address -> city ?></span>
                                    </div>
                                    <div class="MD-row half">
                                        <label><?php echo Myaccount_translation('shipping_area' , $lang)   ?></label>
                                        <span> <?php echo $main_address -> area  ?></span>
                                    </div>
                                    <div class="MD-row">
                                        <label><?php echo Myaccount_translation('shipping_street' , $lang)   ?>.</label>
                                        <span> <?php echo $main_address -> full_address  ?></span>
                                    </div>
                                    <div class="MD-row half">
                                        <label><?php echo Myaccount_translation('shipping_floor' , $lang)   ?></label>
                                        <span> <?php echo $main_address -> Floor ?></span>
                                    </div>
                                    <div class="MD-row half">
                                        <label><?php echo Myaccount_translation('shipping_apartment' , $lang)   ?></label>
                                        <span> <?php echo $main_address -> apartment ?></span>
                                    </div>
                                    <a href="<?php echo home_url('myaccount/addresses.php');?>"><?php echo Myaccount_translation('shipping_edit_address' , $lang)   ?></a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page-->
</div>
<?php require_once '../wp-content/themes/joula/footer.php';?>