<?php
require_once '../wp-content/themes/joula/header.php';
mitch_validate_logged_in();
$WishLish_Products = mitch_get_wishlist_products(); 
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
                    <span class="<?php echo strtolower( $user_type) ; ?>"><?php echo $user_type ; ?></span>
                        <h3 class="name">
                            <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                        </h3>
                    </div>
                    <?php include_once 'myaccount-sidebar.php';?>
                </div>
                <div class="dashbord">
                    <div class="wishlist">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $lang) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $lang) ?></li>
                            <li><?php echo Myaccount_translation('wishlist_page_title' , $lang) ?></li>
                        </ul>
                        <h1 class="dashboard-title"><?php echo Myaccount_translation('wishlist_page_title' , $lang) ?></h1>

                        <?php if(empty($WishLish_Products)){ ?>
                        <div class="empty-content">
                            <p><?php echo Myaccount_translation('Wishlist_no_items' , $lang) ?></p>
                            <a href="<?php echo site_url() ;  ?>" class="js-MD-popup-opener MD-btn-go">Shop Now</a>
                        </div>
                        <?php } else { ?>
                        <div class="list">
                     
                            <?php foreach($WishLish_Products as $one_product){ ?>
                                <?php 
                                $product_data = mitch_get_short_product_data($one_product -> product_id);
                              //  var_dump($one_product -> product_id);
                                    ?>
                                <div id="product_<?php echo $product_data['product_id'];?>_block" class="product_widget">
                                    <?php if(mitch_check_wishlist_product(get_current_user_id(), $product_data['product_id'])){ ?>
                                    <span class="fav_btn favourite"
                                        onclick="remove_product_from_wishlist(<?php echo $product_data['product_id'];?>, '<?php echo $wishlist_remove;?>');"></span>
                                    <?php }else{ ?>
                                    <span class="fav_btn not-favourite"
                                        onclick="add_product_to_wishlist(<?php echo $product_data['product_id'];?>);"></span>
                                    <?php } ?>
                                    <!-- <span class="label new">new</span> -->
                                    <?php /*}*/
                                    ?>
                                    <a class="product_widget_box" href="<?php echo $product_data['product_url'];?>">
                                        <div class="img <?php echo($product_data['product_flip_image'])? 'has-flip':'' ?>">
                                            <img class="original" src="<?php echo $product_data['product_image'];?>" alt="">
                                            <?php if(!empty($product_data['product_flip_image'])){ ?>
                                            <img class="flip" src="<?php echo $product_data['product_flip_image'];?>" alt="">
                                            <?php }?>
                                        </div>
                                        <div class="sec_info">
                                            <h3 class="title"><?php echo $product_data['product_title'];?></h3>
                                            <p class="price"><?php echo number_format($product_data['product_price']);?>
                                                <?php echo $theme_settings['current_currency'];?></p>
                                        </div>
                                    </a>
                                </div>

                            <?php }  ?>

                            <!-- <div id="" class="product_widget">
                                <span class="fav_btn favourite" onclick="//add_product_to_wishlist(3293);"></span>
                                <a class="product_widget_box"
                                    href="https://www.cloudhosta.com:61/product/trace-gold-ring-copy-copy/">
                                    <div class="img ">
                                        <img class="original"
                                            src="https://www.cloudhosta.com:61/wp-content/uploads/2023/01/Rectangle.png"
                                            alt="">
                                        <img class="flip"
                                            src="https://www.cloudhosta.com:61/wp-content/uploads/2023/01/Rectangle.png"
                                            alt="">
                                    </div>
                                    <div class="sec_info">
                                        <h3 class="title">Trace Gold Ringg</h3>
                                        <p class="price">5,200.00 EGP</p>
                                    </div>
                                </a>
                            </div> -->
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end page-->
    <?php require_once '../wp-content/themes/joula/footer.php';?>