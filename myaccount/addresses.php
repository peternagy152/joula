<?php
require_once '../wp-content/themes/joula/header.php';
mitch_validate_logged_in();
$current_user_id = get_current_user_id();
$main_address    = mitch_get_user_main_address($current_user_id);
$other_addresses = mitch_get_user_others_addresses_list($current_user_id);

$user_type = "silver" ;
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
                        <span class="<?php echo strtolower( $user_type) ; ?>"><?php echo $user_type ; ?></span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="addresses">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $lang) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $lang) ?></li>
                            <li><?php echo Myaccount_translation('myaccount_page_sidebare_address' , $lang) ?></li>
                        </ul>
                        <h1 class="dashboard-title"> <?php  echo Myaccount_translation('myaccount_page_sidebare_address' , $lang)?>
                            <!-- Add this button only when there is any address -->
                            <?php if(!empty($main_address)){ ?>
                            <a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add"><?php echo Myaccount_translation('shipping_add_new_address' , $lang) ?></a>
                            <?php }  ?>
                            <!-- --- -->
                        </h1>

                        <?php if(empty($main_address)){ ?>
                        <div class="empty-content">
                            <p><?php echo Myaccount_translation('shipping_no_address_note' , $lang) ?></p>
                            <a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add"><?php echo Myaccount_translation('shipping_add_new_address' , $lang) ?></a>
                        </div>
                        <?php } ?>
                        <div class="real-data">
                            <!--  ------------ Main Address ----------- -->
                            <!--  ------------ Main Address ----------- -->
                            <?php if(!empty($main_address)){ ?>
                            <div class="single-address yellow-box">
                                <h4 class="yellow-box-title">
                                <?php echo Myaccount_translation('shipping_default_address' , $lang)   ?>
                                    <div class="MD-menu">
                                        <span class="menu-icon"></span>
                                        <div class="list">
                                            <ul> 
                                            <li class = "edit-address"  data-counter = "0" data-edit = "<?php echo $main_address -> ID ?>"><a class="js-MD-popup-opener" href="#edit-addresss"> <?php echo Myaccount_translation('shipping_edit_address' , $lang) ?></a></li>
                                                <li class="red remove" data-address ="<?php echo $main_address -> ID ?>" data-default="1"><a><?php echo Myaccount_translation('shipping_remove' , $lang) ?></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                </h4>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_city' , $lang)   ?></label>
                                    <span> <?php echo $main_address -> city ?></span>
                                    
                                </div>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_area' , $lang)   ?></label>
                                    <span> <?php echo $main_address -> area  ?></span>
                                </div>
                                <div class="MD-row">
                                <label><?php echo Myaccount_translation('shipping_street' , $lang)   ?>.</label>
                                    <span> <?php echo $main_address -> full_address  ?></span>
                                </div>
                                <?php if($main_address -> apartment_type == 'flat'){ ?>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_floor' , $lang)   ?></label>
                                    <span> <?php echo $main_address -> Floor ?></span>
                                </div>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_apartment' , $lang)   ?></label>
                                    <span> <?php echo $main_address -> apartment ?></span>
                                </div>
                                <?php  } ?>
                            </div>
                            <?php }  ?>
                            <!--  -----------  Other Addresses  ----------- -->
                            <?php $address_counter =  0 ;?>
                             <?php foreach($other_addresses as $one_address){ ?>
                                <?php $address_counter++ ; ?>
                            <div class="single-address yellow-box">
                                <h4 class="yellow-box-title" >
                                <?php echo Myaccount_translation('shipping_address' , $lang)   ?> <?php echo ' ' . $address_counter ; ?>
                                    <div class="MD-menu">
                                        <span class="menu-icon"></span>
                                        <div class="list">
                                            <ul>
                                                <li class = "edit-address" data-counter = " <?php echo $address_counter ; ?> " data-edit = "<?php echo $one_address -> ID ?>"><a class="js-MD-popup-opener" href="#edit-addresss"> <?php echo Myaccount_translation('shipping_edit_address' , $lang) ?></a></li>
                                                <li class = "change" data-current-default =" <?php echo $main_address-> ID ?>" data-new-default = "<?php echo $one_address -> ID ?>"><a> <?php echo Myaccount_translation('shipping_make_default' , $lang) ?></a></li>
                                                <li  class="remove red " data-default="0" data-address = "<?php echo $one_address -> ID ?>"><a><?php echo Myaccount_translation('shipping_remove' , $lang) ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </h4>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_city' , $lang)   ?></label>
                                    <span> <?php echo  $one_address -> city ?></span>
                                </div>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_area' , $lang)   ?></label>
                                    <span> <?php echo  $one_address -> area ?></span>
                                </div>
                                <div class="MD-row">
                                <label><?php echo Myaccount_translation('shipping_street' , $lang)   ?>.</label>
                                    <span> <?php echo  $one_address -> full_address ?></span>
                                </div>
                                <?php if($one_address -> apartment_type == 'flat'){ ?>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_floor' , $lang)   ?></label>
                                    <span> <?php echo  $one_address -> Floor ?></span>
                                </div>
                                <div class="MD-row small">
                                <label><?php echo Myaccount_translation('shipping_apartment' , $lang)   ?></label>
                                    <span> <?php echo  $one_address -> apartment ?></span>
                                </div>
                                <?php }  ?>
                            </div>
                            <?php } ?>
                            <?php if(!empty($main_address)){ ?>
                            <a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add">Add Address</a>
                            <?php }  ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page-->

</div>

<?php require_once '../wp-content/themes/joula/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>
<script>
$.ajax({
      type: "POST",
      url: mitch_ajax_url,
      data: {
        action: "get_city",
        state: 'Cairo',
      },
      success: function (posts) {
        if(window.location.href.indexOf('addresses')>-1){
        $("#area").html(posts);
        }else{
        $("#billing_city_field").html(posts);
        }
        $("#billing_city_field").removeClass("blocked");
      },
    });
</script>