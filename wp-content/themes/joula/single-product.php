<?php
require_once 'header.php';
$product_id          = get_the_id();
$single_product_data = mitch_get_product_data($product_id);
mitch_validate_single_product($single_product_data['main_data']);
mitch_add_recently_viewed_product();
$product_categories_ids = $single_product_data['main_data']->get_category_ids();
shuffle($product_categories_ids);
$first_product_category  = $product_categories_ids[0];
if(isset($product_categories_ids[1])){$second_product_category = $product_categories_ids[1] ; }else{$second_product_category = 0 ; } ;
?>
<div id="page" class="site">
    <?php require_once 'theme-parts/main-menu.php';?>
    <!--start page-->
    <div id="product_<?php echo $single_product_data['main_data']->get_id();?>_block" class="single_page"
        data-sku="<?php echo $single_product_data['main_data']->get_sku();?>"
        data-id="<?php echo $single_product_data['main_data']->get_id();?>">
        <div class="section_item grid">
            <?php
                woocommerce_breadcrumb(array(
                    'delimiter'   => '',
                    'wrap_before' => '<ul class="breadcramb">',
                    'wrap_after'  => '</ul>',
                    'before'      => '<li>',
                    'after'       => '</li>',
                    'home'        => $fixed_string['product_single_breadcrumb']
                ));
            ?>
            <div id="single_product_alerts" class="ajax_alerts"></div>
            <div class="content">
                <?php include_once 'theme-parts/single-product/gallary-section.php';?>
                <?php include_once 'theme-parts/single-product/info-section.php';?>
            </div>
        </div>

    </div>

    <?php include_once 'theme-parts/related-products.php';?> 
    <?php //include_once 'theme-parts/slider-reviews.php';?>
    <?php include_once 'theme-parts/single-product/reviews-products.php';?>
    <?php include_once 'theme-parts/single-product/recently-viewed-products.php';?>

    <!--end page-->
</div>
<?php require_once 'footer.php';?>
<div id="size_guide_popup" class="popup size_guide">
    <div class="popup__window size_guide">
        <button type="button" class="popup__close material-icons js-popup-closer">close</button>
        <?php include get_template_directory().'/theme-parts/size-guide-section.php';?>
    </div>
</div>
<?php 
$product_id = get_the_ID();
?>
<script>
function select_star(start_value) {
    $("#rating").val(start_value);
}
$(document).on('click', '#simple_add_product_to_cart', function() {
    var product_id = $('.single_size.active').data('product-id');
    var product_quantity = $('#product_quantity').val();
    simple_product_add_to_cart(product_id, product_quantity);
});
$(document).on('click', '.single_color.variation_option', function() {
    if($(this).data('price') == $(this).data('regular-price')){
        $('#product_price').html($(this).data('price') + ' EGP' ) ;
    }else{
        $('#product_price').html($(this).data('price') + ' EGP' + '<span class = "discount">' + $(this).data('regular-price') +' EGP </span>' ) ;
    }

});

$(document).ready(function() {
    $(".single_color.variation_option.active").click();
});
</script>
