<?php require_once 'header.php';?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <?php
  $allproducts    = 21;
  $posts_per_page = 20;
  ?>
  <!--start page-->
  <div class="site-content page_list">
    <div class="grid">
      <div class="list_content">
        <?php include_once 'theme-parts/filters-form.php';?>
        <div class="product list">
          <div class="grid">
            <div class="product_container">
              <ul class="products_list products"
              data-count="20" data-page="1"
              data-posts="<?php echo $allproducts; ?>"
              data-slug="<?php if(isset($cate)){echo $cat_slug;}?>"
              data-type="<?php if(isset($cate)){echo $cate->taxonomy;}?>"
              data-search="<?php if(isset($_GET['s'])){echo $_GET['s'];}?>"
              data-sort="<?php if(isset($_GET['orderby'])){echo $_GET['orderby'];}else{echo 'popularity';}?>"
              data-lang="<?php echo $theme_settings['current_lang'];?>">
              <?php
              if(isset($_GET['collection']) && $_GET['collection'] == 'best_selling'){
                $products_ids = mitch_get_best_selling_products_ids(-1);
              }elseif(isset($_GET['collection']) && $_GET['collection'] == 'new_arrival'){
                $products_ids = mitch_get_new_arrival_products_ids(-1);
              }else{
                if(!isset($_GET['filter'])){
                  $products_ids = mitch_get_products_list();
                }
              }
              if(!empty($products_ids)){
                foreach($products_ids as $product_id){
                  $product_data = mitch_get_short_product_data($product_id);
                  include 'theme-parts/product-widget.php';
                }
              }
              ?>
              </ul>
            </div>
            <!-- <div class="section_loader">
              <div class="loader"></div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
