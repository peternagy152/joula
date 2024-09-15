
<?php $lang = 'en'; ?>
<?php if(wp_is_mobile()) { ?>

<?php
if( 'myaccount' == basename($_SERVER['REQUEST_URI'] )) 
{
        $currnt_active = "Overview" ;
} else if('addresses.php' == basename($_SERVER['REQUEST_URI'])){
        $currnt_active = "Shipping Address" ;
} else if('my-wallet.php' == basename($_SERVER['REQUEST_URI'])){
        $currnt_active = "My Wallet" ;
}else if('wishlist.php' == basename($_SERVER['REQUEST_URI'])) {
        $currnt_active = "My Wishlist" ;
}else if('orders-list.php' == basename($_SERVER['REQUEST_URI'])){
        $currnt_active = "Orders & Returns" ;
}else if('profile.php' == basename($_SERVER['REQUEST_URI'])){
        $currnt_active = "Account Info" ;
}else{
        $currnt_active = "Orders & Returns" ;
}



?>


<div class="myaccount_menu mobile">
        <?php $currnt_active ?>
    <div class="txt header_title_text"><span><?php echo $currnt_active ?></span></div>
    <div class="select_view">
    <li class="<?php if('myaccount' == basename($_SERVER['REQUEST_URI'])){echo "active" ; $currnt_active = Myaccount_translation('myaccount_page_sidebare_overview' , $lang) ; } ?>"><a
                href="<?php echo home_url('myaccount/');?>"><?php echo Myaccount_translation('myaccount_page_sidebare_overview', $lang);?></a>
        </li>
        <li class="<?php if('addresses.php' == basename($_SERVER['REQUEST_URI'])){echo "active" ; $currnt_active = Myaccount_translation('myaccount_page_sidebare_address' , $lang);  } ;?>"><a
                href="<?php echo home_url('myaccount/addresses.php');?>"><?php echo Myaccount_translation('myaccount_page_sidebare_address' , $lang);?></a>
        </li>
        <!-- <li class="<?php // if('my-wallet.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php // echo home_url('myaccount/my-wallet.php');?>"> <?php // echo Myaccount_translation('wallet_title' , $lang) ?></a>
        </li> -->
        <li class="<?php if('wishlist.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php echo home_url('myaccount/wishlist.php');?>"> <?php echo Myaccount_translation('wishlist_page_title' , $lang) ?></a></li>

        <li
            class=" <?php if('orders-list.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?> <?php if('order-details.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0] || 'return-products.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0]  ) echo "active ";?>">
            <a
                href="<?php echo home_url('myaccount/orders-list.php');?>"> <?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $lang) ?></a>
        </li>
        <li class="<?php if('profile.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?>"><a
                href="<?php echo home_url('myaccount/profile.php');?>"> <?php echo Myaccount_translation('myaccount_page_sidebare_home', $lang) ?></a>
        </li>
        <li class="logout">
        <a href="<?php echo wp_logout_url(home_url());?>"> <?php echo Myaccount_translation('myaccount_page_sidebare_logout', $lang) ?></a> </li>


    </div>

</div>
<?php } else { ?>
        <div class="myaccount_menu desktop">
    <ul>
        <li class="<?php if('myaccount' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php echo home_url('myaccount/');?>"><?php echo Myaccount_translation('myaccount_page_sidebare_overview', $lang);?></a>
        </li>
        <li class="<?php if('addresses.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php echo home_url('myaccount/addresses.php');?>"><?php echo Myaccount_translation('myaccount_page_sidebare_address', $lang);?></a>
        </li>
        <!-- <li class="<?php// if('my-wallet.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php //echo home_url('myaccount/my-wallet.php');?>"><?php //echo Myaccount_translation('wallet_title', $lang) ?></a>
        </li> -->
        <li class="<?php if('wishlist.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php echo home_url('myaccount/wishlist.php');?>"> <?php echo Myaccount_translation('wishlist_page_title', $lang) ?></a></li>

        <li
            class=" <?php if('orders-list.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?> <?php if('order-details.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0] || 'return-products.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0]  ) echo "active ";?>">
            <a
                href="<?php echo home_url('myaccount/orders-list.php');?>"> <?php echo Myaccount_translation('myaccount_page_sidebare_orders', $lang) ?></a>
        </li>
        <li class="<?php if('profile.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?>"><a
                href="<?php echo home_url('myaccount/profile.php');?>"><?php echo Myaccount_translation('myaccount_page_sidebare_home', $lang) ?></a>
        </li>

    </ul>
    <ul>
        <p>Need Help?</p>
        <li><a href="<?php echo home_url('faqs');?>"> <?php echo Myaccount_translation('myaccount_page_sidebar_faq', $lang) ?></a>
        </li>
        <li><a href="<?php echo home_url('contact-us');?>"> <?php echo Myaccount_translation('myaccount_page_sidebar_contact_us', $lang) ?></a>
        </li>

        <li class="logout"><a href="<?php echo wp_logout_url(home_url());?>"> <?php echo Myaccount_translation('myaccount_page_sidebare_logout', $lang) ?></a>
        </li>
    </ul>
</div>
<?php }  ?>


<div class="overlay-mobile"></div>