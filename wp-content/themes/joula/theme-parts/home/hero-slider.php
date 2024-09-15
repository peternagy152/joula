<div class="hero_slider">
    <?php
    if (!empty($page_content['hero_section'])) {

        foreach ($page_content['hero_section'] as $slide) {
            ?>
            <a class="single_hero" style="background-image: url( '<?php if(wp_is_mobile()){ echo $slide['mobile_image'] ; }else{echo $slide['image'] ;} ?>');">
                <!-- <img src="<?php //echo $slide['image'];
                ?>" alt=""> -->
                <div class="text">
                    <h3>
                        <span><?php echo $slide['top_text']; ?></span>
                        <?php echo $slide['title']; ?>
                    </h3>
                    <!-- <p><?php //echo $slide['description'];
                    ?></p> -->
                    <button class="button-shop" onclick="location.href='<?php echo $slide['url']; ?>';">Shop Now</button>

                </div>
            </a>
            <?php
        }


    }
    ?>
</div>