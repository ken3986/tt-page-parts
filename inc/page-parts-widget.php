<?php

/**
 * ページパーツの取得ウィジェット
 */

if (! class_exists('TTPagePartsWidget')) :
  class TTPagePartsWidget extends WP_Widget {
    /**
     * ウィジェットを登録する
     */
    function __construct() {
      parent::__construct(
        'tt_page_parts_widget', // Base ID
        '[TT] ページパーツ表示', // Name
        array(
          'classname' => 'tt_page_parts_widget',
          'description' => '指定したページパーツの内容を表示します。',
        ) // Args
      );
    }


    /**
     * サイトにウィジェットを出力する
     *
     * @param array $args register_sidebarで設定した項目が入る
     * [before_title] = タイトル前に出力する要素
     * [after_title] = タイトル後に出力する要素
     * [before_widget] = ウィジェット前に出力する要素
     * [after_widget] = ウィジェット後に出力する要素
     * @param array $instance Widgetの設定項目
     * [target_page_part_id] = 読み込むページパーツのID
     */
    public function widget($args, $instance) {
      // 読み込むページパーツのID
      $page_id = $instance['target_page_part_id'];

      // 'before_widget'を出力
      echo $args['before_widget'];

      // ページパーツを取得
      $post = get_post($page_id);

      // ページパーツの中身を出力
      echo '<article class="article '. esc_attr($post->post_name). '">';
      echo apply_filters('the_content', $post->post_content);
      echo '</article>';

      // 'after_widget'を出力
      echo $args['after_widget'];
    }


    /**
     * 管理画面「外観」＞「ウィジェット」にフォームを出力する
     *
     * @param array $instance
     * [title] = ウィジェットタイトル
     * [target_page_part_id] = 表示するページパーツのID
     * @return string|void
     */
    public function form($instance) {
      $widget_title = (isset($instance['title'])) ? $instance['title'] : '';
      ?>
      <p> <!-- タイトル -->
        <label for="<?= $this->get_field_id('title'); ?>">タイトル</label>
        <input type="text" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name('title'); ?>" value="<?= esc_attr($widget_title); ?>">
      </p>
      <p> <!-- ページパーツの選択 -->
        <label for="<?php echo $this->get_field_id(('target_page_part_id')); ?>">出力ページパーツ:</label>
        <?php
          $selected = (isset($instance['target_page_part_id'])) ? $instance['target_page_part_id'] : '';
          $args = array(
            'post_type' => 'tt_page_parts',
            'posts_per_page' => -1,
          );
          // カスタム投稿タイプ「ページパーツ」からリストを読み込む
          $customPosts = get_posts($args);
        ?>

        <!-- ドロップダウンメニュー -->
        <select name="<?php echo $this->get_field_name('target_page_part_id') ?>" id="<?php echo $this->get_field_id('target_page_part_id') ?>" >
          <?php if($customPosts): ?>
            <?php foreach($customPosts as $customPost): ?>
              <option value="<?php echo $customPost->ID; ?>" <?php if((int)$customPost->ID === (int)$selected) echo 'selected'; ?>>
                <!-- ページパーツタイトルを表示 -->
                <?php echo esc_html(wp_strip_all_tags($customPost->post_title, true)); ?>
              </option>
            <?php endforeach; ?>
          <!-- カスタム投稿タイプ「ページパーツ」に投稿が無い場合 -->
          <?php else: ?>
            <option value="" disabled>作成されていません</option>
          <?php endif; ?>
        </select>
      </p>
      <?php
    }

  }

  add_action('widgets_init', function () {
    //ウィジェットをWordPressに登録する
    register_widget('TTPagePartsWidget');
  });

endif;
