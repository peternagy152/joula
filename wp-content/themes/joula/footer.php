  <?php include_once 'theme-parts/home/footer-banners.php';?>
  <!--start footer-->
  <footer>
      <?php include_once 'theme-parts/footer/desktop.php';?>
      <?php include_once 'theme-parts/footer/mobile.php';?>
  </footer>
  <!--end footer-->
  <div id="overlay" class="overlay"></div>
  <div id="overlay_header" class="overlay_header"></div>
  <div id="overlay_sort" class="overlay_sort"></div>
  <?php include_once 'theme-parts/popups.php';?>
  <?php
  $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  if (strpos($url,'myaccount') !== false) {
    //include_once 'theme-parts/MD-popups.php';
  }
  
  ?>
  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/jquery-3.2.1.min.js"></script>
  <!-- <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/jquery.cookie.js"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/main.js?nocash=1"></script>
  <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.ez-plus.js">
  </script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.elevatezoom.js"></script>
  <script type="text/javascript">
mqList = window.matchMedia("(min-width: 999px)");
if (mqList.matches) {
    $('.slider-main-img').ezPlus({
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        zoomWindowPosition: 10,
        zoomType: 'lens',
        lensShape: 'round',
        lensSize: 200,
        // scrollZoom: true,
        // zoomLevel: 1,
        // minZoomLevel: 0.5
        
    });


}
  </script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/aos.js"></script>
  <script>
$(".zoom").elevateZoom({
    zoomType: "inner",
    cursor: "crosshair",
    easing: true,
});
  </script>
  <script>
AOS.init();
if ($('body').hasClass('rtl')) {
    var is_ar = false;
} else {
    var is_ar = true;
}
  </script>
  <?php //if(is_product_category()){?>
  <script>
// jQuery(function($) {
//   $(window).bind('load',function () {
//     get_products_ajax_count();
//   });
// });
  </script>
  <?php// }?>
  <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/slick.min.js" defer></script>
  <script>
var mitch_ajax_url = '<?php echo admin_url('admin-ajax.php');?>';
  </script>
  <script src="<?php echo $theme_settings['theme_url'];?>/backend_functions.js?no_cash=1"></script>
  <!-- <script src="<?php //echo $theme_settings['theme_url'];?>/local/products_json.js"></script> -->
  <!-- <script type="text/javascript">
$(document).ready(function() {
    $('#gsearch').keyup(function() {
        var searchField = $(this).val();
        if (searchField === '') {
            $('#search_results').html('');
            $('#search_results').hide('slow');
            return;
        }
        $('#search_results').show('slow');
        var regex = new RegExp(searchField, "i");
        var output = '<div class="row">';
        var count = 1;

        $.each(data, function(key, val) {
            if ((val.sku.search(regex) != -1) || (val.product_name.search(regex) != -1)) {
                output += '<a href="' + val.product_url + '"><div class="col-md-6 well">';
                output +=
                    '<div class="col-md-3"><img class="img-responsive" width="80px" src="' + val
                    .product_image + '" alt="' + val.product_name + '" /></div>';
                output += '<div class="col-md-7">';
                output += '<h5>' + val.product_name + '</h5><h6>' + val.product_price + '</h6>';
                output += '</div>';
                output += '</div></a>';
                if (count % 2 == 0) {
                    output += '</div><div class="row">'
                }
                count++;
            }
        });
        if (count == 1) {
            output += '<div class="not_results">Sorry, Not Found Any Result!</div>';
        }
        output += '</div>';
        $('#search_results').html(output);
    });
});
var divToHide = document.getElementById('search_results');
if (divToHide) {
    document.onclick = function(e) {
        if (e.target.id !== 'search_results') {
            //element clicked wasn't the div; hide the div
            divToHide.style.display = 'none';
        }
    };
}
  </script> -->
  <script>
function copyText() {

    /* Copy text into clipboard */
    navigator.clipboard.writeText("www.joula.com/ref=1-02o0;20409");
    $('.copied-message').addClass('active');
    setTimeout(() => {
        $('.copied-message').removeClass('active');
    }, 1000);

}
  </script>
  <?php
     if(is_checkout()){ ?>
  <script>
jQuery(function($) {
    jQuery(document).on('submit', '.checkout_coupon', function(e) {
        // Get the coupon code
        var code = jQuery('#coupon_code').val();
        var data = {
            coupon_code: code,
            security: '<?php echo wp_create_nonce("apply-coupon") ?>'
        };
        $.ajax({
            method: 'post',
            url: '/?wc-ajax=apply_coupon',
            data: data,
            success: function(data) {
                jQuery('.woocommerce-notices-wrapper').html(data);
                jQuery(document.body).trigger('update_checkout');
            }
        });
        e.preventDefault(); // prevent page from redirecting
    });
});
jQuery('.validate-required').removeClass('.woocommerce-invalid');
  </script>
  <!-- <style>
        .page_checkout .grid .checkout-content #customer_details .form-row.woocommerce-invalid .input-text {border: 1px solid #222 !important;}
      </style> -->
<!--  --><?php //wp_footer();?>
  <?php }
      // if(isset($_GET['filter'])){
      //   if(wp_is_mobile()){
      //     ?>
  <script>
//get_products_ajax("", "mobile");
  </script>
  <?php 
      //   }else{
      //     ?>
  <script>
//get_products_ajax("", "desktop");
  </script>
  <?php 
      //   }
      // }
      ?>
  <script>
/*jQuery('.select2').select2({
          placeholder: 'Select an option'
        });*/
$.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: $('body').attr("data-mitch-ajax-url"),
    data: {
        action: "get_cart_content_fresh",
    },
    success: function(data) {
        $('#cart_total_count').html(data.cart_count);
        $('.non-fixed').html(data.cart_content);
        if (data.cart_count == 0) {
            $('#side_mini_cart_content').addClass('empty');
        } else {
            $('#side_mini_cart_content').removeClass('empty');
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        //$('#ajax_loader').hide();
    }
});
// $('input[name="delivery_date"]:radio').change(function() {
//     $(".radio-btns label").removeClass("selected");
//     $("input[name='delivery_date']:checked").parent().addClass("selected");
//     $("body").trigger("update_checkout");
// });
  </script>
  <?php wp_footer();?>
  </body>

  </html>