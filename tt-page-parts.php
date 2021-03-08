<?php
/*
Plugin Name: TT Page-Parts
Plugin URI:
Description: エディタで作成したページパーツを、ウィジェットとしてページに配置することができます。
Author: Ken
Author URI:
Version: 0.9
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