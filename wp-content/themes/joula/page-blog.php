<?php require_once 'header.php';?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content blog">
    <div class="section_blog">
      <div class="grid">
        <div class="section_title">
          <h2> Joula Blog List </h2>
        </div>
        <div class="blog_list">
          <?php
            $blog_posts = mitch_get_blog_posts();
            if(!empty($blog_posts)){
          ?>
          <ul class="list">
          <?php
          foreach($blog_posts as $post_obj){
            ?>
            <li class="single_blog">
              <a href="<?php echo get_the_permalink($post_obj->ID);?>" class="blog_link">
                <div class="img">
                  <img src="<?php echo get_the_post_thumbnail_url($post_obj->ID,'full');?>" alt="<?php echo $post_obj->post_title;?>">
                </div>
                <div class="text">
                  <p class="date"><?php echo date('F j, Y', strtotime($post_obj->post_date));?></p>
                  <h3 class="title"><?php echo $post_obj->post_title;?></h3>
                  <p class="read_more">READ MORE</p>
                </div>
              </a>
            </li>
            <?php } ?>
          </ul>
          <?php
        }else{
          ?> 
          <div class="alert alert-danger"> Currently No Blogs </div>
          <?php
        }
        ?>
            <div class="section_loader">
              <div class="loader"></div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
