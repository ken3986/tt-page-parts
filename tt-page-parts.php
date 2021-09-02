<?php
/*
Plugin Name: TT Page-Parts
Plugin URI: https://github.com/ken3986/tt-page-parts
Description: エディタで作成したページパーツを、ウィジェットとしてページに配置することができるプラグインです。
Author: Ken
Author URI: https://github.com/ken3986/tt-page-parts
Version: 1.0.2
*/

if(! class_exists('TTPageParts')) :
  class TTPageParts {

    // カスタム投稿タイプ名
    protected $customPostTypeName;

    // コンストラクタ
    function __construct() {
      // 変数定義ファイルの読み込み
      require_once dirname(__FILE__). '/variables.php';
      $this->customPostTypeName = $customPostTypeName;
    }

    // 初期動作
    public function initialize() {
      $this->add_custom_post_type_tt_page_parts();
      $this->add_custom_taxonomy_tt_page_parts_taxonomy();
    }

    //****************************************
    //     カスタム投稿タイプの設定
    //****************************************
      /**
       * カスタム投稿タイプ「ページパーツ」を設置
       */
      public function add_custom_post_type_tt_page_parts() {
        add_action('init', array($this, 'custom_post_type_tt_page_parts'));
        add_action('after_switch_theme', array($this, 'my_rewrite_flush'));
      }

      /**
       * カスタム投稿タイプ「ページパーツ」の設定
       */
      public function custom_post_type_tt_page_parts()
      {
        // 管理画面に表示するカスタム投稿タイプ名
        $displayName = 'ページパーツ';

        // カスタム投稿ラベル
        $labels = array(
          'name' => $displayName,
          'singlar_name' => '新しい' . $displayName,
          'all_items' => $displayName . '一覧',
          'add_new' => '新規追加',
          'edit_item' => $displayName . 'を編集',
          'search_items' => $displayName . 'を検索',
        );

        // カスタム投稿タイプを設定
        register_post_type($this->customPostTypeName, array(
          'label' => $this->customPostTypeName,
          'labels' => $labels, //カスタム投稿ラベル
          'description' => 'ページに挿入して表示するパーツ用の投稿タイプです。',
          'exclude_from_search' => true,
          'public' => true,
          'has_archive' => false,
          'menu_position' => 25,
          'menu_icon' => 'dashicons-text',
          'show_in_rest' => true,
          'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        ));

        // 通常投稿の「カテゴリー」「タグ」機能を取り込み
        register_taxonomy_for_object_type('category', $this->customPostTypeName);
        register_taxonomy_for_object_type('post_tag', $this->customPostTypeName);
      }

      /**
       * 有効化するときリライトルールをフラッシュする
       */
      public function my_rewrite_flush()
      {
        flush_rewrite_rules();
      }

    //****************************************
    //     カスタムタクソノミーの設定
    //****************************************
      /**
       * カスタムタクソノミー「パーツ分類」を設置
       */
      public function add_custom_taxonomy_tt_page_parts_taxonomy() {
        add_action('init', array($this, 'func_tt_page_parts_category_taxonomy'));
      }

      /**
       * カスタムタクソノミー「パーツ分類」の設定
       */
      public function func_tt_page_parts_category_taxonomy()
      {
        $taxonomyName = 'tt_page_parts_category_taxonomy';
        $displayName = 'パーツ分類';
        $labels = array(
          'name' => $displayName,
          'singular_name' => $displayName,
          'all_items' => 'すべての' . $displayName,
          'edit_item' => $displayName . 'を編集',
          'view_item' => $displayName . 'を表示',
          'update_item' => $displayName . 'を更新',
          'add_new_item' => '新しい' . $displayName . 'を追加',
          'new_item_name' => '新しい' . $displayName . 'の名前',
          'parent_item' => '親' . $displayName,
          'parent_item_colon' => '親' . $displayName . ':',
          'search_items' => $displayName . 'を検索',

        );

        $args = array(
          'labels' => $labels,
          'show_admin_column' => true,
          'description' => 'ページパーツ用の分類項目です。',
          'hierarchical' => true //階層化する
        );
        register_taxonomy($taxonomyName, array($this->customPostTypeName), $args);
      }

  }

  // 初期化処理
  function tt_page_parts() {
    $tt_page_parts = new TTPageParts();
    $tt_page_parts->initialize();
  }
  tt_page_parts();
endif;

//****************************************
//     ウィジェットを追加
//****************************************
require_once dirname(__FILE__). '/inc/page-parts-widget.php';
