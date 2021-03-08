<?php

/**
 * カスタム投稿タイプ「ページパーツ」を設定
 */

function custom_post_type_tt_page_parts()
{
  $pluginName = 'tt_page_parts';

  $displayName = 'ページパーツ';
  $labels = array(
    'name' => $displayName,
    'singlar_name' => '新しい' . $displayName,
    'all_items' => $displayName . '一覧',
    'add_new' => '新規追加',
    'edit_item' => $displayName . 'を編集',
    'search_items' => $displayName . 'を検索',
  );

  register_post_type($pluginName, array(
    'label' => $pluginName,
    'labels' => $labels,
    'description' => 'ページに挿入して表示するパーツ用の投稿タイプです。',
    'exclude_from_search' => true,
    'public' => true,
    'has_archive' => false,
    'menu_position' => 25,
    'menu_icon' => 'dashicons-text',
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
  ));

  register_taxonomy_for_object_type('category', $pluginName);
  register_taxonomy_for_object_type('post_tag', $pluginName);
}
add_action('init', 'custom_post_type_tt_page_parts');


// 有効化するときリライトルールをフラッシュする
function my_rewrite_flush()
{
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'my_rewrite_flush');