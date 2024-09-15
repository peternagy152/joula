<?php
$instagram_section_details = get_field('instagram_section_details', 'options');
//if (!empty($instagram_section_details['instagram_items'])) {
    ?>
    <div class="section_instgram">
    <div class="section_title">
        <img src="<?php echo $theme_settings['theme_url']; ?>/assets/img/icons/insta.png" alt="">
        <p class="subtitle"><?php echo $page_content['instagram']['title1']; ?></p>
        <h3 class="title"><?php echo $page_content['instagram']['title2']; ?></h3>
    </div>
        <?php echo do_shortcode('[instagram-feed feed=1]'); ?>
    <div class="section_insta">
    <div class="insta_container">
    <ul class="insta_list">

    <?php
//    $instagram_response = wp_remote_get("https://graph.instagram.com/me/media?fields=id,caption&access_token=IGQWRQdFExeTZAEcWhZAcWprMHIzejlHUFd3WndXUTRjN05rZADk4UDZAmMU1wdHROTmRTREY1Q1BtaXA1b0QzdzZArU0NSOWdRcm5WTFJtMGpEeUxGZAmEwb1VkZAkJVWXluM1otVjJrT04wdXBpbjgzWk9NTVVXUHBJMkEZD");
//    if (!is_wp_error($instagram_response)) {
//        $all_gallery = wp_remote_retrieve_body($instagram_response);
//        $all_gallery = json_decode($all_gallery);
//        $count = 1 ;
//
//        foreach ($all_gallery->data as $one_data) {
//            $media_data = wp_remote_get("https://graph.instagram.com/". $one_data->id . "?fields=id,media_type,media_url,username,timestamp,caption&access_token=IGQWRQdFExeTZAEcWhZAcWprMHIzejlHUFd3WndXUTRjN05rZADk4UDZAmMU1wdHROTmRTREY1Q1BtaXA1b0QzdzZArU0NSOWdRcm5WTFJtMGpEeUxGZAmEwb1VkZAkJVWXluM1otVjJrT04wdXBpbjgzWk9NTVVXUHBJMkEZD");
//            if (!is_wp_error($media_data)) {
//                $media_data_response = wp_remote_retrieve_body($media_data);
//                $media_data_response = json_decode($media_data_response) ;
//                if($media_data_response->media_type != "IMAGE"){
//                    continue ;
//                }
//                if($count == 5)break;
//                $count++;
//
//            ?>
<!--            <div class="insta_widget">-->
<!--                <span class="bag"></span>-->
<!--                <a class="insta_widget_box" href="#popup-insta" data-item="--><?php //echo $media_data_response->id; ?><!--">-->
<!--                    <div class="img">-->
<!--                        <img src="--><?php //echo $media_data_response->media_url ; ?><!--" alt="">-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--            --><?php
//            }
//
//        }
//    }
    ?>

    <?php
    $count++;
?>
    </ul>
    </div>
    </div>
    </div>
