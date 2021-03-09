<?php
/*
Plugin Name: TT Page-Parts
Plugin URI: https://github.com/ken3986/tt-page-parts
Description: エディタで作成したページパーツを、ウィジェットとしてページに配置することができるプラグインです。
Author: Ken
Author URI: https://github.com/ken3986/tt-page-parts
Version: 1.0.0
*/

if( ! class_exists('TTPageParts') ) :
  class TTPageParts {

    // コンストラクタ
    function __construct() {

    }

    function initialize() {
      require_once dirname(__FILE__). '/custom_post_type/page-parts-post-type.php';
      require_once dirname(__FILE__). '/widgets/page-parts-widget.php';
    }
  }

  function tt_page_parts() {
    $tt_page_parts = new TTPageParts();
    $tt_page_parts->initialize();
  }

  tt_page_parts();

endif;
