<?php //delete_post_meta(32499, 'products_prices_list'); ?>
<div class="section_header">
    <div class="top-slider">
    <?php 
              $top_header_items = get_field('top_header', 'options');
              if(!empty($top_header_items)){
                foreach($top_header_items as $top_header_item){
                  ?>
                  <p> <?php echo $top_header_item['content']  ?></p> 
                  <?php 
                }
              }
              ?>
    </div>
    <div class="section_header_col_one">
      <div class="grid">
           <div class="logo">
                    <a href="<?php echo $theme_settings['site_url'];?>">
                      <img src="<?php echo $theme_settings['logo_black'];?>" alt="">
                    </a>
                </div>
      </div>
    </div>
    <div class="section_header_col_two">
        <div class="grid">
            <div class="section_top">
                <div class="section_left">
                 <div class="new_search search">
                     

                     <span class="icon_search"></span>
                      
                  </div>
                  <?php if(!is_user_logged_in()){ ?>
                      <div class="my_account">
                          <a href="<?php echo home_url('myaccount/user-login.php');?>" class="title_login">
                              <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/account.png" alt="">
                          </a>
                      </div>
                    <?php } else { ?>
                      <div class="my_account">
                          <a href="<?php echo home_url('myaccount');?>" class="title_login">
                              <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/account.png" alt="">
                          </a>
                      </div>
                    <?php } ?>
                </div>

                <div class="section_center">
                  <!-- ----------------------- Header Menu Middle Section -----------------------   -->
           <nav class = "main-nav">
            <ul class = "main-menu">
              <?php
              $header_items = get_field('main_nav_and_popup' , "options");
              $count_has_mega = 0 ;
              foreach($header_items as $header_item){
                $count_has_mega++;
                  ?>
                    <li class="single_menu  <?php if($header_item['has_mega']){echo "has_menu";} ?>">
                        <?php if($header_item['has_mega']){ ?>
                          <a class="category_link  open_menu " href = "#pop_<?php echo  $count_has_mega ?>"> <?php echo $header_item['item_name'];?></a> 

                         <?php }else{   ?>
                          <a class="category_link " href = "<?php echo $header_item['page_url'] ?>"> <?php echo $header_item['item_name'];?></a> 
                         <?php } ?>
                        
                    </li>
                <?php } ?>

            </ul>

           </nav>
                 
                </div>
               
                <div class="section_right">
                    <?php if(is_user_logged_in()){ ?>
                        <div class="wishlist">
                          <a href="<?php echo home_url('myaccount/wishlist.php');?>"></a>
                        </div>
                        <?php } else { ?>
                          <div class="wishlist">
                            <a href="<?php echo home_url('myaccount/user-login.php');?>"></a>
                        </div>
                    <?php  } ?>

                  
                    <?php if(!is_cart()){ ?>
                      <div class="cart">
                        <a href="#popup-min-cart" class="js-popup-opener">
                          <div class="section_icon_cart">
                            <?php //echo WC()->cart->get_total();?>
                            <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/cart.png" alt="">
                          </div>
                        </a>
                      </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</div>
