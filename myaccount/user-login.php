<?php
require_once '../wp-content/themes/joula/header.php';
// $page_content = get_field('about_page');
// // var_dump($page_content);
$lang = 'en';
?>
<!-- <style>

</style> -->
<div id="page" class="site">
<?php require_once '../wp-content/themes/joula/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content my-account">
        <div class="grid">
            <div class="MD-user-login">
                <div class="login-form MD-form MD-inputs">
                    <h2><?php echo Myaccount_translation('Sign_login_keyword' , $lang) ?></h2>
                    <div id="login_form_alerts" class="ajax_alerts"></div>
                    <div class="callback-message success-message  ">
                             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png"
                                alt="" class="success-icon">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png"
                                alt="" class="error-icon">
                                <div class="message-info">
                                    <p> Account Info Changed Successfully </p>
                                 </div>
                            
                    </div>
                    <form id="login_form" method="post" action="#">
                        <div class="MD-field">
                            <label for=""><?php echo Myaccount_translation('account_email' , $lang) ?><span>*</span></label>
                            <input id="login_email" type="text" name="user_email">
                        </div>
                        <div class="MD-field">
                            <label for=""><?php echo Myaccount_translation('account__password' , $lang) ?><span>*</span></label>
                            <input id="login_password" type="password" name="user_password">
                        </div>
                        <button class="MD-btn" type="submit" value=""> <?php echo Myaccount_translation('Sign_login_keyword' , $lang) ?></button>
                        <a href="<?php echo $theme_settings['site_url']; ?>/myaccount/forgot_password.php" class="forgot-password-link"><?php echo Popup('forgot_password' , $lang) ?></a>
                    </form>
                </div>
                <div class="sign-up-form MD-form">
                    <span class="new-client-label"><?php echo Myaccount_translation('Sign_new_client' , $lang) ?></span>
                    <div class="top">
                        <h2><?php echo Myaccount_translation('Sign_create_account' , $lang) ?></h2>
                        <div class="icons">
                            <ul>
                                <li><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/home.png" alt="">
                                </li>
                                <li><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/bag.png" alt="">
                                </li>
                                <li><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/wallet.png"
                                        alt=""></li>
                            </ul>
                        </div>
                        <p> <?php echo Myaccount_translation('Sign_create_sentience' , $lang) ?></p>
                        <a class="MD-btn" href="<?php echo home_url('myaccount/user-signup.php');?>"><?php echo Myaccount_translation('Sign_create_account' , $lang) ?></a>
                    </div>
                    <div class="bottom">
                        <div class="box">
                            <div class="image"><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/truck.png" alt=""></div>
                            <p><?php echo Myaccount_translation('Sign_create_senetence2' , $lang) ?></p>
                        </div>
                        <!-- <div class="box">
                            <div class="image"><img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/truck.png" alt=""></div>
                            <p>If you already ordered as a guest before, Please create your account using the same mail to track your orders</p>
                        </div> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--end page-->
</div>
<?php require_once '../wp-content/themes/joula/footer.php';?>