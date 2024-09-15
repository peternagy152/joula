<div class="repeater_banners">
    <div class="content">
    <?php
        if(!empty($page_content['repeater_banners'])){
        foreach($page_content['repeater_banners'] as $slide){
        ?>
        <a class="single_content" href="<?php echo $slide['url'];?>">
            <img src="<?php echo $slide['image'];?>" alt="">
        </a>
        <?php 
        }
    } 
    ?>
    </div>
</div>