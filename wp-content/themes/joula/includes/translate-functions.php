<?php
add_filter('gettext',  'mitch_translate_woocommerce_strings', 10, 3);
add_filter('ngettext',  'mitch_translate_woocommerce_strings', 10, 3);
function mitch_translate_woocommerce_strings($translated, $text, $domain){
  global $theme_settings;
  if($theme_settings['current_lang'] == 'ar'){
    if($text == 'You cannot add that amount of &quot;%1$s&quot; to the cart because there is not enough stock (%2$s remaining).'){
      $translated = 'لا يمكنك إضافة هذه الكمية من &quot;%1$s&quot; إلى عربة التسوق لعدم وجود مخزون كافٍ (باقي %2$s).';
    }elseif($text == 'You cannot add that amount to the cart &mdash; we have %1$s in stock and you already have %2$s in your cart.'){
      $translated = 'لا يمكنك إضافة هذه الكمية الي عربة التسوق &mdash; لدينا %1$s في المخزون وانت لديك بالفعل  %2$s في سلة مشترياتك';
    }
  }
  return $translated;
}
