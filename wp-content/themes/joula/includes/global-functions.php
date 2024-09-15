<?php
$wishlist_remove= '';
$theme_settings = mitch_theme_settings();
if(!empty($theme_settings['theme_abs_url'])){
	require_once $theme_settings['theme_abs_url'].'languages/'.$theme_settings['current_lang'].'.php';
}
function mitch_get_number_name($number){
  $numbers_names_list = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten');
  return $numbers_names_list[$number];
}

function mitch_theme_settings(){
  $currency_symbol = get_woocommerce_currency(); //_symbol
  // if($currency_symbol == 'ر.ق'){
  //   $currency_symbol = 'QAR';
  // }
  $theme_abs_url = '';
  $my_theme      = wp_get_theme();
  if(!empty($my_theme)){
	$theme_name = $my_theme->get('TextDomain');
	if(!empty($theme_name)){
		$theme_abs_url = preg_replace('/wp-content.*$/','',__DIR__).'wp-content/themes/'.$theme_name.'/';
	}
  }
  return array(
    'site_url'                => site_url(),
    'theme_url'               => get_template_directory_uri(),
    'theme_abs_url'           => $theme_abs_url,
    'logo_black'              => get_field('logo', 'options'),
	'logo_white'              => get_field('logo_white', 'options'),
    'theme_favicon'           => get_field('fav_icon', 'options'),
    'theme_favicon_black'     => get_field('fav_icon_black', 'options'),
    'current_lang'            => 'en',
    'current_currency'        => $currency_symbol,
    'default_country_code'    => 'EG',
    'default_country_name'    => 'Egypt',
    'default_shipping_method' => 'filters_by_cities_shipping_method',
  );
}
function mitch_test_vars($vars){
  echo '<h2 style="direction:ltr;background: #222;color: #fff;border: 2px solid #fff;padding: 5px;margin: 5px;">Data Debug:</h2>';
  if(is_array($vars)){
    foreach($vars as $var){
      echo '<pre style="direction:ltr;background: #222;color: #fff;border: 2px solid #fff;padding: 5px;margin: 5px;">';
      var_dump($var);
      echo '</pre>';
    }
  }else{
    echo '<pre style="direction:ltr;background: #222;color: #fff;border: 2px solid #fff;padding: 5px;margin: 5px;">';
    var_dump($vars);
    echo '</pre>';
  }
}

function mitch_get_active_page_class($page_name){
  if($page_name == basename(get_permalink())){
    return 'active';
  }
}

function mitch_validate_logged_in(){
  if(!is_user_logged_in()){
    wp_redirect(home_url());
    exit;
  }
}
add_action('wp_ajax_nopriv_custom_search', 'custom_search');
add_action('wp_ajax_custom_search', 'custom_search');
function custom_search(){	$lang = $_POST['lang'];
	$s = $_POST['s'];
	global $language;
	if($lang == '_en') {
		$language = 'en';
	}
	
  global $theme_settings;
  $new_prods1 = Search_By_Product_Name($s , '10');
	if($new_prods1->have_posts()):
		while ($new_prods1->have_posts()) :
			$new_prods1->the_post();
            $product_id = get_the_ID();
			if(!empty($product_id)){
          global $product_data;
          $product_data = mitch_get_short_product_data($product_id);
		include get_template_directory().'/theme-parts/product-widget.php';
          ?>
<!-- <li id="product_<?php echo $product_id;?>_block" class="product_widget">
              <a href="<?php echo get_the_permalink($product_id);?>" class="product_widget_box">
                <div class="img">
                    <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail')[0];?>" alt="">
                </div>
                <div class="text">
                  <div class="sec_info">
                      <h3 class="title"><?php echo get_the_title($product_id);?></h3>
                      <p class="price"><?php echo get_post_meta($product_id, '_price', true);?> <?php echo $theme_settings['current_currency'];?></p>
                  </div>
                </div>
              </a>
          </li> -->
<?php
			}
		endwhile; wp_reset_postdata();
	else: global $language;?>
<sec class="emty_filter">
    <p> <?php echo ($language=="en")? 'No results found' : 'No results' ; ?></p>
</sec>
<?php endif;
wp_die();
}

add_action('wp_ajax_nopriv_mitch_get_insta_content', 'mitch_get_insta_content');
add_action('wp_ajax_mitch_get_insta_content', 'mitch_get_insta_content');
function mitch_get_insta_content()
{
    global $theme_settings;
    $item_id = intval($_POST['insta_item']);
    $media_data = wp_remote_get("https://graph.instagram.com/" .$item_id . "?fields=id,media_type,media_url,username,timestamp,caption&access_token=IGQWRQdFExeTZAEcWhZAcWprMHIzejlHUFd3WndXUTRjN05rZADk4UDZAmMU1wdHROTmRTREY1Q1BtaXA1b0QzdzZArU0NSOWdRcm5WTFJtMGpEeUxGZAmEwb1VkZAkJVWXluM1otVjJrT04wdXBpbjgzWk9NTVVXUHBJMkEZD");
    if (!is_wp_error($media_data)) {
        $media_data_response = wp_remote_retrieve_body($media_data);
        $media_data_response = json_decode($media_data_response);
        ?>
        <div class="insta-popup-content">
            <div class="content">
                <div class="hero_img">
                    <img src="<?php echo $media_data_response->media_url ; ?>">
                </div>
                <div class="sec_gallary">
                    <div class="title">
                        <h4>InstaShop</h4>
                        <p>In This Look</p>
                    </div>
                    <div class="text">
                        <p><?php echo $media_data_response->caption ; ?></p>
                        <a href="www.instagram.com">
                            <ul>
                                <li>
                                    <?php "Click Here" ?>
                                </li>
                                <li>Instagram</li>
                                <?php  $date = new DateTime($media_data_response->timestamp); ?>
                                <li>
                                    <?php echo $date->format('j F Y'); ; ?>
                                </li>
                            </ul>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    wp_die();
}

function mitch_campaign_monitor_add_subscriber_birthday($user_name, $user_email, $user_birthday){
  $auth        = array('api_key' => 'dYEwki21Oyod/9c+JqTlzMkTSf8HUytCMOjsjor9PS9NTY2M4FTItmYuGwQY5O30C32xxPFxj1YDjIeNIQwGteF9qlS1kmouXtZshOkC7QXsH/R9CiXxLwxVPusuFHOnmsPtqaKl3eTEyhDOMjuemg==');
  $api_list_id = 'fb97192bdb8805924e5ba885116e02e5';
  $create_subscriber_class = new CS_REST_Subscribers($api_list_id, $auth);
  $subscriber_data         = array(
    'EmailAddress' => $user_email,
    'Name'         => $user_name,
    'CustomFields' => array(
      array(
        'Key'   => 'BirthDay',
        'Value' => $user_birthday,
        'Clear' => false,
      )
    ),
    'ConsentToTrack' => 'yes'
  );
  $create_subscriber_opt   = $create_subscriber_class->add($subscriber_data);
  if(isset($create_subscriber_opt->http_status_code)){
    $code = $create_subscriber_opt->http_status_code;
  }elseif(isset($create_subscriber_opt->Code)){
    $code = $create_subscriber_opt->Code;
  }else{
    $code = 401;
  }
  return $code;
}

function mitch_campaign_monitor_add_subscriber($user_email){
  $auth                    = array('api_key' => '8Eym/4zx8FueYOOwtka/MO7PC6V5xedmsCpOfJP95EvPBH7NLtJcr+hGny/JFKGXE0NQDBi+Fi4qWyBciqQHY9d1m2D90XEm1QLy2HpqOJkkjMWcEfNIFrp7Fq81c3gRj+i9bX5hYhPHzA7CH6PIzA==');
  $api_list_id = "b9b59de6763f2a0c4c8dc9b4b73ed737" ;
  $create_subscriber_class = new CS_REST_Subscribers($api_list_id, $auth);
  $subscriber_data         = array(
    'EmailAddress' => $user_email,
    //'Name'         => $user_name,
    'ConsentToTrack' => 'yes'
  );
  $create_subscriber_opt   = $create_subscriber_class->add($subscriber_data);
  if(isset($create_subscriber_opt->http_status_code)){
    $code = $create_subscriber_opt->http_status_code;
  }elseif(isset($create_subscriber_opt->Code)){
    $code = $create_subscriber_opt->Code;
  }else{
    $code = 401;
  }
  return $code;
}



add_action('wp_ajax_mitch_newsletter_add_to_list', 'mitch_newsletter_add_to_list');
add_action('wp_ajax_nopriv_mitch_newsletter_add_to_list', 'mitch_newsletter_add_to_list');
function mitch_newsletter_add_to_list(){
    $post_form_data  = $_POST[form_data];
    parse_str($post_form_data, $form_data);
    mitch_campaign_monitor_add_subscriber($form_data['user_email']) ;

}