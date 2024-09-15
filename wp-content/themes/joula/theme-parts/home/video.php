 <?php
//if(!empty($video_home_page['video_item'])){
  ?>
 <div class="video-home">
     <div class="title">
         <p><?php echo $page_content['video_title'] ;  ?></p>
         <h2><?php echo $page_content['video_subtitle'] ;  ?></h2>
     </div>
     <div class="video">
         <div class="image">
             <img
                 src="<?php echo wp_is_mobile()? $page_content['video_cover_image_mobile']:$page_content['video_cover_image'];?>" />
         </div>
         <div class="main-video">
             <iframe src="https://www.youtube.com/embed/T97G1xO0V1c?si=lTtr663zVUoje3Xm?controls=1&rel=0&loop=1"
                 title="YouTube video player" frameborder="0"
                 allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                 referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

         </div>

     </div>
 </div>
 <?php
//}
?>