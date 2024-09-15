<div class="sec_gallary">
  <div class="gallary">
    <div class="product-slider">
      <?php //echo get_the_post_thumbnail_url($single_product_data['main_data']->get_id()); ?>
      <?php
      if(!empty($single_product_data['images']['full'])){
        foreach($single_product_data['images']['full'] as $product_single_full_image){
          ?>          
          <img class="slider-main-img" src="<?php echo $product_single_full_image;?>" alt="<?php //echo $single_product_data['main_data']->get_name();?>" data-zoom-image="<?php //echo $product_single_full_image;?>">
          <?php
        } 
      }else{
        ?>
        <img class="slider-main-img" src="<?php echo wc_placeholder_img_src('300');?>" alt="<?php //echo $single_product_data['main_data']->get_name();?>" data-zoom-image="<?php //echo $product_single_full_image;?>">
        <?php 
      }
      ?>
    </div>
    <div class="slider-nav">
      <?php
      if(!empty($single_product_data['images']['thumb'])){
        $count = 0;
        foreach($single_product_data['images']['thumb'] as $product_single_thumb_image){
          ?>
          <img class="slider-nav-img-<?php echo $count;?>" src="<?php echo $product_single_thumb_image;?>" alt="<?php echo $single_product_data['main_data']->get_name();?>">
          <?php
          $count++;
        }
      }
      ?>
    </div>
  </div>
  <?php
  if(!empty($single_product_data['extra_data']['video_section']['video_url'])){
    ?>
    <div class="video-box js-videoWrapper">
      <div class="bg" style="background-image: url(<?php echo $single_product_data['extra_data']['video_section']['video_image'];?>);"><button class="player js-videoPlayer"></button></div>
      <div class="youtube-video">
        <iframe class="videoIframe js-videoIframe" src="<?php echo $single_product_data['extra_data']['video_section']['video_url'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
    <?php
  }
  ?>
</div>
