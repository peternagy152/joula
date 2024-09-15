
$("#form-add").on("submit", function (e) {

    //Gather New Address Data 
    e.preventDefault();
    var city = $('#city').val(); 
    var area = $('#area').val();
    var full_address = $('.full-address').val();
    var floor = $('.floor').val();
    var apartment = $('.apartment').val();
    var apartment_type = $('input[name="apartment_type"]:checked').val();

    //Where this Form Came From ?
    var came_from = $(this).data('where');


    // Send Data to PHP Function To Store into Database

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_add_user_address",
            city: city,
            area: area,
            full_address : full_address ,
            floor : floor ,
            apartment : apartment ,
            apartment_type : apartment_type ,
            came_from : came_from ,

        },
        success: function (data) {
            location.reload();

        }
    })

});

// --------------------------- Remove Address -------------------
$(".remove").on("click", function () {
    var address_id =  $(this).data('address');
    var default_address =  $(this).data('default');


    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_remove_address",
            address_id : address_id ,
            default_address : default_address ,
        },
        success: function (data) {
            location.reload();
        }
    })


});

// ----------------------------- Change Default Address ------------------------
$(".change").on("click", function () {
    //Gather Data 
    var current_address = $(this).data('current-default');
    var new_address = $(this).data('new-default');
    
    //Send Data To Function 
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_change_default_address",
            current_address : current_address ,
            new_address : new_address ,
        },
        success: function (data) {
            location.reload();
        }
    })


});
// ---------------------------------- Edit Address --------------------------- 
//Change Popup Content 

$(".edit-address").on("click", function () {

    $('#ajax_loader').show();
    var address_id = $(this).data('edit');
    var index = $(this).data('counter');

    $('#edit-address').data('edit' , address_id);
    if(index == 0) {
        $('.MD-popup-title.edit-address').html("Edit Default Address ");

    }
    else {
        $('.MD-popup-title.edit-address').html("Edit Address " + index );

    }

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_address_info",
            address_id :address_id ,
            index :index ,

        },
        success: function (data) {
            $('#edit_city').val(data.city);

            // Get All Areas to This City In Backend 
            $.ajax({
                type: "POST",
                url: mitch_ajax_url,
                data: {
                  action: "get_city",
                  state: data.city,
                },
                success: function (posts) {
                  
                  if(window.location.href.indexOf('addresses')>-1){
                  $("#edit_area").html(posts);
                  $('#edit_area').val(data.area);
                  
                  }
                },
              });

           
            $('#street_info').val(data.full_address);
            if(data.apartment_type == 'villa'){
                $('.MD-field.small').hide();
                $('.floor').removeAttr('required');
                $('.apartment').removeAttr('required');
            }
            else {
                $('.MD-field.small').show();
                $('.floor').attr('required', true);
                $('.apartment').attr('required', true);
                $('#floor').val(data.floor);
                $('#apartment').val(data.apartment);
            }

            let radioOption = jQuery("input:radio[value="+data.apartment_type+"]");
            radioOption.prop("checked", true);
            $('#ajax_loader').hide();
        }
    })

  
    
}); 
$(".MD-btn-add").on("click", function () {
    let radioOption = jQuery("input:radio[value="+'flat'+"]");
    radioOption.prop("checked", true);
    $('.MD-field.small').show();
    $('.floor').attr('required', true);
    $('.apartment').attr('required', true);
});

// ----------------------------------- Cities and States For Edit and Add Address -------------------------- 

$("#city , #edit_city").on("change", function () {
    let state = $(this).val();
    $("#area").attr("disabled");

    $.ajax({
      type: "POST",
      url: mitch_ajax_url,
      data: {
        action: "get_city",
        state: state,
      },
      success: function (posts) {
        
        if(window.location.href.indexOf('addresses')>-1){
        $("#area , #edit_area").html(posts);
        }
        $("#area").removeAttr("disabled");
      },
    });
  
  });

  // ------------------------------- Hide Some Fields in Edit And Add Address ---------------------------
  $('input[type=radio][name=apartment_type]').change(function() {
   
    if(this.value == 'villa'){
        $('.MD-field.small').hide();
        $('.floor').removeAttr('required');
        $('.apartment').removeAttr('required');
    }
    else{
        $('.MD-field.small').show();
        $('.floor').attr('required', true);
        $('.apartment').attr('required', true);
    }
  });







// Submit Form to Edit Address  
$("#edit-address").on("submit", function () {
    //Gather New Address Data 
     var address_id = $('#edit-address').data('edit');

     //alert( $(this).serialize());
     $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_edit_address",
            address_id :address_id ,
            form_data: $(this).serialize(),
        },
        success: function (data) {
            location.reload();
        }
    })
   



});

// -------------------------------------- Change Account Info --------------------- 
$("#edit-profile").on("submit", function () {

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_edit_account_info",
            form_data: $(this).serialize(),
        },
        success: function (data) {
            var url = new URL(window.location.href);
            url.searchParams.set('accountinfo', true);
            window.location.replace(url.toString());
        }
    })
   

});

// ------------------------------------ Change Password -------------------------- 
$("#change_password").on("submit", function (e) {

    e.preventDefault();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_change_account_password",
            form_data: $(this).serialize(),
        },
        success: function (data) {

            if(data.status == 'error'){
                $('.password-message').addClass('show-message');

                $('.password-message').removeClass('success-message');
                $('.password-message').addClass('error-message');

                $('.message-info').html(data.msg);
            }
            else{
                $('.password-message').addClass('show-message');
                $('.password-message').removeClass('error-message');
                $('.password-message').addClass('success-message');
                $('.message-info').html(data.msg);


            }
        }
    })
   


});
// ------------------------------------ Order Again ----------------------------------
$(".order-again").on("click", function (e) {

    var order_id = $(this).data('order');


    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_order_again",
            order_id : order_id 
            
        },
        success: function (data) {
            $('#cart_total_count').html(data.cart_count);
            $('.non-fixed').html(data.cart_content);
            $('#side_mini_cart_content').removeClass('empty');
            $('.js-popup-opener[href="#popup-min-cart"]').click();
        }
    })


});

// --------------------------------------- Cancel  Order ------------------------------- 
$("#cancellation").on("submit", function (e) {
    e.preventDefault();
    var order_id = $(this).data('order');

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_order_cancel",
            order_id : order_id ,
            form_data: $(this).serialize(),

            
        },
        success: function (data) {
            if(data.status == 'success'){
                $('.MD-thanks').removeClass('hide');
                $('.cancel-order').remove();
                $('.status').html('<span class = "cancelled"> cancelled </span>')
            }
            else {
                location.reload();
            }
          
           
        }
    })


});

// ----------------------------------- Charge Your Wallet ----------------------
$("#add-more-points").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_charge_your_wallet",
            form_data: $(this).serialize(),
        },
        success: function (data) {
            if(data.status == 'error'){
                $('.charge-wallet').removeClass('success-message');
                $('.charge-wallet').addClass('show-message');
                $('.charge-wallet').addClass('error-message');
                $('.account-message-info').html(data.msg);


            }
            else{
                $('.charge-wallet').addClass('success-message');
                $('.charge-wallet').addClass('show-message');
                $('.charge-wallet').removeClass('error-message');
                $('.account-message-info').html(data.msg);

                setTimeout(function () {
                    location.reload();
                }, 1000);
                
                  
            }

            
        }
    })


});





// --------------------------- Return Product --------------------
$("#return-products").on("submit", function (e) {
    e.preventDefault();
    var order_id = $(this).data('order');

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: mitch_ajax_url,
        data: {
            action: "MD_return_request_function",
            order_id :order_id ,
            form_data: $(this).serialize(),
        },
        success: function (data) {
            var current_url  = document.URL ;
            current_url=  current_url.replace('return-products.php' , 'order-details.php');
            //alert(current_url);
            window.location.href =current_url ;
        }
    })

    

});

$(".product_checkbox").on("click", function () {
    //alert($(this).data('value'));

    var total = $('.total-price').data('total');
    var item_price = $(this).data('price');
    var quantity_class = ".product_quantity_" + $(this).data('value'); 
   // alert(quantity_class);
    var item_quantity = $(quantity_class).find(":selected").val();

    var final_item_quantity = item_quantity.split("-");

    if($(this).is(":checked")){
       
        total = total + item_price * final_item_quantity[0];
    
        $('.total-price').data('total' , total);
        $(quantity_class).removeAttr('disabled');

    }else{
        total = total - item_price * final_item_quantity[0];
    
        $('.total-price').data('total' , total);
        $(quantity_class).attr("disabled", true)
    }
   
    $('.total-price').html(total);
    //console.log($('.total-price').data('total'));

});

(function () {
    var previous;

    $(".number_count").on('click', function () {
        // Store the current value on focus and on change
        previous = this.value;
    }).change(function() {

        previous =  previous.split("-");

        var quantity_class = $(this).attr('class');
        quantity_class = quantity_class.replace('number_count product_quantity_' , '');
        //Decrease the total ; 
        //alert($(this).data('price'));
        var total = $('.total-price').data('total');
        total = total - $(this).data('price') * previous[0];

        // update total 
        previous = this.value;
        previous =  previous.split("-");
        total = total + $(this).data('price') * previous[0];
        $('.total-price').data('total' , total);
        $('.total-price').html(total);
        return ;

    });
})();




// console.log("Hello form my account JS");