<?php
require_once '../wp-content/themes/joula/header.php';
mitch_validate_logged_in();
//repeat order process
mitch_repeat_order();
$user_orders = mitch_get_myorders_list();

$user_type = "silver" ;
?>
<style>
#repeat_order_button {
    width: 250px;
    background: black;
    color: white;
    font-size: 16px;
    font-weight: 600;
    line-height: 24px;
    padding: 14px 0;
    margin: 30px 30px 30px auto;
    display: block;
    text-align: center;
}
</style>
<div id="page" class="site">
<?php require_once '../wp-content/themes/joula/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">

            <div class="page_content">
                <div class="section_nav">
                    <div class="section_title">
                    <span class="<?php echo strtolower( $user_type) ; ?>"><?php echo $user_type ; ?></span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="orders">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $lang) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $lang) ?></li>
                            <li><?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $lang) ?></li>
                        </ul>
                        <h1 class="dashboard-title"><?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $lang) ?></h1>
                        <?php  if(empty($user_orders)){ ?>
                        <div class="empty-content">
                            <p><?php echo Myaccount_translation('Orders_no_orders' , $lang) ?></p>
                            <a href="<?php echo home_url();?>" class="js-MD-popup-opener MD-btn-go"><?php echo Myaccount_translation('Orders_shop_now' , $lang) ?></a>
                        </div>
                        <?php } else{  ?>


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
                                    <?php $count=1; foreach($user_orders as $order_obj){
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
                                                >#<?php echo $order_obj->get_id();?>
                                        </td>
                                        <td><?php echo $order_obj->get_date_created()->date("j/n/Y");?></a>
                                        </td>
                                        <td>
                                            <?php echo $theme_settings['current_currency'].' '. number_format($order_obj->get_total());?>

                                        </td>
                                        
                                        <td class="table_action">
                                            <a
                                            <?php $Query = "/myaccount/order-details.php?order_id=". $order_obj->get_id()  ;   ?> 
                                                href="<?php echo home_url($Query);?>">
                                                <button class="show"
                                                    type="button"><?php echo Myaccount_translation('overview_orders_return_table_titles_button' , $lang) ?></button>
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
                                                >#<?php echo $order_obj->get_id();?></a>
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
                                            <a
                                            <?php $Query = "/myaccount/order-details.php?order_id=". $order_obj->get_id()  ;   ?> 
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
                     <?php } ?>

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