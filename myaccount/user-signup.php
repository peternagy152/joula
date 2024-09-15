<?php
require_once '../wp-content/themes/joula/header.php';
?>
<?php
$lang = 'en'; 
if(is_user_logged_in()){
    header('Location: '. home_url('my-account/overview/') );
    die();
}

?>
<div id="page" class="site">
<?php require_once '../wp-content/themes/joula/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content my-account">
        <div class="grid">
            <div class="MD-user-signup">
                <h2><?php echo Myaccount_translation('Sign_create_account' , $lang) ?> </h2>
                <div class="form-content">
                    <div id="register_form_alerts" class="ajax_alerts"></div>
                    <form id="register_form" action="#" method="post" class="MD-inputs">
                        <div class="MD-field half_full">
                            <label for=""><?php echo Myaccount_translation('account_first_name' , $lang);?><span>*</span></label>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="MD-field half_full">
                            <label for=""><?php echo  Myaccount_translation('account_last_name' , $lang);?><span>*</span></label>
                            <input type="text" name="last_name" required>
                        </div>
                        <div class="MD-field">
                            <label for=""><?php echo  Myaccount_translation('account_email' , $lang);?><span>*</span></label>
                            <input type="email" name="user_email" required>
                        </div>
                        <div class="MD-field">
                            <label for=""><?php echo  Myaccount_translation('account_mobile' , $lang);?><span>*</span></label>
                            <input type="text" name="phone_number" required>
                        </div>
                        <div class="MD-field">
                            <label><?php echo  Myaccount_translation('account__password' , $lang);?></label>
                            <input type="password" name="user_password" required>
                        </div>
                        <div class="MD-field">
                            <label><?php echo Myaccount_translation('account_birthdate' , $lang);?></label>
                            <div class="selecting">
                                <select name="day" id="day" required>
                                <option value="" disabled selected ><?php echo Myaccount_translation('account_Day' , $lang);?></option>
                                        <?php for ($x = 1; $x <= 31; $x++) { ?>
                                        <option   value="<?php echo $x ?>"> <?php echo $x ?> </option>
                                        <?php  } ?>
                                </select>
                                <select name="month" id="month" required>
                                <option value="" disabled selected><?php echo Myaccount_translation('account_Month' , $lang);?></option>
                                        <?php 
                                        Call_Month_Global_Array($lang) ;
                                        global $month_array ;
                                         ?>
                                        <?php for ($x = 0; $x < count($month_array); $x++) { ?>
                                        <option  value="<?php echo $month_array[$x]; ?>"> <?php echo $month_array[$x]; ?></option>
                                        <?php } ?>
                                </select>
                                <select name="year" id="year" required >
                                <option value="" disabled selected><?php echo Myaccount_translation('account_Year' , $lang);?></option>
                                        <?php for ($x = 1990; $x <= 2016; $x++) { ?>

                                        <option  value="<?php echo $x ?>"> <?php echo $x ?> </option>
                                        <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="MD-field">
                            <label><?php echo  Myaccount_translation('account_gender' , $lang);?></label>
                            <div class="radio-buttons">
                                <div class="single-radio">
                                    <input  checked value = "M" type="radio" name="gender" id="">
                                    <label for="male"><?php echo  Myaccount_translation('account_gender_male' , $lang);?></label>
                                </div>
                                <div class="single-radio">
                                    <input value = "F" type="radio" name="gender" id="">
                                    <label for="female"><?php echo  Myaccount_translation('account_gender_female' , $lang);?></label>
                                </div>

                            </div>
                        </div>
                        <!-- <div class="MD-field checkbox">
                            <input type="checkbox" name="" id="">
                            <label>Agree on <a href="<?php //echo home_url('terms-and-conditions');?>">terms & conditions</a></label>

                        </div> -->

                        <button type="submit" class="MD-btn"
                            value=""><?php echo Myaccount_translation('account_register' , $lang);?></button>
                    </form>


                </div>
                <p class="link">
                    <span><?php echo Myaccount_translation('account_aready_have' , $lang);?> </span>
                    <a href="<?php echo home_url('myaccount/user-login.php');?>" class="login-link"> <?php echo Myaccount_translation('Sign_login_keyword' , $lang);?></a>
                </p>
            </div>
        </div>
    </div>
</div>
<!--end page-->
</div>
<?php require_once '../wp-content/themes/joula/footer.php';?>
