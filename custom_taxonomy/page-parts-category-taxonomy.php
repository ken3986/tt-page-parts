<?php

/**
 * カスタムタクソノミー「パーツ分類」を設定
 */

function func_tt_page_parts_category_taxonomy()
{
  $taxonomyName = 'tt_page_parts_category_taxonomy';


  $args = array();
  register_taxonomy($taxonomyName, array('tt_page_parts'), $args);
}
add_action('init', 'func_tt_page_parts_category_taxonomy');