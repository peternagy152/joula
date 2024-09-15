<?php 


add_action('wp_ajax_change_category_selected', 'change_category_selected');
add_action('wp_ajax_nopriv_change_category_selected', 'change_category_selected');
function change_category_selected(){

    $category_id = $_POST['category_id'];
    //Check if it Number Or Charachters 
    if($category_id == 'arrivals')
    {
      $category_products_ids = mitch_get_new_arrival_products_ids(6);
    }
    else if($category_id == 'best')
    {
      $category_products_ids = mitch_get_best_selling_products_ids(8);
      shuffle($category_products_ids);


    } else if($category_id == 'featured'){
      $category_products_ids = mitch_get_featured_product_ids(6);
      //var_dump($category_products_ids);

    } else {
      $category_products_ids = mitch_get_products_by_category($category_id,'' , '');
      shuffle($category_products_ids);
    }
    
    $Max = 6 ;
    $counter = 0;


    $trending_product = '<div class="products_list"> ';
    foreach($category_products_ids as $product_id){
      $counter++;
      if($counter > $Max) 
      break;
      
      $product_data = mitch_get_short_product_data($product_id);
      $trending_product = $trending_product . '
      <div id = "product_' . $product_data['product_id'] .'_block" class = "product_widget"> ';
      if(mitch_check_wishlist_product(get_current_user_id(), $product_data['product_id'])){ 
        $trending_product = $trending_product . '<span class = "fav_btn favourite" onclick="remove_product_from_wishlist('.  $product_data['product_id'] . ' , ' .  $wishlist_remove . ' );"> </span>';
      }
      else {
        $trending_product = $trending_product . '<span class = "fav_btn not-favourite" onclick="add_product_to_wishlist('.  $product_data['product_id'] . ');"> </span>';
      }
      $trending_product = $trending_product . '<span class="label new">new</span>
      <a class="product_widget_box" href=' .  $product_data['product_url'] . ' > 
      <div class = "img' ;
      if($product_data['product_flip_image']){
        $trending_product = $trending_product . 'has-flip' ;
      }
      $trending_product = $trending_product . ' "> 
      <img class = "original" src =" ' .$product_data['product_image']. ' " alt ="" >  ' ;
      if(!empty($product_data['product_flip_image'])){
        $trending_product = $trending_product . ' <img class = "flip" src = " '. $product_data['product_flip_image'] . ' alt = "" ';
      }
      $trending_product = $trending_product . '</div>' ;
      $trending_product = $trending_product . '
      <div class = "sec_info">
      <h3 class = "title"> ' .  $product_data['product_title'] . ' </h3> 
      <p class = "price" > ' . number_format($product_data['product_price']) . ' EGP
      </p>  
      </div>
      </a> 
      </div>
       ' ;

    }
    $trending_product = $trending_product . '</div>' ;


    $response = array(
        'status'       => 'success',
        'trending_product' => $trending_product,
      );
      echo json_encode($response);
      wp_die();
}


?>
