<?php 

/**
 * ページパーツの取得ウィジェット
 */

class TT_Page_Parts_Widget extends WP_Widget
{
  /**
   * Widgetを登録する
   */
  function __construct()
  {
    parent::__construct(
      'tt_page_parts_widget', // Base ID
      '[TT] ページパーツ表示', // Name
      array(
        'classname' => 'tt_page__parts_widget',
        'description' => '指定したページパーツの内容を表示します。',
      ) // Args
    );
  }

  /**
   * 表側の Widget を出力する
   *
   * @param array $args      'register_sidebar'で設定した「before_title, after_title, before_widget, after_widget」が入る
   * @param array $instance  Widgetの設定項目
   */
  public function widget($args, $instance)
  {
    $page_id = $instance['target_page_id'];
    echo $args['before_widget'];

    $post = get_post($page_id);

    echo '<article class="article '. esc_attr($post->post_name). '">';
    echo apply_filters('the_content', $post->post_content);
    echo '</article>';

    echo $args['after_widget'];
  }

  /** Widget管理画面を出力する
   *
   * @param array $instance 
   * [title] = ウィジェットタイトル
   * [target_page__id] = 表示するページのID
   * @return string|void
   */
  public function form($instance)
  {
    ?>
    <p> <!-- タイトル -->
      <label for="<?= $this->get_field_id('title'); ?>">タイトル</label>
      <input type="text" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name('title'); ?>" value="<?= esc_attr($instance['title']); ?>">
    </p>
    <p> <!-- ページパーツの選択 -->
      <label for="<?php echo $this->get_field_id(('target_page_id')); ?>">出力ページパーツ:</label>
      <?php
        $selected = (isset($instance['target_page_id'])) ? $instance['target_page_id'] : '';
        $args = array(
          'post_type' => 'tt_page_parts',
        );
        $customPosts = get_posts($args);
      ?>
      <!-- ドロップダウンメニュー -->
      <select name="<?php echo $this->get_field_name('target_page_id') ?>" id="<?php echo $this->get_field_id('target_page_id') ?>" >
        <?php if($customPosts): ?>
          <?php foreach($customPosts as $customPost): ?>
            <option value="<?php echo $customPost->ID; ?>" <?php if((int)$customPost->ID === (int)$selected) echo 'selected'; ?>>
              <!-- ページパーツタイトルを表示 -->
              <?php echo esc_html(wp_strip_all_tags($customPost->post_title, true)); ?>
            </option>
          <?php endforeach; ?>
        <?php else: ?>
          <option value="" disabled>作成されていません</option>
        <?php endif; ?>
      </select>
    </p>
    <?php
  }

  /** 新しい設定データが適切なデータかどうかをチェックする。
   * 必ず$instanceを返す。さもなければ設定データは保存（更新）されない。
   *
   * @param array $new_instance  form()から入力された新しい設定データ
   * @param array $old_instance  前回の設定データ
   * @return array               保存（更新）する設定データ。falseを返すと更新しない。
   */
  function update($new_instance, $old_instance)
  {
    // if(!filter_var($new_instance['email'],FILTER_VALIDATE_EMAIL)){
    //     return false;
    // }
    return $new_instance;
  }
}

add_action('widgets_init', function () {
  register_widget('TT_Page_Parts_Widget');  //WidgetをWordPressに登録する
});