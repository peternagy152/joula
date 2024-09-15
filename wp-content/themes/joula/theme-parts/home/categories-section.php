<div class="section_category">
    <!-- <div class="section_title">
    <p class="subtitle">
      <span><?php// echo $page_content['categories']['title1'];?></span>
    </p>
    <h3 class="title"><?php //echo $page_content['categories']['title2'];?></h3>
  </div> -->
    <div class="all_category">
        <?php
    $categories_list = $page_content['categories']['categories_list'];
    if(!empty($categories_list)){
      foreach($categories_list as $category_obj){
        if($category_obj['category_image']){
          $category_img = $category_obj['category_image'] ;
          ?>
        <div class="box-category">
            <a href="<?php echo get_term_link($category_obj['category']->term_id);?>" class="single_category"
                style="background-image:url(<?php echo $category_img;?>)">
            </a>
            <h5><?php echo $category_obj['category']->name;?></h5>

        </div>

        <?php 
        }
      }
    }
    ?>
    </div>
</div>