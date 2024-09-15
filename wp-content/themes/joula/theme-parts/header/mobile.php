<?php
// Header Data 
$top_header_items = get_field('top_header', 'options');
$popup_content = get_field('main_nav_and_popup' , 'options');
$Bottom_header = get_field('header_builder_en' , 'options');
?>
<div class="section_header_mobile">
    <div class="top-slider">
        <?php 
            
              if(!empty($top_header_items)){
                foreach($top_header_items as $top_header_item){
                  echo "<p>{$top_header_item['content']}</p>";
                }
              }
              ?>
    </div>

    <?php if( strpos(($_SERVER['REQUEST_URI']) , 'myaccount')  == false){ ?>
    <div class="section_header_col_two">
        <div class="top_mobile">
            <div class="left">
                <div class="menu_button_mobile">
                    <button type="button" class="menu_mobile_icon open"> <img
                            src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/menu.png" alt=""></button>
                </div>
            </div>
            <div class="center">
                <div class="logo">
                    <a href="<?php echo $theme_settings['site_url'];?>">
                        <img src="<?php echo $theme_settings['logo_black'];?>" alt="">
                    </a>
                </div>
            </div>
            <div class="right">
                <?php if(!is_user_logged_in()){ ?>
                <div class="wishlist">
                    <a href="<?php echo home_url('myaccount/user-login.php');?>" class="js-popup-opener"></a>
                </div>
                <?php } else { ?>
                <div class="wishlist">
                    <a href="<?php echo home_url('myaccount/wishlist.php');?>"></a>
                </div>
                <?php  } ?>





                <?php if(!is_cart()){ ?>
                <div class="cart">
                    <!-- <a href="<?php// echo home_url('cart');?>"> -->
                    <a href="#popup-min-cart" class="js-popup-opener">
                        <div class="section_icon_cart">
                            <?php //echo WC()->cart->get_total();?>
                            <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/cart.png" alt="">
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>


    <?php if( strpos(($_SERVER['REQUEST_URI']) , 'myaccount')  !== false){ ?>
    <div class="my-account-header">
        <div class="top_mobile">
            <div class="center">
                <div class="logo">
                    <a href="<?php echo $theme_settings['site_url'];?>">
                        <img src="<?php echo $theme_settings['logo_black'];?>" alt="">
                    </a>
                </div>
            </div>
            <div class="right">
                <a href="<?php echo $theme_settings['site_url'];?>" class="MD-btn-go">Home page</a>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- <div class="section_header_col_three">
      <div class="section_bottom">
        <nav class="main-nav">
          <ul class="main-menu">
            <?php
           // $header_items = get_field('header_builder_'.$theme_settings['current_lang'], 'options');
            // echo '<pre>';
            // var_dump($header_items);
            // echo '</pre>';
            // if(!empty($header_items)){
            //   $current_page_obj = get_queried_object();
            //   foreach($header_items as $header_item){
            //     $active   = '';
            //     if($header_item['item_type'] == 'product_cat'){
                  // var_dump($header_item['item_url_product_cat']->term_id);
                  // var_dump($page_id);
                //   if(isset($current_page_obj->term_id) && $header_item['item_url_product_cat']->term_id == $current_page_obj->term_id){
                //     $active = 'active';
                //   }
                // }else{
                //   if(isset($current_page_obj->post_title) && $header_item['item_name'] == $current_page_obj->post_title){
                //     $active = 'active';
                //   }
                // }
                // if(!$header_item['item_group']['item_has_mega_dropdown']){
                  ?>
                  <li class="single_menu_mobile">
                    <a href="<?php //if($header_item['item_url_page']){echo $header_item['item_url_page'];}else{echo get_term_link($header_item['item_url_product_cat']->term_id, 'product_cat');}?>"
                      class="category_link <?php// echo $active;?>">
                      <?php // echo $header_item['item_name'];?>
                    </a>
                  </li>
                  <?php
                // }else{
                  ?>
                  <li class="single_menu_mobile has-mega">
                    <a href="<?php //if($header_item['item_url_page']){echo $header_item['item_url_page'];}else{if($header_item['item_url_product_cat']){echo get_term_link($header_item['item_url_product_cat']->term_id, 'product_cat');}}?>"
                      class="category_link <?php// echo $active;?>">
                      <?php // echo $header_item['item_name'];?>
                    </a>
                  </li>
                  <?php 
            //     } 
            //   } 
            // } 
            ?>
          </ul>
        </nav>
      </div>
  </div> -->

    <div class="mobile-nav">
        <div class="mobile-menu">
            <nav class="main-navigation">

                <div class="more_support_menu">
                    <!-- <div class="track_order flex_support">
                      <a href="<?php// echo home_url('tracking-order');?>">Track My Order</a>
                  </div> -->

                    <?php //if(!is_user_logged_in()){ ?>
                    <!-- <div class="wishlist flex_support">
                          <a href="#popup-login"  class="js-popup-opener"></a>
                      </div>
                      <?php //} else { ?>
                        <div class="wishlist flex_support">
                          <a href="<?php //echo home_url('wishlist');?>"></a>
                      </div> -->
                    <?php // } ?>
                    <div class="left">
                        <div class="new_search search flex_support">


                            <span class="icon_search"></span>

                        </div>

                        <?php if(!is_user_logged_in()){ ?>
                        <div class="my_account">
                            <a href="<?php echo home_url('myaccount/user-login.php');?>" class="title_login">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/account.png"
                                    alt="">
                            </a>
                        </div>
                        <?php } else { ?>
                        <div class="my_account">
                            <a href="<?php echo home_url('myaccount');?>" class="title_login">
                                <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/account.png"
                                    alt="">
                            </a>
                        </div>
                        <?php } ?>
                    </div>


                    <?php //if(!is_cart()){ ?>
                    <!-- <div class="cart flex_support"> -->
                    <!-- <a href="<?php// echo home_url('cart');?>"> -->
                    <!-- <a href="#popup-min-cart" class="js-popup-opener">
                          <div class="section_icon_cart">
                            <?php //echo WC()->cart->get_total();?>
                                <span id="cart_total_count"><?php//echo WC()->cart->get_cart_contents_count(); ?></span>
                                <img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/new_icons/cart.png" alt="">
                          </div>
                        </a>
                    </div> -->
                    <?php// } ?>

                    <button class="menu_mobile_icon close flex_support"><i class="material-icons">close</i></button>
                </div>

                <nav class="menu-main-nav-container">
                    <ul class="menu">
                        <?php foreach($popup_content as $popup_items){  ?>
                        <?php if($popup_items['has_mega']){ ?>
                        <li class="single_menu">

                            <a class="category_link "> <?php echo $popup_items['item_name'] ?> </a>

                            <ul class="details_menu">
                                <?php foreach($popup_items['popup_group']['popup_items'] as $one_item) {  ?>
                                <li>
                                    <a href="<?php echo $one_item['item_link'] ?>">
                                        <?php echo $one_item['item_name'] ?></a>
                                </li>
                                <?php  } ?>
                            </ul>

                        </li>
                        <?php } ?>
                        <?php } ?>

                    </ul>
                    <ul class="supporting_nav">
                        <?php foreach($Bottom_header['buttom_group']['buttom_items'] as $buttom_item){ ?>
                        <li>
                            <a href="<?php echo $buttom_item['page_link']; ?>">
                                <?php echo $buttom_item['page_title']; ?></a>
                        </li>


                        <?php } ?>
                        <?php if ( is_user_logged_in() ) : ?>
                        <li class="logout"><a href="<?php echo wp_logout_url(home_url());?>">Logout</a>
                        </li>
                        <?php endif; ?>


                    </ul>
                </nav>
                <div class="supporting_nav">
                    <?php
            // wp_nav_menu(
            //   array(
            //     'theme_location' => 'top-nav-menu-'.$theme_settings['current_lang'].'',
            //     'container'      => 'nav',
            //   )
            // );
          ?>
                </div>
            </nav>
        </div>
    </div>

</div>