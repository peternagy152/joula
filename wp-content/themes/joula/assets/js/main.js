window.onload = function () {
    $('.page_home .box_gift').addClass('start');
};

$(".video-home .image").click(function () {
    var $this = $(this); // Store the reference to $(this) in a variable
    setTimeout(() => {
        $this.addClass('hide'); // Use the stored reference
    }, 300);

    $(".main-video iframe")[0].src += "&autoplay=1";
})


$(document).mouseup(function (e) {
    var browser = $('.MD-menu');
    if (!browser.is(e.target) && browser.has(e.target).length === 0 && $('.MD-menu').hasClass('active')) {
        browser.removeClass('active');
    }
});
$(document).ready(function () {


    $(window)
        .on("resize", function () {
            var HeaderFooter =
                $("header").innerHeight() + $("footer").innerHeight();
            $(".site-content").css({
                "min-height": $(window).outerHeight() - HeaderFooter,
            });
            // console.log('HeaderFooter',HeaderFooter);
        })
        .resize();

    // Top slider 


    $(".top-slider").slick({
        // autoplay: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        speed: 800,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        // responsive: [
        //     {
        //         breakpoint: 767,
        //         settings: {
        //             arrows: false,
        //         }
        //     },
        // ],
    });

    $(".sec_product_details .product_details .content_info").each(function () {
        if ($(this).height() > 300) {
            $(this).addClass("scroll_desc");
        }
    });

    $(".exstra_link").slick({
        autoplay: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        speed: 800,
        fade: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                }
            },
        ],
    });

    //start slick single_item //

    mqList = window.matchMedia("(max-width:999px)");
    if (mqList.matches) {
        $(".product-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            // // infinite: true,
            // fade: false,
            nextArrow: '<div class="next-arrow"><span></span></div>',
            prevArrow: '<div class="prev-arrow"><span></span></div>',
            responsive: [
                {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false,
                        // fade: true,
                        // speed: 800,
                        // customPaging: function (slider, i) {
                        //     return  (i + 1) + '/' + slider.slideCount;
                        // }
                    }
                },
            ],
        });

        $(".slider-nav").slick({
            slidesToShow: 7,
            slidesToScroll: 1,
            asNavFor: ".product-slider",
            dots: false,
            arrows: true,
            centerMode: false,
            vertical: true,
            verticalSwiping: true,
            focusOnSelect: false,
            infinite: false,
            autoplay: false,
            responsive: [{
                breakpoint: 999,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: false,
                    // verticalSwiping: false,
                }
            },
            ]
        });
    }




    $('.slider-nav .slick-slide').on('click', function (event) {
        $('.slider-nav .slick-slide').removeClass('active');
        $('.product-slider').slick('slickGoTo', $(this).data('slickIndex'));
        $(this).addClass('active');
    });
    $('.product-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        $('.slick-current img').addClass('active');
        $('.slick-current img').removeClass('zoomm');
    });
    $(window).on("load", function () {
        $(".product-slider").addClass("active");
        $(".slider-nav img:nth-child(1)").addClass("active");
        $(".products-slider").addClass("active");
        $(".product_widget .image").addClass("active");
    });


    $(".single_page .sec_info .content_description").each(function () {
        if ($(this).height() > 160) {
            $(this).addClass("more");
        }
    });
    $(document).on('click', '.single_page .sec_info .content_description .more', function () {
        $(this).addClass("hidee");
        $(this).next().removeClass("hidee");
        $('.content_description').addClass('show_more');
    });
    $(document).on('click', '.single_page .sec_info .content_description .less', function () {
        $(this).addClass("hidee");
        $(this).prev().removeClass("hidee");
        $('.content_description').removeClass('show_more');
    });

    if (window.location.href.indexOf("product-category") > -1) {
        $(window).scroll(function () {
            // var sticky = $(".sticky"),
            scroll = $(window).scrollTop();

            if (scroll >= 200)
                //   sticky.addClass("fixed"),
                $("body").addClass("sticky-header"),
                    $(".dgwt-wcas-suggestions-wrapp").addClass("scrolled"),
                    $(".filter-tab").addClass("top");
            else
                //   sticky.removeClass("fixed"),
                $("body").removeClass("sticky-header"),
                    $(".dgwt-wcas-suggestions-wrapp").removeClass("scrolled"),
                    $(".filter-tab").removeClass("top");
        });
    }
    $(".hero_slider").slick({
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        infinite: true,
        speed: 800,
        fade: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    dots: true,
                }
            },
        ],
    });

    // $(".home .products_list").slick({
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     arrows: true,
    //     infinite: false,
    //     speed: 800,
    //     nextArrow: '<div class="next-arrow"><span></span></div>',
    //     prevArrow: '<div class="prev-arrow"><span></span></div>',
    //     responsive: [
    //         {
    //             breakpoint: 800,
    //             settings: "unslick"

    //         },
    //     ],
    // });
    $(".reviews").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        speed: 800,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 2,
                }

            },
            {
                breakpoint: 800,
                settings: "unslick"

            },
        ],
    });

    $(".section_instgram .insta_list").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        speed: 800,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                    slidesToShow: 1.5,
                }

            },
        ],
    });

    $(".product_widget_box .sec_slider_img").slick({
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        speed: 800,
        dots: true,
        nextArrow: '<div class="next-arrow"><span></span></div>',
        prevArrow: '<div class="prev-arrow"><span></span></div>',
    });


    //End slick single_item //

    //start dropdown_info //
    $(document).on('click', '.dropdown_info_mobile .single_info .title_info', function () {
        $('.dropdown_info_mobile .single_info').removeClass('active');
        $(this).parent().addClass('active');
    });
    $(document).on('click', '.dropdown_info_mobile .single_info.active .title_info', function () {
        $(this).parent().removeClass('active');
        $('.dropdown_info_mobile .single_info').removeClass('active');
    });


    // $(document).on('click', '.single_footer .title_footer', function () {
    //     $('.single_footer').removeClass('active');
    //     $(this).parent().addClass('active');
    // });
    // $(document).on('click', '.single_footer.active .title_footer', function () {
    //     $(this).parent().removeClass('active');
    //     $('.single_footer').removeClass('active');
    // });

    $(document).on('click', '.single_footer .title_footer:not(.active)', function () {
        $('.title_footer').removeClass('active');
        $('.content_footer').slideUp();

        $(this).next().slideDown();
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.single_footer .title_footer.active', function () {
        $('.content_footer').slideUp();
        $(this).removeClass('active');
        return false;
    });
    //End dropdown_info //

    $(document).on('click', '.dropdown_info .title_info:not(.active)', function () {
        $('.title_info').removeClass('active');
        $('.content_info').slideUp();

        $(this).next().slideDown();
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.dropdown_info .title_info.active', function () {
        $('.content_info').slideUp();
        $(this).removeClass('active');
        return false;
    });

    //start select size //
    $(document).on('click', '.size .single_size', function () {
        $('.single_size').removeClass('active');
        $(this).addClass('active');
    });


    //End  select size //
    $(document).on('click', '.size .single_color', function () {
        $('.single_color').removeClass('active');
        $(this).addClass('active');
    });
    //start select info //
    $(document).on('click', '.section_info .info .single_info', function () {
        $('.single_info').removeClass('active');
        $(this).addClass('active');
    });
    //End  select info //


    //start open coupon //
    $(document).on('click', '.page_cart .open-coupon', function () {
        $('.page_cart .discount-form').addClass('active');
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.page_cart .close-coupon', function () {
        $('.page_cart .discount-form').removeClass('active');
        $('.page_cart .open-coupon').removeClass('active');
        return false;
    });

    $(document).on('click', '.min_cart .open-coupon', function () {
        $('.min_cart .discount-form').addClass('active');
        $(this).addClass('active');
        $('.all_item').addClass('height');
        return false;
    });

    $(document).on('click', '.min_cart .close-coupon', function () {
        $('.min_cart .discount-form').removeClass('active');
        $('.min_cart .open-coupon').removeClass('active');
        $('.all_item').removeClass('height');
        return false;
    });

    $(document).on('click', '.checkout-content .open-coupon', function () {
        $('.checkout_coupon').addClass('active');
        $(this).addClass('active');
        return false;
    });

    $(document).on('click', '.checkout-content .close-coupon', function () {
        $('.checkout_coupon').removeClass('active');
        $('.open-coupon').removeClass('active');
        $(this).removeClass('active');
        return false;
    });

    //End open coupon //



    //start popup //
    $(document).on('click', '.js-popup-opener', function () {
        var ths = $(this);
        var trgt = $($(this).attr('href'));
        // $(".mobile-nav").removeClass("active");
        // $('.menu_mobile_icon.close').removeClass('show');
        // $('.menu_mobile_icon.open').removeClass('hide');
        $('.popup').removeClass('popup_visible');
        $('html, body').css('overflow', 'hidden');
        $('#overlay').addClass('overlay_visible');
        $(".mobile-nav").removeClass("active");
        trgt.addClass('popup_visible');

        return false;
    });
    $(document).on('click', '.js-popup-closer', function () {
        $('.popup').removeClass('popup_visible');
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
        return false;
    });

    $(".overlay").on("click", function () {
        $('.popup').removeClass('popup_visible');
        $('.MD-popup').removeClass('popup_visible');
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
    });

    $(".open_login_mobile").on("click", function () {
        $(".mobile-nav").removeClass("active");
        $('.menu_mobile_icon.close').removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $("body").removeClass("no-scroll");
    });

    //End popup //

    // start menu hover //
    var hoverTimer;
    $(document).on('mouseenter', '.single_menu.has-mega', function () {
        var hotspot = $(this);
        hoverTimer = setTimeout(function () {
            $('.mega-menu').removeClass('active');
            $('#overlay_header').addClass('overlay_visible');
            hotspot.find(".mega-menu").addClass('active');
            hotspot.find(".category_link").addClass('active');

            // $('html, body').css('overflow', 'hidden');
        },);
    });
    $(document).on('mouseleave', '.single_menu.has-mega', function () {
        clearTimeout(hoverTimer);
        $('.mega-menu').removeClass('active');
        $('.category_link').removeClass('active');
        $('#overlay_header').removeClass('overlay_visible');
        // $('html, body').css('overflow', 'visible');
    });
    // End menu hover //





    // start myaccount hover //
    var hoverTimer;
    $('.my_account_list').slideUp();
    $(document).on('mouseenter', '.side_left .my_account', function () {
        hoverTimer = setTimeout(function () {
            $('.my_account_list').slideDown();
            $('.title_myaccount').addClass('active');
        }, 500);
    });

    $(document).on('mouseleave', '.side_left .my_account', function () {
        clearTimeout(hoverTimer);
        $('.my_account_list').slideUp();
        $('.title_myaccount').removeClass('active');
    });
    // End myaccount hover //

    //start dropdown faq //
    $(document).on('click', '.single_faq:not(.active) .title_faq', function () {
        $('.single_faq').removeClass('active');
        $('.single_faq .faq').slideUp(500);
        $(this).next().slideDown(500);
        $(this).parent().addClass('active');
    });
    $(document).on('click', '.single_faq.active .title_faq', function () {
        $(this).next().slideUp(500);
        $(this).parent().removeClass('active');
    });
    //End dropdown faq //


    // start page filter ///
    $(document).on('click', '.form-checkbox .category_link', function () {
        // $('.form-checkbox').removeClass('active');
        $(this).parent().addClass('active');
    });
    $(document).on('click', '.form-checkbox.active .category_link', function () {
        $(this).parent().removeClass('active');
        // $('.form-checkbox').removeClass('active');
    });
    //End page filter //


    //start reviews_form //
    $(document).on('click', '.button-submit-review:not(.active)', function () {
        $('#reviews_form').slideUp(300);
        $(this).next().slideDown(300);
        $(this).addClass('active');
    });
    $(document).on('click', '.button-submit-review.active', function () {
        $(this).next().slideUp(300);
        $(this).removeClass('active');
    });
    //End reviews_form //


    // start Mobile Nav ///
    $(document).on("click", ".menu_mobile_icon.open", function () {
        $(this).addClass('hide');
        $('.menu_mobile_icon.close').addClass('show');
        $(".mobile-nav").addClass("active");
        $('#overlay').addClass('overlay_visible');
        $('html, body').css('overflow', 'hidden');
        return false;
    });
    $(document).on("click", ".menu_mobile_icon.close", function () {
        $(this).removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $(".mobile-nav").removeClass("active");
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
        return false;
    });

    $(".overlay").on("click", function () {
        $(this).removeClass('show');
        $('.menu_mobile_icon.open').removeClass('hide');
        $(".mobile-nav").removeClass("active");
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
    });


    $(document).on("click", ".mobile-menu .menu-item-has-children:not(.active) .menu-trigger", function () {
        $(this).parent().addClass('active').siblings().removeClass('active');
        $(this).parent().find('.list_subcategory_mobile').slideDown();
        $(this).parent().find('.list_subcategory_mobile').slideDown();
        $(this).parent().closest('.menu-item-has-children').siblings().find('.list_subcategory_mobile').slideUp();
        return false;
    });

    $(document).on("click", ".mobile-menu .menu-item-has-children.active .menu-trigger", function () {
        $(this).parent().removeClass('active');
        $(this).parent().find('.list_subcategory_mobile').slideUp();
        return false;
    });


    $(document).on('click', '.section_search .icon', function () {
        // $('.form-checkbox').removeClass('active');
        $(this).parent().addClass('active');
        $(this).next().slideDown();
    });
    $(document).on('click', '.section_search.active .icon', function () {
        $(this).parent().removeClass('active');
        $(this).next().slideUp();
        // $('.form-checkbox').removeClass('active');
    });
    $(document).on('click', '.new_search .icon_search', function () {
        $('.search-popup').addClass('popup_visible');
        $('#newSearch').focus();
    });
    $(document).on('click', '.size-guide-link', function () {
        $('.popup.size_guide').addClass('popup_visible');
        $('#overlay').addClass('overlay_visible');
    });
    $(document).on('click', '.single_menu.has_menu', function () {
        $('.menu-popup').addClass('popup_visible');

    });
    $(document).on('click', '.popup .close', function () {
        $(this).parent().parent().parent().removeClass('popup_visible');
        $('html, body').css('overflow', 'visible');
    });

    $(".custom-switch p").click(function () {
        $(this).addClass("active").siblings().removeClass("active");
    });

    $(".custom-switch p#shop-tab").click(function () {
        $("#shop").addClass("active");
        $("#collections").removeClass("active");
    });

    $(".custom-switch p#collections-tab").click(function () {
        $("#collections").addClass("active");
        $("#shop").removeClass("active");
    });


    $(document).on('click', '.section_size_detalis .tabs .single_tab', function () {
        var ths = $(this);
        var trgt = $($(this).attr('href'));
        $('.sec_table').removeClass('active');
        $('.single_tab').removeClass('active');
        // $('.section_img .image').removeClass('active');
        $(this).addClass('active');
        trgt.addClass('active');

        return false;
    });

    // End Mobile Nav ///




    // Start themes Home ///
    $(document).ready(function () {
        $(".head_themes .single_themes").each(function (e) {
            if (e != 0)
                $(this).addClass('not_active');
        });
        $(".content_themes .single_content").each(function (e) {
            if (e != 0)
                $(this).addClass('not_active');
        });

        $("#next").click(function () {
            $(".head_themes .single_themes:not(.not_active)").next().removeClass('not_active').prev().addClass('not_active');
            $(".content_themes .single_content:not(.not_active)").next().removeClass('not_active').prev().addClass('not_active');
            $(".head_themes").scrollCenter(".single_themes:not(.not_active)", 300);
            return false;
        });
        $("#prev").click(function () {
            $(".head_themes .single_themes:not(.not_active)").prev().removeClass('not_active').next().addClass('not_active');
            $(".content_themes .single_content:not(.not_active)").prev().removeClass('not_active').next().addClass('not_active');
            $(".head_themes").scrollCenter(".single_themes:not(.not_active)", 300);
            return false;
        });
    });

    jQuery.fn.scrollCenter = function (elem, speed) {


        // this = #timepicker
        // elem = .active

        var active = jQuery(this).find(elem); // find the active element
        //var activeWidth = active.width(); // get active width
        var activeWidth = active.width() / 2; // get active width center

        //alert(activeWidth)

        //var pos = jQuery('#timepicker .active').position().left; //get left position of active li
        // var pos = jQuery(elem).position().left; //get left position of active li
        //var pos = jQuery(this).find(elem).position().left; //get left position of active li
        var pos = active.position().left + activeWidth; //get left position of active li + center position
        var currentscroll = jQuery(this).scrollLeft(); // get current scroll position
        var divwidth = jQuery(this).width(); //get div width
        //var divwidth = jQuery(elem).width(); //get div width
        pos = pos + currentscroll - divwidth / 2; // for center position if you want adjust then change this

        jQuery(this).animate({
            scrollLeft: pos
        }, speed == undefined ? 1000 : speed);
        return this;
    };

    // End themes Home///




    // start filter  //
    $(document).on('click', '.more-cats-action .result', function () {
        $('.more-cats-action .result').addClass('active');
        $('.more-cats-action .all_form_checkbox').addClass('active');
    });
    $(document).on('click', '.more-cats-action .result.active', function () {
        $('.more-cats-action .result').removeClass('active');
        $('.more-cats-action .all_form_checkbox').removeClass('active');
    });

    $(document).on('click', '.more-colors .result', function () {
        $('.more-colors .result').addClass('active');
        $('.more-colors .all_form_checkbox').addClass('active');
    });
    $(document).on('click', '.more-colors .result.active', function () {
        $('.more-colors .result').removeClass('active');
        $('.more-colors .all_form_checkbox').removeClass('active');
    });
    // End filter  //


    // start filter Mobile //

    $(document).on('click', '.nav_filter.hidden_overlay .icon .sort', function () {
        $(this).addClass('active');
        $('.section_ranking').slideDown();
        // $('.form-checkbox').removeClass('active');
    });
    $(document).on('click', '.nav_filter.hidden_overlay .icon .sort.active', function () {
        $(this).removeClass('active');
        $('.section_ranking').slideUp();
        // $('.form-checkbox').removeClass('active');
    });

    $(document).on('click', '.nav_filter.show_overlay .icon .sort', function () {
        $(this).addClass('active');
        $('.section_ranking').slideDown();
        // $('.form-checkbox').removeClass('active');
        $('#overlay_sort').addClass('overlay_visible');
        $('html, body').css('overflow', 'hidden');
    });
    $(document).on('click', '.nav_filter.show_overlay .icon .sort.active', function () {
        $(this).removeClass('active');
        $('.section_ranking').slideUp();
        // $('.form-checkbox').removeClass('active');
        $('#overlay_sort').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
    });

    $(document).on('click', '#popup-filter .section_action .botton_filter', function () {
        $('.popup').removeClass('popup_visible');
        $('#overlay').removeClass('overlay_visible');
        $('html, body').css('overflow', 'visible');
    });

    if ($('.sectin_filter_sticky').length) {
        var v = $('.sectin_filter_sticky').offset().top - 50;


        $(document).scroll(function () {
            // console.log($(this).scrollTop() + ' // ' + v);
            if ($(this).scrollTop() >= $('.sectin_filter_sticky').offset().top - 50) {
                $(".section_filter_mobile").addClass("sticky");
                $(".nav_filter").removeClass("hidden_overlay");
                $(".nav_filter").addClass("show_overlay");
            } else {
                $(".section_filter_mobile").removeClass("sticky");
                $(".nav_filter").addClass("hidden_overlay");
                $(".nav_filter").removeClass("show_overlay");
            }
        });
    }

    // $(document).scroll(function(){
    //     if($(this).scrollTop() >= $('.').offset().top - 50) {
    //         $(".").css("background","red");
    //     } else {
    //         $(".").css("background","orange");
    //     }
    // });

    $(document).on('click', '.section_filter_mobile .sorting .sortby', function () {
        $('.sortby').removeClass('active');
        $(this).addClass('active');
        $('.nav_filter.hidden_overlay .icon .sort.active').click();
    });

    // End filter Mobile //





    // var youTubeUrl = $('#video').attr('src');
    // $(document).on('click', '.popup__close', function(){
    //     $('.youtube-video').find('iframe').attr('src','');
    //     $('.youtube-video').find('iframe').attr('src',youTubeUrl);
    // });





    // $(document).on('click', '.popup_visible', function() {
    //     $('html, body').css('overflow', 'visible');
    //     $(".overlay").removeClass("overlay_visible");
    //     $(".popup").removeClass("popup_visible");
    //     return false;
    // });


    // $(document).on('click', '.nav_single_title', function() {
    //     var ths = $(this);
    //     var trgt = $($(this).attr('href'));
    //     $('.single_faq').removeClass('active');
    //     $('.nav_single_title').removeClass('active');
    //     $(this).addClass('active');
    //     trgt.addClass('active');

    //     return false;
    // });

    // $(document).on('click', '.js-popup-closer', function() {
    //     $('.popup').removeClass('popup_visible');
    //     $('#overlay').removeClass('overlay_visible');
    //     $('html, body').css('overflow', 'visible');
    //     return false;
    // });





});

//start cart count //

// function increaseValue() {
//     var value = parseInt(document.getElementById('number').value, 10);
//     value = isNaN(value) ? 0 : value;
//     if(document.getElementById('number').value!==$('#number').attr('data-max')){
//     value++;
//     }
//     else{
//         $('#increase').addClass('disabled');
//     }
//     document.getElementById('number').value = value;
// }

// function decreaseValue() {
//     var value = parseInt(document.getElementById('number').value, 10);
//     value = isNaN(value) ? 1 : value;
//     value < 2 ? value = 2 : '';
//     value--;
//     document.getElementById('number').value = value;
// }
// function increaseValueByID(element_id) {
//     var value = parseInt(document.getElementById(element_id).value, 10);
//     value = isNaN(value) ? 0 : value;
//     value++;
//     document.getElementById(element_id).value = value;
// }

// function decreaseValueByID(element_id) {
//     var value = parseInt(document.getElementById(element_id).value, 10);
//     value = isNaN(value) ? 1 : value;
//     value < 2 ? value = 2 : '';
//     value--;
//     document.getElementById(element_id).value = value;
// }
//End cart count //



// if($('.player__button').length){
// // start Hero Video //
//         $(document).on('click', '.player__button', function() {
//             $('.player__controls').toggleClass('paused');
//             return false;
//         });
//         $(document).on('click', '.player__video', function() {
//             $('.player__controls').toggleClass('paused');
//             return false;
//         });

//         /* Get our elements */
//         const player       =  document.querySelector('.player');
//         const video        =  player.querySelector('.viewer');
//         const toggle       =  player.querySelector('.toggle');


//         // toggle play/pause
//         function togglePlay() {
//         const method = video.paused ? 'play' : 'pause';
//         video[method]();
//         }

//         // Detect press of spacebar, toggle play
//         function detectKeypress(e) {
//             if (e.keyCode == 32) {
//             togglePlay();
//             } else {
//             return;
//             }
//         }

//         // Update button on play/pause
//         // function updateButton() {
//         // const icon = this.paused ? '' : '';
//         // toggle.textContent = icon;
//         // }

//         /* Hook up the event listeners */


//         // Click events
//         video.addEventListener('click', togglePlay);
//         toggle.addEventListener('click', togglePlay);
//         // fullscreen.addEventListener('click', toggleFullscreen);

//         // Keypress (Play/Pause)
//         window.addEventListener('keydown', detectKeypress);

//         // // Play/Pause events
//         // video.addEventListener('play', updateButton);
//         // video.addEventListener('pause', updateButton);

//         // Detect how far mouse has moved
//         // ranges.forEach(range => range.addEventListener('change', handleRangeUpdate));
//         // ranges.forEach(range => range.addEventListener('mousemove', handleRangeUpdate));

//         // Track scrubbing
//         // let mousedown = false;
//         // progress.addEventListener('click', scrub);
//         // progress.addEventListener('mousemove', (e) => mousedown && scrub(e));

//         // Track when mouse is up/down on scrub bar
//         // progress.addEventListener('mousedown', () => mousedown = true);
//         // progress.addEventListener('mouseup', () => mousedown = false);

// // End Hero Video //
//     }


// $(".reviews-info-tabs .tabs li").click(function () {
//     $(this).addClass("active").siblings().removeClass("active");
//     });

//     $(".reviews-info-tabs .tabs li#trigger-reviews").click(function () {
//     $(".review-section").addClass("active");
//     $(".product-info").removeClass("active");
//     });

//     $(".reviews-info-tabs .tabs li#trigger-info").click(function () {
//     $(".product-info").addClass("active");
//     $(".review-section").removeClass("active");
// });




// $(window).scroll(function(){
//     if($(window).scrollTop() >= $(".section_filter_mobile").offset().top + $(".section_filter_mobile").height() )
//         $('.section_filter_mobile').addClass('active');
//     else
//         $('.section_filter_mobile').removeClass('active');
// });



// $(window).scroll(function(){
//     if($(window).scrollTop() >= $(".section_filter_mobile").offset().top + $(".section_filter_mobile").height() )
//         $('.section_filter_mobile').addClass('active');
//         else
//         $('.section_filter_mobile').removeClass('active');
// });

// $(window).scroll(function(){

//     $('.section_filter_mobile').each(function() {
//         if($(window).scrollTop() <= $(this).offset().top + $(this).height() || $(window).scrollTop() > $(this).offset().top) {
//             $(this).addClass('active');
//         } else {

//             $(this).removeClass('active');
//         }
//     });

// });
// Placeholder for dropdowns
const $placeholder = $("select[placeholder]");
if ($placeholder.length) {
    $placeholder.each(function () {
        const $this = $(this);

        // Initial
        $this.addClass("placeholder-shown");
        const placeholder = $this.attr("placeholder");
        $this.prepend(`<option value="" selected>${placeholder}</option>`);

        // Change
        $this.on("change", (event) => {
            const $this = $(event.currentTarget);
            if ($this.val()) {
                $this.removeClass("placeholder-shown").addClass("placeholder-hidden");
            } else {
                $this.addClass("placeholder-shown").removeClass("placeholder-hidden");
            }
        });
    });
}



////////////
$(document).on('click', '.mobile-nav .menu-main-nav-container .menu .single_menu .category_link:not(.active)', function () {
    $('.category_link').removeClass('active');
    $('.details_menu').slideUp();

    $(this).next().slideDown();
    $(this).addClass('active');
    return false;
});

$(document).on('click', '.mobile-nav .menu-main-nav-container .menu .single_menu .category_link.active', function () {
    $('.details_menu').slideUp();
    $(this).removeClass('active');
    return false;
});

//MD-popups

$(document).on('click', '.js-MD-popup-opener', function () {
    var ths = $(this);
    var trgt = $($(this).attr('href'));
    // $(".mobile-nav").removeClass("active");
    // $('.menu_mobile_icon.close').removeClass('show');
    // $('.menu_mobile_icon.open').removeClass('hide');
    $('.MD-popup').removeClass('popup_visible');
    $('html, body').css('overflow', 'hidden');
    $('#overlay').addClass('overlay_visible');
    $(".mobile-nav").removeClass("active");
    trgt.addClass('popup_visible');

    return false;
});
$(document).on('click', '.js-MD-popup-closer', function () {
    $('.MD-popup').removeClass('popup_visible');
    $('#overlay').removeClass('overlay_visible');
    $('html, body').css('overflow', 'visible');
    return false;
});

//Show password text
$(document).on('click', '.MD-show-password', function () {
    var next_iput = $(this).next('input');
    // console.log(next_iput);
    if (next_iput.attr("type") === "password") {
        next_iput.attr("type", "text");
    } else {
        next_iput.attr("type", "password");
    }
});

//show small menu

$(document).on('click', '.menu-icon', function () {
    $(this).parent().addClass('active');
});

// $(document).on('click', 'body', function () {
//         $('.MD-menu.active').removeClass('active');
// });

$(document).on('click', '.press-btn', function () {
    $('.press-div').addClass('hide');
    $('.MD-thanks').addClass('show')
});

// ---------------------------------------------------Thanks Page Backend Functions -----------------------------
$(window).bind('load', function () {
    $(document).on('click', '.trending', function () {

        $('.trending').removeClass('active')
        $(this).addClass('active')
        let category_id = $(this).attr("data-cat");
        $('#ajax_loader').show();
        //alert(category_id);

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: mitch_ajax_url,
            data: {
                action: "change_category_selected",
                category_id: category_id,

            },
            success: function (data) {
                $('.trending-container').html(data.trending_product);
                $('#ajax_loader').hide();

            }
        })
    })
});
//------------------------------------------- End BackEnd Function --------------------

$(document).on('click', ' .txt:not(.active)', function () {
    $('.select_view').removeClass('active');
    $(this).addClass('active');
    $(this).parent().find('.select_view').addClass('active');
    $('.overlay-mobile').addClass('overlay_visible');

});

$(document).on('click', ' .txt.active', function () {
    $('.select_view').removeClass('active');
    $(this).removeClass('active');
    $(this).parent().find('.select_view').removeClass('active');
    $('.overlay-mobile').removeClass('overlay_visible');
});

$(document).on('click', ' .overlay-mobile', function () {
    $('.select_view').removeClass('active');
    $('.txt').removeClass('active');
    $('.select_view').removeClass('active');
    $('.overlay-mobile').removeClass('overlay_visible');
});


$(document).on('click', '.select_view li', function () {
    val = $(this).text();
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $(this).closest('.select-time').find('.txt span').text(val);
    $(' .txt').removeClass('active');
    setTimeout(function () {
        $('.select_view').removeClass('active');


    }, 200);
});

// ---------------------------------- Checkout Function  ---------------------------------------------
$(document).on('updated_checkout', function () {
    // at the end of cvv label
    if (!$('#security-code').parent().find('label i').length) {
        $('#security-code').parent().find('label').append('<i class="cvc-hint"><img src="https://www.cloudhosta.com:8000/wp-content/themes/glosscairo/assets/img/cvv-card.png" alt=""></i>')
    }
    // at the end of visa payment method label
    if (!$('.wc_payment_method.payment_method_nodepayment label[for="payment_method_nodepayment"] div').length) {
        //   if (lang == 'en') {
        //     $('.wc_payment_method.payment_method_nodepayment label[for="payment_method_nodepayment"]').append('<div><i class="cvc-hint two"></i> <div class="content-bank"> <span>E-payment service provided by</span> <img src="https://www.cloudhosta.com:8000/wp-content/themes/glosscairo/assets/img/bank-misr.png"></div> </div>')
        //   }
        //   else {
        $('.wc_payment_method.payment_method_nodepayment label[for="payment_method_nodepayment"]').append('<div><i class="cvc-hint two"></i> <div class="content-bank"> <img src="https://www.cloudhosta.com:61/wp-content/themes/joula/assets/img/icons/visaicon.png"></div> </div>')

        //   }
    }
});
// ------------------------------- Checkout field Annimations And Style -----------------

$(document).ready(function () {
    setTimeout(
        function () {
            $("#card-number").keyup(function () {
                if ($(this).val()[0] == '4') {
                    $('.form-row.cards').removeClass('master-card')
                    $('.form-row.cards').addClass('visa-card')
                }
                else {
                    $('.form-row.cards').removeClass('visa-card')
                    $('.form-row.cards').addClass('master-card')
                }
            })
        }, 9000);

});

$(document).on('click', '.has_menu .category_link', function () {
    $('.menu-popup.popup').addClass('popup_visible');
    $('html, body').css('overflow', 'hidden');
    return false;
});



$(document).on('click', '.all-menu .open_menu_pop', function () {
    $('.single-menu').removeClass('active');
    $(this).parent().addClass('active');
}); $(document).on('click', '.all-menu .open_menu_pop', function () {
    $('.single-menu').removeClass('active');
    $(this).parent().addClass('active');
});

$(document).on('click', '.category_link.open_menu', function () {
    var ths = $(this);
    var trgt = $($(this).attr('href'));
    $('.menu-popup .single-menu').removeClass('active');
    $('.open_menu').removeClass('active');
    trgt.addClass('active');

    return false;
});

// homepage video
$(document).on('click', '.video', function () {
    console.log('basma2');
    setTimeout(() => {

        $(this).addClass('hide');
        $('.video-main').show();

    }, 300);

    $("#video")[0].src += "&autoplay=1";


})
$(document).on('click', '.video', function () {
    $(this).hide();
    $('.video-main').show();
});

$('#message_fields input[name=add_gift_box]').change(function () {
    if ($(this).is(':checked')) {
        $('.checkbox').addClass('active');
    } else {
        $('.checkbox').removeClass('active');

    }
}).change();