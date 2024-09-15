<header>
    <div class="section_header checkout">
        <div class="section_header_col_one">
          <div class="grid">
              <div class="section_top">
                    <!-- <div class="dropdown_select">
                        <a href="#popup-switch-language" class="switch_language js-popup-opener">
                            <div class="sec_lang">
                                <img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/flag/eng.png" alt="">
                                <span class="lang text">English </span>
                                <strong class="text">(USD)</strong>
                            </div>
                        </a>
                    </div> -->
                    <div class="logo">
                        <!-- <a href="<?php //echo $theme_settings['site_url'];?>">
                            <img src="<?php //echo $theme_settings['theme_logo'];?>" alt="">
                        </a> -->
                        <a href="<?php echo $theme_settings['site_url'];?>">
                            <img src="<?php echo $theme_settings['logo_black'];?>" alt="">
                        </a>
                    </div>
                    <div class="cart">
                        <a href = "<?php  echo home_url('/cart')?>"  class="">
                        <div class="section_icon_cart">
                        <?php //echo WC()->cart->get_total();?>
                            <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/new-icons/cart.png" alt="">
                        </div>
                        </a>
                    </div>
              </div>
            </div>
        </div>
    </div>
</header>
