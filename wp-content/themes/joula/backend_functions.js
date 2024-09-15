var mitch_home_url     = $('body').attr("data-mitch-home-url");
var mitch_ajax_url     = $('body').attr("data-mitch-ajax-url");
var mitch_logged_in    = $('body').attr("data-mitch-logged-in");
var mitch_current_lang = $('body').attr("data-mitch-current-lang");

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
  document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
//solve issue of slick slider when reload page it's not work
jQuery('.slider-nav').addClass('active');
// jQuery('.product-slider').addClass('active');
$('.product-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
  $('.slider-nav img').removeClass('active');
  $('.slider-nav-img-'+nextSlide).addClass('active');
  //console.log(nextSlide);
});
function mitch_show_error(element_id, error_msg){
  // alert('HIFromError');
  $('#'+element_id).html(error_msg);
  $('#'+element_id).show('slow');
}
function mitch_show_error(element_id){
  $('#'+element_id).html('');
  $('#'+element_id).hide('slow');
}
function mitch_ajax_request(ajax_url, ajax_action, form_data, error_element_id, success_alert_type = 'none'){
  $('#ajax_loader').show();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: ajax_url,
    data: {
      action: ajax_action,
      form_data: form_data,
    },
    success: function (data) {
      //alert('form was submitted');
      $('#ajax_loader').hide();
      if(data.status == 'success'){
        if(data.redirect_to){
          window.location.replace(data.redirect_to);
        }
        if(data.cart_count){
          $('#cart_total_count').html(data.cart_count);
        }
        if(data.cart_total){
          $('#cart_total').html(data.cart_total);
        }
        if(data.cart_content){
          $('#side_mini_cart_content').html(data.cart_content);
          $('.js-popup-opener[href="#popup-min-cart"]').click();
        }
        if(success_alert_type == 'popup'){
         
        }else{
          if(data.msg){
            $('#'+error_element_id).html('<div class="alert alert-success">Done '+data.msg+'</div>');
            $('#'+error_element_id).show('slow');
            $("html, body").animate({ scrollTop: 0 }, "slow");
          }
        }
      } else if(data.status == 'error'){

        $('.callback-message').addClass('show-message');
        $('.callback-message').addClass('error-message');
        $('.callback-message').removeClass('success-message');

        $('.message-info').html('<p>' + data.msg + '</p>');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      // alert("Error:" + errorThrown); //"Status: " + textStatus +
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry, There is an issue!',
      //   text: errorThrown,
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
      $('#'+error_element_id).html('<div class="alert alert-danger">Sorry There is an issue!</div>');
      $('#'+error_element_id).show('slow');
    }
  });
}
if(mitch_ajax_url){
  //console.log("Backend Function Here!");

  $('#register_form').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_register_users",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          if(data.redirect_to){
            window.location.replace(data.redirect_to);
          }
        } else if(data.status == 'error'){
          if(data.code == 401){
            Swal.fire({
              title: 'Sorry',
              text: data.msg,
              icon: 'error',
              showConfirmButton: true,
              // timer: 1500
            });
          }else{
            Swal.fire({
              title: 'Sorry',
              text: data.msg,
              icon: 'error',
              showConfirmButton: false,
              timer: 1500
            });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry, There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  $('#login_form').on('submit', function (e) {
    e.preventDefault();
    var element_id = 'callback-message';
    var email      = $('#login_email').val();
    var pass       = $('#login_password').val();
    if(email != '' && pass != ''){
      mitch_ajax_request(mitch_ajax_url, 'mitch_login_users', $(this).serialize(), element_id);
    }else{
      if(email == ''){
        $('.callback-message').addClass('show-message');
        $('.callback-message').addClass('error-message');
        $('.callback-message').removeClass('success-message');

        var error_msg  = 'Sorry, Email is required!';
        $('.message-info').html('<p>' + error_msg + '</p>');
      }
      if(pass == ''){
        var error_msg  = 'Sorry, Password is required!';
        $('.callback-message').removeClass('success-message');
         $('.callback-message').addClass('show-message');
          $('.callback-message').addClass('error-message');

        var error_msg  = 'Sorry, Email is required!';
        $('.message-info').html('<p>' + error_msg + '</p>');
      }
    }
  });

  function cart_remove_item(cart_item_key, product_id, type = 'cart_page'){
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "cart_remove_item",
        cart_item_key: cart_item_key,
        product_id: product_id
      },
      success: function (data) {
        if(product_id){
          $('#'+product_id).remove();
        }
        if(cart_item_key){
          $('#cart_page_'+cart_item_key).remove();
          $('#mini_cart_'+cart_item_key).remove();
        }
        $('#cart_total_count').html(data.cart_count);
        $('#cart_total').html(data.cart_total);
        $('.non-fixed').html(data.cart_content);
        if(data.cart_count == 0) {
          $('#side_mini_cart_content').addClass('empty');
        }
        else{
          $('#side_mini_cart_content').removeClass('empty');
        }
        // alert(data.result);
        if(data.cart_count == 0 && type == 'cart_page'){
          // Simulate an HTTP redirect:
          window.location.replace(mitch_home_url);
        }
        // alert('تم حذف المنتج من سلة المنتجات بنجاح.');
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'تم بنجاح',
        //   text: 'حذف المنتج من سلة المنتجات',
        //   icon: 'success',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }

  function update_cart_items(cart_item_key, location){
    $('#ajax_loader').show();
    if(location == 'cart_page'){
      var quantity_number = $('#cart_page_'+cart_item_key+' .number_count').val();
    }else if(location == 'mini_cart'){
      var quantity_number = $('#mini_cart_'+cart_item_key+' .number_count').val();
    }
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "update_cart_items",
        cart_item_key: cart_item_key,
        quantity_number: quantity_number,
      },
      success: function (data) {
        $('#cart_total_count').html(data.cart_count);
        $('#cart_total').html(data.cart_total);
        $('#line_subtotal_'+cart_item_key).html(data.item_total);
        $('#side_mini_cart_content').html(data.cart_content);
        // alert('تم تعديل سلة المنتجات بنجاح!');
        $('#ajax_loader').hide();

        if(data.success === false){
          $('#number_' + cart_item_key).val(data.item_quantity);
          swal({
            title: "Sorry",
            text: data.msg,
            icon: "warning",
            button : false ,
            timer : 1500 ,
          });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        Swal.fire({
          title: 'Sorry There is an issue!',
          text: errorThrown,
          icon: 'error',
          showConfirmButton: false,
          timer: 1500
        });
      }
    });
  }

  // var links = document.getElementsByTagName('a');
  // // alert(links.length);
  // for(var i = 0; i< links.length; i++){
  //   alert(links[i].href);
  // }
  /*
  $('#apply_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_apply_coupon",
          coupon_code: coupon_code,
          coupon_from: 'cart'
        },
        success: function (data) {
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'تطبيق كوبون الخصمم!',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              Swal.fire({
                title: 'Sorry',
                text: data.msg,
                icon: 'error',
                showConfirmButton: true,
                // timer: 1500
              });
            }else{
              Swal.fire({
                title: 'Sorry',
                text: data.msg,
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          Swal.fire({
            title: 'Sorry There is an issue!',
            text: errorThrown,
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }else{
      $('#ajax_loader').hide();
      Swal.fire({
        title: 'Sorry',
        text: 'Coupon code is required!',
        icon: 'error',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
  */
  $('#remove_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_remove_coupon",
          coupon_code: coupon_code,
          coupon_from: 'cart'
        },
        success: function (data) {
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#apply_coupon').show();
            $('#remove_coupon').hide();
            $('.list_pay.discount').hide();
            document.getElementById('coupon_code').value = '';
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'ازالة كوبون الخصم!',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            $.ajax({
              type: 'POST',
              dataType: 'JSON',
              url: $('body').attr("data-mitch-ajax-url"),
              data: {
                action: "get_cart_content_fresh",
              },
              success: function (data) {
                $('#cart_total_count').html(data.cart_count);
                $('.non-fixed').html(data.cart_content);
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                //alert("Error:" + errorThrown); //"Status: " + textStatus +
                //$('#ajax_loader').hide();
              }
            });
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: true,
              //   // timer: 1500
              // });
            }else{
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: false,
              //   timer: 1500
              // });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry',
      //   text: 'لا يوجد كود خصم!',
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
    }
  });

  function add_product_to_wishlist(product_id, refresh_page = 'NULL'){
    if(mitch_logged_in == 'yes'){
      $('#ajax_loader').show();
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: 'add_product_to_wishlist',
          product_id: product_id,
        },
        success: function (data) {
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#product_'+product_id+'_block .fav_btn').attr("onclick","remove_product_from_wishlist("+product_id+")");
            $('#product_'+product_id+'_block .fav_btn').removeClass('not-favourite');
            $('#product_'+product_id+'_block .fav_btn').addClass('favourite');
            if(refresh_page == 'yes'){
              location.reload();
            }
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'اضافة المنتج لقائمة المفضلة',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry There is an issue!',
            //   text: '',
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      var host = window.location.origin;
      window.location.href = host + '/myaccount/user-login.php';
    }
  }

  function remove_product_from_wishlist(product_id, remove_block = 'NULL', refresh_page = 'NULL'){
    $('#ajax_loader').show();
    // alert(product_id);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: 'remove_product_from_wishlist',
        product_id: product_id,
      },
      success: function (data) {
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          $('#product_'+product_id+'_block .fav_btn').attr("onclick","add_product_to_wishlist("+product_id+")");
          $('#product_'+product_id+'_block .fav_btn').removeClass('favourite');
          $('#product_'+product_id+'_block .fav_btn').addClass('not-favourite');
          if(remove_block == 'yes'){
            $('#product_'+product_id+'_block').remove();
          }
         // if(refresh_page == 'yes'){
            location.reload();
          //}
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'ازالة المنتج من قائمة المفضلة',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }else{
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: '',
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }
  // alert(mitch_logged_in);

  $('.load_form_data').on('click', function () {
    $("#address_id").val($(this).data('id'));
    $("#country").val($(this).data('country'));
    $("#city").val($(this).data('city'));
    $("#building").val($(this).data('building'));
    $("#street").val($(this).data('street'));
    $("#area").val($(this).data('area'));
    $("#operation").val('edit_address');
  });
  $('.add_new_address').on('click', function () {
    $('#edit_address')[0].reset();
    $("#operation").val('add_address');
    $("#address_id").val('');
  });
  $('#edit_address').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_edit_address",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'حفظ بيانات العنوان',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
          location.reload();
        }
        if(data.status == 'error'){
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  $('#cancel_order_form').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_cancel_order",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          if(data.redirect_to){
            window.location.replace(data.redirect_to);
          }
        } else if(data.status == 'error'){
          if(data.code == 401){
            // Swal.fire({
            //   title: 'Sorry',
            //   html: data.msg,
            //   icon: 'error',
            //   showConfirmButton: true,
            //   // timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry',
            //   text: data.msg,
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  // $('#checkout_form').on('submit', function (e) {
  //   //e.preventDefault();
  //   // alert($('input[name="terms-accept"]:checked').length);
  //   var element_id = 'checkout_form_alerts';
  //   var error_msg  = '';
  //   if($('input[name="terms-accept"]:checked').length == 0){
  //     var error_msg = 'برجاء تحقق من الشروط والاحكام!';
  //   }
  //   if($("input[name='building']").val() == '' || $("input[name='area']").val() == '' || $("input[name='street']").val() == ''){
  //     var error_msg = 'برجاء كتابة بيانات العنوان كاملة!';
  //   }
  //   if($("select[name='city']").val() == ''){
  //     var error_msg = 'برجاء اختيار المدينة!';
  //   }
  //   if($("input[name='phone']").val() == ''){
  //     var error_msg = 'برجاء كتابة رقم الجوال!';
  //   }
  //   if($("input[name='email']").val() == ''){
  //     var error_msg = 'برجاء كتابة الايميل!';
  //   }
  //   if($("input[name='lastname']").val() == ''){
  //     var error_msg = 'برجاء كتابة اسم العائلة!';
  //   }
  //   if($("input[name='firstname']").val() == ''){
  //     var error_msg = 'برجاء كتابة الأسم الاول!';
  //   }
  //   if(error_msg == ''){
  //     mitch_ajax_request(mitch_ajax_url, 'mitch_create_order', $(this).serialize(), element_id);
  //   }else{
  //     $('#'+element_id).html('');
  //     $('#'+element_id).append('<div class="alert alert-danger">'+error_msg+'</div>').show('slow');
  //     $('#'+element_id).show('slow');
  //     // window.scrollTo(0, 0);
  //     $("html, body").animate({ scrollTop: 0 }, "slow");
  //   }
  // });
  function show_password_fields(){
    if($('#new_account_button input').is(":checked")){
      $("#password_fields").show('slow');
      $("#new_password").prop('required',true);
      $("#confirm_password").prop('required',true);
    }else{
      $("#password_fields").hide('slow');
      $("#new_password").prop('required',false);
      $("#confirm_password").prop('required',false);
    }
  }
  show_password_fields();
  $('#apply_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_apply_coupon",
          coupon_code: coupon_code,
          coupon_from: 'cart'
        },
        success: function (data) {
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#message-fail').removeClass("active");
            $('#message-success').addClass("active");
      
            eraseCookie('custom_product_home_visit_time');
            eraseCookie('custom_product_branch_visit');
            eraseCookie('custom_product_visit_type');
            $('#apply_coupon').hide();
            $('#remove_coupon').show();
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            if(data.cart_discount_div){
              $(data.cart_discount_div).insertAfter("#car_subtotal_div");
            }
            $.ajax({
              type: 'POST',
              dataType: 'JSON',
              url: $('body').attr("data-mitch-ajax-url"),
              data: {
                action: "get_cart_content_fresh",
              },
              success: function (data) {
                $('#cart_total_count').html(data.cart_count);
                $('.non-fixed').html(data.cart_content);
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                //alert("Error:" + errorThrown); //"Status: " + textStatus +
                //$('#ajax_loader').hide();
              }
            });
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              $('#message-success').removeClass("active");
              $('#message-fail').addClass("active");
            }else{
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: false,
              //   timer: 1500
              // });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
         
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry',
      //   text: 'Coupon code is required!',
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
    }
  });

  $('#remove_coupon').on('click', function () {
    $('#ajax_loader').show();
    var coupon_code = $('#coupon_code').val();
    if(coupon_code){
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
          action: "mitch_remove_coupon",
          coupon_code: coupon_code,
          coupon_from: 'checkout'
        },
        success: function (data) {
          $('#message-fail').removeClass("active");
          $('#message-success').removeClass("active");
          //alert('form was submitted');
          $('#ajax_loader').hide();
          if(data.status == 'success'){
            $('#apply_coupon').show();
            $('#remove_coupon').hide();
            $('.list_pay.discount').hide();
            document.getElementById('coupon_code').value = '';
            // Swal.fire({
            //   title: 'تم بنجاح',
            //   text: 'ازالة كوبون الخصم!',
            //   icon: 'success',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
            if(data.cart_total){
              $('#cart_total').html(data.cart_total);
            }
            if(data.redirect_to){
              window.location.replace(data.redirect_to);
            }
          } else if(data.status == 'error'){
            if(data.code == 401){
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: true,
              //   // timer: 1500
              // });
            }else{
              // Swal.fire({
              //   title: 'Sorry',
              //   text: data.msg,
              //   icon: 'error',
              //   showConfirmButton: false,
              //   timer: 1500
              // });
            }
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // alert("Error:" + errorThrown); //"Status: " + textStatus +
          $('#ajax_loader').hide();
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: errorThrown,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }
      });
    }else{
      $('#ajax_loader').hide();
      // Swal.fire({
      //   title: 'Sorry',
      //   text: 'There is no coupon code!',
      //   icon: 'error',
      //   showConfirmButton: false,
      //   timer: 1500
      // });
    }
  });
  function next_button_proceed(){
    if(getCookie('custom_product_home_visit_time') || getCookie('custom_product_branch_visit')){
      $('#next_button').removeClass('disabled');
      $('.next_step').removeClass('disabled');
      $('.breadcramb').removeClass('disabled');
      $('.step-nav-two').removeClass('disabled');
    }else{
      $('#next_button').addClass('disabled');
      $('.next_step').addClass('disabled');
      $('.breadcramb').addClass('disabled');
    }
  }

  $(document).on('click', '.single_box', function(){
    var img  = $(this).data('variation-img'); //one
    var step = $(this).data('variation-step');
    $('.step-nav-'+step+' .min_box').removeClass('emty'); //
    $('.step-nav-'+step+' .min_box').addClass('done');
    $('.step-nav-'+step+' .min_box img').attr('src', img);
  });

  // function checkout_location(){
  //   if($('#home_checkbox').is(":checked")){
  //     $(".home_checkbox_content").show();
  //     $(".branch_checkbox_content").hide();
  //   }else if ($('#branch_checkbox').is(":checked")){
  //     $(".home_checkbox_content").hide();
  //     $(".branch_checkbox_content").show();
  //   }
  // }

  $('#profile_settings').on('submit', function (e) {
    e.preventDefault();
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "mitch_profile_settings",
        form_data: $(this).serialize(),
      },
      success: function (data) {
        //alert('form was submitted');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'تعديل بيانات الحساب',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        } else if(data.status == 'error'){
          if(data.code == 401){
            // Swal.fire({
            //   title: 'Sorry',
            //   text: data.msg,
            //   icon: 'error',
            //   showConfirmButton: true,
            //   // timer: 1500
            // });
          }else{
            // Swal.fire({
            //   title: 'Sorry',
            //   text: data.msg,
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });

  function simple_product_add_to_cart(product_id, product_quantity = 1){
    if(product_quantity){
      var quantity = product_quantity;
    }else{
      var quantity = parseInt($('#product_quantity').val());
    }
    // alert(quantity);
    $('#ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "simple_product_add_to_cart",
        product_id: product_id,
        quantity_number: quantity,
      },
      success: function (data) {
        //alert('تم اضافة المنتج لسلة المشتريات بنجاح.');
        $('#ajax_loader').hide();
        if(data.status == 'success'){
          $('#cart_total_count').html(data.cart_count);
          $('.non-fixed').html(data.cart_content);
          $('#side_mini_cart_content').removeClass('empty');
          const cartClassExists = document.getElementsByClassName('page_cart').length > 0;
          if(cartClassExists){
            //$('[name="update_cart"]').trigger('click');
            location.reload();
          }
          // Swal.fire({
          //   title: 'تم بنجاح',
          //   text: 'اضافة المنتج الي سلة المشتريات',
          //   icon: 'success',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
          $('.js-popup-opener[href="#popup-min-cart"]').click();
          if(data.redirect_to){
            window.location.replace(data.redirect_to);
          }
        } else if(data.status == 'error'){
          if(quantity == 0){
            var msg = 'You must select quantity!';
          }else if(data.msg){
            var msg = data.msg;
          }else{
            var msg = 'There is an issue, please try again!';
          }
          if(data.code == 401){
            swal({
              title: "Stock Issue",
              text: "No enough stock for this item",
              icon: "warning",
              button : false ,
              timer : 1500 ,
            });

          }else{
            // Swal.fire({
            //   title: 'Sorry',
            //   html: msg,
            //   icon: 'error',
            //   showConfirmButton: false,
            //   timer: 1500
            // });
          }
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  }
  function variable_product_add_to_cart(product_id){
    // alert($('#product_quantity').val());
    $('#ajax_loader').show();
    var var_items = jQuery('.variation_option.active').map(function() {
      var key       = $(this).data('key');
      var item_arr  = new Object();
      item_arr[key] = $(this).data('value');
      return item_arr;
    }).get();
    // alert(var_items);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "variable_product_add_to_cart",
        product_id: product_id,
        selected_items: var_items,
        // variation_id: variation_id,
        quantity_number: $('#product_quantity').val(),
      },
      success: function (data) {
        //alert('تم اضافة المنتج لسلة المشتريات بنجاح.');
        $('#ajax_loader').hide();
        if(data.status == 'error'){
          // Swal.fire({
          //   title: 'Sorry There is an issue!',
          //   text: data.msg,
          //   icon: 'error',
          //   showConfirmButton: false,
          //   timer: 1500
          // });
        }else{
          $('#cart_total_count').html(data.cart_count);
          $('.non-fixed').html(data.cart_content);
          $('#side_mini_cart_content').removeClass('empty');
          $('.js-popup-opener[href="#popup-min-cart"]').click();
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {


        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        swal({
          title: "Stock Issue",
          text: "No enough stock for this item",
          icon: "warning",
          button : false ,
          timer : 1500 ,
        });
      }
    });
  }
  $(window).bind("load", function () {
    if($('.variable_middle').length){
      get_availablility_variable_product($('.single_page').attr('data-id'));
    }
    $("body").addClass("fully-loaded");
  });
  function get_availablility_variable_product(product_id){
    $('#ajax_loader').show();
    setTimeout(() => {
      var var_items = jQuery('.variation_option.active').map(function() {
        var key       = $(this).attr('data-key');
        var item_arr  = new Object();
        item_arr[key] = $(this).attr('data-value');
        return item_arr;
      }).get();
    console.log(var_items);
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mitch_ajax_url,
      data: {
        action: "get_availablility_variable_product",
        product_id: product_id,
        selected_items: var_items,
      },
      success: function (data) {
        $('#ajax_loader').hide();
        $('#number').val('1');
        $('#increase').removeClass('disabled');
        $('#number').attr('data-max','');
        $('.variable_middle .price').html(data.price);
        if(data.quantity && data.quantity!==-1){
          $('#number').attr('data-max',data.quantity);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("Error:" + errorThrown); //"Status: " + textStatus +
        $('#ajax_loader').hide();
        // Swal.fire({
        //   title: 'Sorry There is an issue!',
        //   text: errorThrown,
        //   icon: 'error',
        //   showConfirmButton: false,
        //   timer: 1500
        // });
      }
    });
  });
  }

  $('#reviews_form').on('submit', function (e) {
    e.preventDefault();
    var element_id = 'reviews_form_alerts';
    var error_msg  = '';
    if($("select[name='rating']").val() == ''){
      var error_msg = 'Rating is required!';
    }
    if($("input[name='email']").val() == ''){
      var error_msg = 'Email is require!';
    }
    if($("input[name='name']").val() == ''){
      var error_msg = 'Name is required!';
    }
    if(error_msg == ''){
      mitch_ajax_request(mitch_ajax_url, 'mitch_make_product_review', $(this).serialize(), element_id, 'popup');
      this.reset();
    }else{
      $('#'+element_id).html('');
      $('#'+element_id).append('<div class="alert alert-danger">'+error_msg+'</div>').show('slow');
      $('#'+element_id).show('slow');
      // window.scrollTo(0, 0);
      // $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  });

  function bought_together_products_add_to_cart(){
    var element_id   = 'single_product_alerts';
    var products_ids = jQuery('.active-item.single_item').map(function() {
      return $(this).data('id');
    }).get();
    mitch_ajax_request(mitch_ajax_url, 'mitch_bought_together_products', {products_ids: products_ids}, element_id, 'none');
  }
  function bought_item_change(product_id, main_price, variation_price){
    // alert(product_id);
    //$('#' + id).is(":checked")
    var total_bought = parseFloat($('#total_bought').html());
    if($('#btcheck_'+product_id).is(":checked")){
      $('.bought_product_item_'+product_id).show('slow');
      $('.bought_product_item_'+product_id).addClass('active-item');
      var total_bought_after = total_bought + variation_price;
    }else{
      $('.bought_product_item_'+product_id).hide('slow');
      $('.bought_product_item_'+product_id).removeClass('active-item');
      var total_bought_after = total_bought - variation_price;
    }
    $('#total_bought').html(total_bought_after);
  }
}else{
  alert('Sorry Please reload page!');
}

jQuery(".sort").on("change", function () {
  $posts_per_page = 20;
  $(".sortby.active").removeClass("active");
  $(".products").data("page", 1);
  $(this).addClass("active");
  let option = $(this).val();
  $(".products").attr("data-sort", option);
  get_products_ajax("sort", "desktop");
  return false;
});

// jQuery(window).scroll(function () {
//   if ($(".spinner").is(":visible")) {
//     if ($(".product_widget").length) {
//       Footeroffset = jQuery(".product_widget").last().offset().top;
//     }
//     winPosBtn = jQuery(window).scrollTop();
//     winH = jQuery(window).outerHeight();
//     if (winPosBtn + winH > Footeroffset + 5) {
//       get_products_ajax("loadmore");
//       //console.log("read");
//     }
//   }
// });
jQuery(document).on("change", ".filter_input", function () {
  $(".spinner").show();
  $(".products").data("page", 1);
  get_products_ajax("filter", "desktop");
});

// load more on scroll and click, filter, and sort
$posts_per_page = 20;
$loading_more = false;
var jqxhr_add_get_products_ajax = {abort: function () {}};
function get_products_ajax(action, view = "") {
//console.log("called get_products_ajax");
// jqxhr_add_get_products_ajax.abort();
var ajax_url = mitch_ajax_url;
$count       = $(".products").attr("data-count");
$page        = $(".products").attr("data-page");
$posts       = $(".products").attr("data-posts");
$order       = $(".products").attr("data-sort");
$type        = $(".products").attr("data-type");
$search      = $(".products").attr("data-search");
$lang        = $(".products-list").attr("data-lang");
$slug        = "";
$cat         = "";
$ids         = new Array();
if($type == "shop"){
}else if ($type == "products-list") {
  $ids = $(".products").data("ids");
}else {
   $slug = $(".products").data("slug");
   $cat  = $(".products").data("cat");
}

let min_price   = "";
let max_price   = "";
let max_prices  = new Array();
let min_prices  = new Array();
let cats        = new Array();
let colors      = new Array();
let sizes       = new Array();
let collections = new Array();
let occasions   = new Array();
let forwho      = new Array();
let genders     = new Array();
$(".filter_input:checked").each(function () {
  if ($(this).hasClass("filter-price")) {
    min_prices.push(parseInt($(this).data("min")));
    max_prices.push(parseInt($(this).data("max")));
    max_price =
      parseInt($(this).data("max")) == 0
        ? parseInt($(this).data("max"))
        : Math.max(...max_prices);
    min_price = Math.min(...min_prices);
    $order = "price";
  } else if ($(this).hasClass("filter-cat")) {
    cats.push($(this).val());
  }else if ($(this).hasClass("filter-color")) {
    colors.push($(this).val());
  }else if ($(this).hasClass("filter-size")) {
    sizes.push($(this).val());
  }else if ($(this).hasClass("filter-collection")) {
    collections.push($(this).val());
  }else if ($(this).hasClass("filter-occasion")) {
    occasions.push($(this).val());
  }else if ($(this).hasClass("filter-forwho")) {
    forwho.push($(this).val());
  }else if ($(this).hasClass("filter-gender")) {
    genders.push($(this).val());
  }
});
if (($loading_more || $posts_per_page >= $posts) && action == "loadmore") {
  // console.log("khalstt " + $posts);
  return;
}
$loading_more = true;
jqxhr_add_get_products_ajax = $.ajax({
  type: "POST",
  url: ajax_url,
  data: {
    action: "get_products_ajax",
    count: $count,
    page: $page,
    order: $order,
    type: $type,
    slug: $slug,
    min_price: min_price,
    max_price: max_price,
    cat: $cat,
    cats: cats,
    colors: colors,
    sizes: sizes,
    collections: collections,
    occasions: occasions,
    forwho: forwho,
    genders: genders,
    search: $search,
    fn_action: action,
    ids: $ids,
  },
  success: function (posts) {
    get_products_ajax_count(action);
    $loading_more = false;
    if (action == "loadmore") {
      $(".products").append(posts);
      $(".products").attr("data-page", parseInt($page) + 1);
      $(".spinner").attr("data-page", parseInt($page) + 1);
      //console.log($(".products").attr("data-page"));
      $posts_per_page += parseInt($count);
      $posts = $(".products").attr("data-posts");
      //console.log("$posts_per_page", $posts_per_page);
      //console.log("$posts", $posts);
      if ($posts_per_page >= $posts) {
        /// Begin of get out of stock products function
        $(".spinner").hide();
      } else {
        if ($posts_per_page < $posts) {
          $(".spinner").show();
        }
      }
    } else {
      $(".products").html(posts);
      if (parseInt($page) % 2 == 0 && $posts_per_page < $posts) {
        $(".spinner").show();
      } else if (parseInt($page) % 2 == 1 && $posts_per_page < $posts) {
        $(".spinner").show();
      } else if ($posts_per_page >= $posts) {
        /// Begin of get out of stock products function
        $(".spinner").hide();
      }
    }
  },
});
}
var jqxhr_add_get_products_ajax_count = {abort: function () {}};
function get_products_ajax_count(view) {
jqxhr_add_get_products_ajax_count.abort();
// console.log('get_products_ajax_count');
var ajax_url = mitch_ajax_url;
$count       = $(".products").attr("data-count");
$page        = $(".products").attr("data-page");
$posts       = $(".products").attr("data-posts");
$order       = $(".products").attr("data-sort");
$type        = $(".products").attr("data-type");
$search      = $(".products").attr("data-search");
$slug        = "";
$cat         = "";
$ids         = new Array();
if($type == "shop"){
} else if ($type == "products-list") {
  $ids = $(".products").data("ids");
} else {
  $slug = $(".products").data("slug");
  $cat = $(".products").data("cat");
}

let min_price  = "";
let max_price  = "";
let max_prices = new Array();
let min_prices = new Array();
let colors     = new Array();
let sizes      = new Array();
let cats       = new Array();

$(".filter_input:checked").each(function () {
  if ($(this).hasClass("filter-price")) {
    min_prices.push(parseInt($(this).data("min")));
    max_prices.push(parseInt($(this).data("max")));
    max_price =
      parseInt($(this).data("max")) == 0
        ? parseInt($(this).data("max"))
        : Math.max(...max_prices);
    min_price = Math.min(...min_prices);
    $order = "price";
  } else if ($(this).hasClass("filter-cat")) {
    cats.push($(this).val());
  } else if ($(this).hasClass("filter-color")) {
    colors.push($(this).val());
  } else if ($(this).hasClass("filter-size")) {
    sizes.push($(this).val());
  }
});
setTimeout(function () {
  jqxhr_add_get_products_ajax_count = $.ajax({
    type: "POST",
    url: ajax_url,
    data: {
      action: "get_products_ajax_count",
      count: $count,
      page: $page,
      order: $order,
      type: $type,
      slug: $slug,
      min_price: min_price,
      max_price: max_price,
      cat: $cat,
      search: $search,
      cats: cats,
      colors: colors,
      sizes: sizes,
      ids: $ids,
    },
    success: function (posts) {
      // console.log('posts', posts);
      if (20 >= parseInt(posts)) {
        $(".spinner").addClass("hide");
      } else if (parseInt(posts) == 0) {
        $(".spinner").removeClass("hide");
      } else {
        $(".spinner").removeClass("hide");
      }
      $(".products").attr("data-posts", posts);
      $(".spinner").attr("data-posts", posts);
    },
  });
});
}

$("#billing_state,#country").on("change", function () {
  var urlParams = new URLSearchParams(window.location.search);
  let state = $(this).val();
  let city = $("#billing_city").val();
  $("#billing_city_field").addClass("blocked");
  // $("#billing_area_field").addClass("blocked");
  let lang = "";
  if (urlParams.has("lang")) {
    lang = urlParams.get("lang");
  }

  $.ajax({
    type: "POST",
    url: mitch_ajax_url,
    data: {
      action: "get_city",
      state: state,
      lang: lang,
    },
    success: function (posts) {
      if(window.location.href.indexOf('addresses')>-1){
      $("#city").html(posts);
      }else{
      $("#billing_city_field").html(posts);
      }
      $("#billing_city_field").removeClass("blocked");
    },
  });

});
if(window.location.href.indexOf('checkout')>-1){
  $("#billing_state").change();
}
if(window.location.href.indexOf('my-account/addresses')>-1){
  $("#country").change();
}

if ($(".new_search").length) {
  var jqxhr_add = {abort: function () {}};
  var lang = "";
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    // some code..
  } else {
    window.addEventListener("click", function (e) {
      if (document.getElementById("newSearch").contains(e.target)) {
        if ($(".new-search").val()) {
          $(".search-result").addClass("show");
          $(".sec_search").addClass("show");
          $('html').addClass('no-scroll');
        }
      } else {
        $(".search-result").removeClass("show");
        $(".sec_search").removeClass("show");
        $('html').removeClass('no-scroll');
      }
    });
    $("#newSearch").on("focus", function () {
      if (!$(".search-result").hasClass("show")) {
        if ($(".new-search").val().length >= 1) {
          $(".search-result").addClass("show");
          $(".sec_search").addClass("show");
        }
      }
    });
  }
  jQuery($(".new-search")).keyup(function () {
    jqxhr_add.abort();
    if ($(".search-result").length) {
      // $(".search-result").html("");
      $(".search-result").addClass('loading');
      if ($(".search-result").hasClass("show")) {
        $(".search-result").addClass("show");
        $(".sec_search").removeClass("show");
      }
      if ($(".new-search").val().length >= 1) {
        $('#ajax_loader').show();
        $(".search-result").removeClass('loading');
        jqxhr_add = $.ajax({
          type: "POST",
          url: mitch_ajax_url,
          data: {
            action: "custom_search",
            s: $(".new-search").val(),
            // lang: lang,
          },
          success: function (data) {
            $('#ajax_loader').hide();
            if (data) {
              $(".search-result").removeClass('loading');
              $(".search-result").addClass("show");
              $(".sec_search").addClass("show");
              $(".loader_search").hide();
              $(".search-result").html(data);
            }
          },
          error: function(){
            $('#ajax_loader').hide();

          },
          
        });
      }
     // $('#ajax_loader').hide();
    }
  });
}
function navigateMyForm() {
  var lang = "";
  var urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("lang")) {
    lang = "_" + urlParams.get("lang");
  }
  var s = $(".search-formm .new-search").val();
  var site_url    = $('body').attr("data-mitch-home-url");
  if (lang == "_en") {
    window.location.href =
    site_url+"/search/?search=" + s + "&lang=en";
  } else {
    window.location.href =
    site_url+"/search/?search=" + s;
  }
  return true; 
}

$("label[for='property_type_villa']").on("click", function () {
  $(".require-build").addClass("hide");
  $("span.description").hide();
});

$("label[for='property_type_apart']").on("click", function () {
  $(".require-build").removeClass("hide");
  $("span.description").fadeIn();
});


jQuery(document).on('click','#place_order', function(e) {
  jQuery('.checkout').removeClass('remove_border_on_first_load');
});

jQuery(document).on('click','.insta_widget_box ', function(e) {

  e.preventDefault();
  var ajax_url    = $('body').attr("data-mitch-ajax-url");
  var insta_item  = $(this).data('item');
  $.ajax({
       method: 'post',
       url: ajax_url,
       data: {
         action: 'mitch_get_insta_content',
         insta_item: insta_item,
       },
       success: function(data) {
         jQuery('.insta-popup-content').html(data);
         $('.popup').removeClass('popup_visible');
         $('html, body').css('overflow', 'hidden');
         $('#overlay').addClass('overlay_visible');
         $('#popup-insta').addClass('popup_visible');
       }
   });
});
function mitch_sort_by(sort_by){
  // alert(sort_by);
  $(".products").attr("data-sort", sort_by);
  get_products_ajax('sort', 'mobile');
}



// ---------------------------------- Partial Redeem  Hide And Show ----------------------------
// $(document.body).on('updated_checkout', custom_checkout_field_display_based_on_cart_total);
// function custom_checkout_field_display_based_on_cart_total() {
//
//   $.ajax({
//     type: 'POST',
//     dataType: 'JSON',
//     url: mitch_ajax_url,
//     data: {
//         action: "MD_remove_partial_checkbox_from_checkout",
//     },
//     success: function (data) {
//
//       if($('body').data('redeem') == 'true'){
//         $('#message_fields').show();
//       }
//       else{
//         if(data.points == true){
//           $('#message_fields').hide();
//         }else{
//
//           $('#message_fields').show();
//           let message_points = '';
//           if(data.points_type == 1){
//              message_points = 'Use Your Current Points Balance Of ' + data.total_points + ' Points To Save ' + data.total_cash + ' EGP';
//           }else {
//              message_points = 'Use Your Current Cash Balance To Save ' + data.total_cash + ' EGP';
//           }
//
//           $('#message_redeem').html(message_points);
//          }
//       }
//       if(data.total == 0 && $('body').data('redeem') == 'true'){
//         location.reload();
//       }
//
//
//     }
// })
// }
// Simple Product [No Variations ]
$(document).on('click', '#simple_add_product_to_cart', function(){
  var product_id       = $('.single_size.active').data('product-id');
  simple_product_add_to_cart(product_id, 1);
});


// Mobile filter Text change 
$(document).on('click', '.sortby', function(){
  let sort_type = $(this).data('value');

  $('.selected-sort').html(sort_type);
});


jQuery(document).on('click','.left-arrow , .right-arrow ', function(e) {

  e.preventDefault();
  var ajax_url    = $('body').attr("data-mitch-ajax-url");
  var insta_item  = $(this).data('item');
  $.ajax({
       method: 'post',
       url: ajax_url,
       data: {
         action: 'mitch_get_insta_content',
         insta_item: insta_item,
       },
       success: function(data) {
         jQuery('.insta-popup-content').html(data);
         $('.popup').removeClass('popup_visible');
         $('html, body').css('overflow', 'hidden');
         $('#overlay').addClass('overlay_visible');
         $('#popup-insta').addClass('popup_visible');
       }
   });
});




$( document ).ready(function() {
  setTimeout(function() {
  $('.form-row').removeClass('woocommerce-invalid woocommerce-invalid-required-field');
    
    }, 1000);
 
});
$('#subForm').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    method: 'post',
    url:  $('body').attr("data-mitch-ajax-url") ,
    data: {
      action: 'mitch_newsletter_add_to_list',
      form_data: $(this).serialize(),
    },
    success: function(data) {
      swal({
        title: "Newsletter",
        text: "Subscription done successfully.",
        icon: "success",
        button : false ,
        timer : 1500 ,
      });
    }
  });

});