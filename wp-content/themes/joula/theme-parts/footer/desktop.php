<div class="section_footer">
    <div class="grid">
        <div class="top">
            <div class="section_footer_col_three">
                <?php
                $footer_builder = get_field('footer_builder_en', 'option');

                ?>
                <div class="logo">

                    <a href="<?php echo $theme_settings['site_url']; ?>">
                        <img src="<?php echo $theme_settings['logo_white']; ?>" alt="">
                    </a>
                </div>
                <div class="small-desc">
                    <p><?php echo $footer_builder['footer_col_new']['small_description']; ?></p>
                </div>
                <?php if ($footer_builder['footer_col_new']['social_media_icons']): ?>

                    <div class="social-media">
                        <?php
                        foreach ($footer_builder['footer_col_new']['social_media_icons'] as $icon) :
                            ?>
                            <a href="<?php echo $icon['link']; ?>" target="_blank">
                                <img src="<?php echo $icon['image']; ?>" alt="">
                            </a>

                        <?php endforeach; ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="section_footer_col_one">
                <div class="section two">
                    <div class="menu">
                        <?php
                        // echo '<pre>';
                        // var_dump($footer_builder);
                        // echo '</pre>';
                        if (!empty($footer_builder['footer_col_no_1']['items'])) {
                            ?>
                            <ul class="single_menu">
                                <li><h5><?php echo $footer_builder['footer_col_no_1']['title']; ?></h5></li>
                                <?php
                                foreach ($footer_builder['footer_col_no_1']['items'] as $item_obj) {
                                    if ($item_obj['type'] == 'page') {
                                        $item_title = '';
                                        $item_url = $item_obj['page'];
                                    } elseif ($item_obj['type'] == 'category') {
                                        $item_title = $item_obj['category']->name;
                                        $item_url = home_url('/product-category/' . $item_obj['category']->slug);
                                    }
                                    if (!empty($item_obj['custom_title'])) {
                                        $item_title = $item_obj['custom_title'];
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo $item_url; ?>">
                                            <?php echo $item_title; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        if (!empty($footer_builder['footer_col_no_2']['items'])) {
                            ?>
                            <ul class="single_menu">
                                <li><h5><?php echo $footer_builder['footer_col_no_2']['title']; ?></h5></li>
                                <?php
                                if (!empty($footer_builder['footer_col_no_2']['items'])) {
                                    foreach ($footer_builder['footer_col_no_2']['items'] as $item_obj) {
                                        if ($item_obj['type'] == 'page') {
                                            $item_title = '';
                                            $item_url = $item_obj['page'];
                                        } elseif ($item_obj['type'] == 'category' && $item_obj['category']) {
                                            $item_title = $item_obj['category']->name;
                                            $item_url = home_url('/product-category/' . $item_obj['category']->slug);
                                        }
                                        if (!empty($item_obj['custom_title'])) {
                                            $item_title = $item_obj['custom_title'];
                                        }
                                        ?>
                                        <li>
                                            <a href="<?php echo $item_url; ?>">
                                                <?php echo $item_title; ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        if (!empty($footer_builder['footer_col_no_3']['items'])) {
                            ?>
                            <ul class="single_menu">
                                <li><h5><?php echo $footer_builder['footer_col_no_3']['title']; ?></h5></li>
                                <?php
                                if (!empty($footer_builder['footer_col_no_3']['items'])) {
                                    foreach ($footer_builder['footer_col_no_3']['items'] as $item_obj) {
                                        // var_dump($item_obj['page']);
                                        if ($item_obj['type'] == 'page') {
                                            $item_title = '';
                                            $item_url = $item_obj['page'];
                                        } elseif ($item_obj['type'] == 'category') {
                                            $item_title = $item_obj['category']->name;
                                            $item_url = home_url('/product-category/' . $item_obj['category']->slug);
                                        }
                                        if (!empty($item_obj['custom_title'])) {
                                            $item_title = $item_obj['custom_title'];
                                        }
                                        if (!is_user_logged_in() && strpos($item_obj['page'], 'my-account') !== false) {
                                            ?>
                                            <li>
                                                <a class="title_myaccount login js-popup-opener" href="#popup-login">
                                                    <?php echo $item_title; ?>
                                                </a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li>
                                                <a href="<?php echo $item_url; ?>">
                                                    <?php echo $item_title; ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="section_footer_col_two">
                <div class="section_info">
                    <h4><?php echo $footer_builder['footer_col_no_4']['top_section_title']; ?></h4>
                    <p><?php echo $footer_builder['footer_col_no_4']['top_section_content']; ?></p>
                </div>
                <div class="company_social">
                    <form id="subForm" action="" method="post">
                        <input type="email" name="user_email" placeholder="Enter your email address" required/>
                        <button class="btn" type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="bottom">
            <p class="copy_right">© <?php echo date('Y'); ?> Joula</p>
            <div class="mitchdesigns-logo">
                <a href="https://www.mitchdesigns.com/" target="_blank">
                    <div class="image">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/md-logo.png" alt="">
                    </div>
                    <p>Web Design by MitchDesigns</p>
                </a>
            </div>
        </div>
    </div>
</div>