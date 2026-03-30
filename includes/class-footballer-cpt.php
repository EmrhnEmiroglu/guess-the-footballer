<?php

/**
 * Footballer Custom Post Type ve admin meta alanları.
 */

defined('ABSPATH') || exit;

class GTF_Footballer_CPT {
    const POST_TYPE = 'footballer';
    const META_PLAYER_NAME = 'player_name';
    const META_PLAYER_PHOTO = 'player_photo';

    public static function init() {
        add_action('init', array(__CLASS__, 'register_post_type'));
        add_action('add_meta_boxes', array(__CLASS__, 'register_meta_boxes'));
        add_action('save_post_' . self::POST_TYPE, array(__CLASS__, 'save_meta'), 10, 2);
        add_filter('manage_' . self::POST_TYPE . '_posts_columns', array(__CLASS__, 'columns'));
        add_action('manage_' . self::POST_TYPE . '_posts_custom_column', array(__CLASS__, 'column_content'), 10, 2);
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_admin_assets'));
    }

    public static function register_post_type() {
        $labels = array(
            'name' => _x('Footballers', 'Post Type General Name', 'guess-the-footballer'),
            'singular_name' => _x('Footballer', 'Post Type Singular Name', 'guess-the-footballer'),
            'menu_name' => __('Footballers', 'guess-the-footballer'),
            'name_admin_bar' => __('Footballer', 'guess-the-footballer'),
            'add_new' => __('Yeni Ekle', 'guess-the-footballer'),
            'add_new_item' => __('Yeni Futbolcu Ekle', 'guess-the-footballer'),
            'new_item' => __('Yeni Futbolcu', 'guess-the-footballer'),
            'edit_item' => __('Futbolcuyu Düzenle', 'guess-the-footballer'),
            'view_item' => __('Futbolcuyu Görüntüle', 'guess-the-footballer'),
            'all_items' => __('Tüm Futbolcular', 'guess-the-footballer'),
            'search_items' => __('Futbolcu Ara', 'guess-the-footballer'),
            'not_found' => __('Futbolcu bulunamadı', 'guess-the-footballer'),
            'not_found_in_trash' => __('Çöp kutusunda futbolcu bulunamadı', 'guess-the-footballer'),
        );

        $args = array(
            'label' => __('Footballer', 'guess-the-footballer'),
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-businessman',
            'capability_type' => 'post',
            'supports' => array('title', 'thumbnail'),
            'hierarchical' => false,
            'has_archive' => false,
            'rewrite' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_in_rest' => false,
        );

        register_post_type(self::POST_TYPE, $args);
    }

    public static function register_meta_boxes() {
        add_meta_box(
            'gtf_player_name',
            __('Futbolcu Adı', 'guess-the-footballer'),
            array(__CLASS__, 'render_player_name_meta_box'),
            self::POST_TYPE,
            'normal',
            'default'
        );

        add_meta_box(
            'gtf_player_photo',
            __('Futbolcu Fotoğrafı', 'guess-the-footballer'),
            array(__CLASS__, 'render_player_photo_meta_box'),
            self::POST_TYPE,
            'side',
            'default'
        );
    }

    public static function render_player_name_meta_box($post) {
        wp_nonce_field('gtf_save_player_meta', 'gtf_player_meta_nonce');
        $value = get_post_meta($post->ID, self::META_PLAYER_NAME, true);
        echo '<p><label for="gtf_player_name">' . esc_html__('Tam Ad', 'guess-the-footballer') . '</label></p>';
        echo '<input type="text" id="gtf_player_name" name="' . esc_attr(self::META_PLAYER_NAME) . '" value="' . esc_attr($value) . '" class="widefat" required />';
    }

    public static function render_player_photo_meta_box($post) {
        $photo_id = (int) get_post_meta($post->ID, self::META_PLAYER_PHOTO, true);
        $preview = '';
        if ($photo_id) {
            $preview = wp_get_attachment_image($photo_id, 'medium', false, array('class' => 'gtf-player-photo-preview-img'));
        }

        $remove_style = $photo_id ? '' : 'style="display:none"';

        echo '<div class="gtf-media-field">';
        echo '<input type="hidden" class="gtf-player-photo-id" name="' . esc_attr(self::META_PLAYER_PHOTO) . '" value="' . esc_attr($photo_id) . '" />';
        echo '<div class="gtf-player-photo-preview">' . $preview . '</div>';
        echo '<div class="gtf-media-actions">';
        echo '<button type="button" class="button gtf-media-select">' . esc_html__('Fotoğraf Seç', 'guess-the-footballer') . '</button>';
        echo '<button type="button" class="button gtf-media-remove" ' . $remove_style . '>' . esc_html__('Fotoğrafı Kaldır', 'guess-the-footballer') . '</button>';
        echo '</div>';
        echo '</div>';
    }

    public static function save_meta($post_id, $post) {
        if (!isset($_POST['gtf_player_meta_nonce']) || !wp_verify_nonce(sanitize_key($_POST['gtf_player_meta_nonce']), 'gtf_save_player_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (self::POST_TYPE !== $post->post_type) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST[self::META_PLAYER_NAME])) {
            $player_name = sanitize_text_field(wp_unslash($_POST[self::META_PLAYER_NAME]));
            update_post_meta($post_id, self::META_PLAYER_NAME, $player_name);
        }

        if (isset($_POST[self::META_PLAYER_PHOTO])) {
            $photo_id = absint($_POST[self::META_PLAYER_PHOTO]);
            update_post_meta($post_id, self::META_PLAYER_PHOTO, $photo_id);
        }
    }

    public static function columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        $new_columns['player_name'] = __('Futbolcu Adı', 'guess-the-footballer');
        $new_columns['player_photo'] = __('Fotoğraf', 'guess-the-footballer');
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }

    public static function column_content($column, $post_id) {
        if ('player_name' === $column) {
            $name = get_post_meta($post_id, self::META_PLAYER_NAME, true);
            echo esc_html($name ? $name : '—');
        }

        if ('player_photo' === $column) {
            $photo_id = (int) get_post_meta($post_id, self::META_PLAYER_PHOTO, true);
            if ($photo_id) {
                echo wp_kses_post(wp_get_attachment_image($photo_id, 'thumbnail'));
            } else {
                echo '—';
            }
        }
    }

    public static function enqueue_admin_assets($hook) {
        global $post_type;
        if (self::POST_TYPE !== $post_type) {
            return;
        }

        if (!in_array($hook, array('post.php', 'post-new.php'), true)) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_script('gtf-admin', GTF_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), GTF_VERSION, true);
        wp_enqueue_style('gtf-admin', GTF_PLUGIN_URL . 'assets/css/admin.css', array(), GTF_VERSION);

        wp_localize_script(
            'gtf-admin',
            'gtfAdmin',
            array(
                'mediaTitle' => __('Fotoğraf seç', 'guess-the-footballer'),
                'mediaButton' => __('Seç', 'guess-the-footballer'),
            )
        );
    }
}
