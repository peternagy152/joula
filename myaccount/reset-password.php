<?php
require_once '../wp-content/themes/joula/header.php';
global $theme_settings ;
$lang = 'ar' ;

?>



<div id="page" class="site">
    <?php require_once '../wp-content/themes/joula/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">

            <div class="page_content">
            <?php
                if(isset($_POST['change_password'])){

               
                if(empty($user_email) || empty($key)){
                    ?>
                    <div class=" callback-message error-message show-message  ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png"
                        alt="" class="error-icon">
                    <p> <?php echo Myaccount_translation('Reset_no_parameters' , $lang )  ?>  </p>
                    </div>
                    <?php 
                }else{
                    
                $user_email = $_GET['email'];
                $sanitized_user_email = str_replace('/','',$user_email );
                $user = get_user_by('email', $sanitized_user_email);
                $key = $_GET['key'];
                $stored_key = get_user_meta($user->ID, 'reset_password_key', true);
                $stored_time = get_user_meta($user->ID, 'reset_password_time', true);
                //echo 'stored_key is : ' . $stored_key ; 
                if($key === $stored_key && time() - $stored_time < 3600){
                    $new_password = $_POST['new_password'];
                    wp_set_password($new_password, $user->ID);
                    delete_user_meta($user->ID, 'reset_password_key');
                    delete_user_meta($user->ID, 'reset_password_time');
                    ?>
                    <div class=" callback-message success-message show-message  ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/star.png"
                        alt="" class="success-icon">

                    <p>  <?php echo Myaccount_translation('Reset_success_reset' , $lang )  ?>  </p> <a href=" <?php  echo $theme_settings['site_url']; ?>/myaccount/user-login.php " >  <?php echo Myaccount_translation('Reset_login_link' , $lang )  ?> </a>.
                    </div>
                    
                    <?php
                }else{
                    ?>
                    <div class=" callback-message error-message show-message  ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new_icons/warning.png"
                        alt="" class="error-icon">
                    <p>  <?php echo Myaccount_translation('Reset_invalid' , $lang )  ?>  </p>
                    </div>
                    <?php 
                    
                }
            }
                }
?>
                <div class="forgot-password">
                        <h4> <?php echo Myaccount_translation('Reset_password_reset' , $lang )  ?>  </h4>

                        <form class="MD-inputs" action="#" method="post">
                            <div class="MD-field ">
                            <label for="new_password"><?php echo Myaccount_translation('Reset_forgot' , $lang )  ?>:</label>
                            <input type="password" name="new_password" id="new_password" required>
                            </div>

                            <input type="submit" name="change_password" value="<?php echo Myaccount_translation('Reset_change_password' , $lang) ?>">
                            <!-- <button type="submit" class="MD-btn">Reset Password</button> -->
                        </form>


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