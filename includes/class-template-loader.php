<?php

/**
 * Sayfa şablonu kaydı ve frontend varlıkları.
 */

defined('ABSPATH') || exit;

class GTF_Template_Loader {
    const TEMPLATE_SLUG = 'gtf-guess-footballer.php';

    public static function init() {
        add_filter('theme_page_templates', array(__CLASS__, 'register_template'));
        add_filter('template_include', array(__CLASS__, 'load_template'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_assets'));
    }

    public static function register_template($templates) {
        $templates[self::TEMPLATE_SLUG] = __('Guess Footballer Template', 'guess-the-footballer');
        return $templates;
    }

    public static function load_template($template) {
        if (!is_page()) {
            return $template;
        }

        $post_id = get_queried_object_id();
        if (!$post_id) {
            return $template;
        }

        $selected = get_page_template_slug($post_id);
        if (self::TEMPLATE_SLUG !== $selected) {
            return $template;
        }

        $plugin_template = GTF_PLUGIN_DIR . 'templates/page-guess-footballer.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }

        return $template;
    }

    public static function enqueue_assets() {
        if (!self::is_template()) {
            return;
        }

        wp_enqueue_style('gtf-frontend', GTF_PLUGIN_URL . 'assets/css/frontend.css', array(), GTF_VERSION);
        wp_enqueue_script('gtf-game', GTF_PLUGIN_URL . 'assets/js/game.js', array(), GTF_VERSION, true);

        wp_localize_script(
            'gtf-game',
            'gtfGame',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce(GTF_AJAX_NONCE_ACTION),
                'maxAttempts' => 5,
                'blurLevels' => array(20, 15, 10, 5, 0),
                'strings' => array(
                    'missingGuess' => __('Lütfen bir tahmin yaz.', 'guess-the-footballer'),
                    'loadError' => __('Futbolcu yüklenemedi. Tekrar dene.', 'guess-the-footballer'),
                    'wrongGuess' => __('Yanlış tahmin!', 'guess-the-footballer'),
                    'correctGuess' => __('Doğru bildin!', 'guess-the-footballer'),
                    'gameOver' => __('Oyun bitti.', 'guess-the-footballer'),
                    'newGame' => __('Yeni Oyun', 'guess-the-footballer'),
                ),
            )
        );
    }

    private static function is_template() {
        if (!is_page()) {
            return false;
        }

        $post_id = get_queried_object_id();
        if (!$post_id) {
            return false;
        }

        return get_page_template_slug($post_id) === self::TEMPLATE_SLUG;
    }
}