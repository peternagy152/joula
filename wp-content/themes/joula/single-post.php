<?php
require_once 'header.php';
global $post;
$post_details = get_field('post_details', $post->ID);
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content blog">
    <div class="section_single_blog">
     
      <div class="content_single_blog">
        <div class="grid">
            <ul class="breadcramb">
              <li>
                <a href="<?php echo $theme_settings['site_url'];?>">Home</a>
              </li>
              <li>
                <a href="<?php echo home_url('blog');?>">Blog</a>
              </li>
              <li>
                <a href="#"><?php echo $post->post_title;?></a>
              </li>
            </ul>
          <div class="section_title">
            <p class="date"><?php echo date('F j, Y', strtotime($post->post_date));?></p>
            <h3 class="title"><?php echo $post->post_title;?></h3>
          </div>
        </div>

        <?php if(isset($post_details['cover_image'])){ ?>
          <div class="grid_hero_img">
              <img src="<?php echo $post_details['cover_image'];?>" alt="">
          </div>
        <?php } ?>

        <div class="grid">
          <div class="content">
            <?php if(isset($post_details['second_image'])){ ?>
              <img src="<?php echo $post_details['second_image'];?>" alt="">
            
              <?php } if(isset($post_details[' content_section_1'])){ ?>
                <div class="content">
                  <?php echo $post_details['content_section_1'];?>
                </div>
              <?php } if(isset($post_details['content_section_2'])){ ?>
              <div class="content">
                <?php echo $post_details['content_section_2'];?>
              </div>
              <?php } if(isset($post_details['video_image'])){ ?>
              <div class="video-box js-videoWrapper">
                <div class="bg" style="background-image: url('<?php echo $post_details['video_image'];?>');"><button class="player js-videoPlayer"></button></div>
                <div class="youtube-video">
                  <iframe class="videoIframe js-videoIframe" src="<?php echo $post_details['video_url'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
              </div>
              <?php
            }
            if(isset($post_details['content_section_3'])){
              ?>
              <div class="content">
                <?php echo $post_details['content_section_3'];?>
              </div>
              <?php
            }
            ?>
            <div class="content">
              <?php the_content();?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
