<?php

/**
 * AJAX handler: rastgele futbolcu ve tahmin doğrulama.
 */

defined('ABSPATH') || exit;

class GTF_Ajax_Handler {
    const ACTION_RANDOM = 'get_random_footballer';
    const ACTION_VALIDATE = 'validate_guess';

    public static function init() {
        add_action('wp_ajax_' . self::ACTION_RANDOM, array(__CLASS__, 'get_random_footballer'));
        add_action('wp_ajax_nopriv_' . self::ACTION_RANDOM, array(__CLASS__, 'get_random_footballer'));

        add_action('wp_ajax_' . self::ACTION_VALIDATE, array(__CLASS__, 'validate_guess'));
        add_action('wp_ajax_nopriv_' . self::ACTION_VALIDATE, array(__CLASS__, 'validate_guess'));
    }

    private static function verify_nonce() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
        $action = defined('GTF_AJAX_NONCE_ACTION') ? GTF_AJAX_NONCE_ACTION : 'gtf_ajax_nonce';

        if (!$nonce || !wp_verify_nonce($nonce, $action)) {
            wp_send_json_error(
                array('message' => __('Geçersiz istek.', 'guess-the-footballer')),
                403
            );
        }
    }

    public static function get_random_footballer() {
        self::verify_nonce();

        $args = array(
            'post_type' => GTF_Footballer_CPT::POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'rand',
            'fields' => 'ids',
            'no_found_rows' => true,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => GTF_Footballer_CPT::META_PLAYER_NAME,
                    'value' => '',
                    'compare' => '!=',
                ),
                array(
                    'key' => GTF_Footballer_CPT::META_PLAYER_PHOTO,
                    'value' => '',
                    'compare' => '!=',
                ),
            ),
        );

        $posts = get_posts($args);

        if (empty($posts)) {
            wp_send_json_error(
                array('message' => __('Uygun futbolcu bulunamadı.', 'guess-the-footballer')),
                404
            );
        }

        $post_id = (int) $posts[0];
        $photo_id = (int) get_post_meta($post_id, GTF_Footballer_CPT::META_PLAYER_PHOTO, true);

        if (!$photo_id) {
            wp_send_json_error(
                array('message' => __('Futbolcu fotoğrafı bulunamadı.', 'guess-the-footballer')),
                404
            );
        }

        $photo_url = wp_get_attachment_image_url($photo_id, 'large');

        if (!$photo_url) {
            wp_send_json_error(
                array('message' => __('Futbolcu fotoğrafı bulunamadı.', 'guess-the-footballer')),
                404
            );
        }

        wp_send_json_success(
            array(
                'id' => $post_id,
                'photo_url' => esc_url_raw($photo_url),
            )
        );
    }

    public static function validate_guess() {
        self::verify_nonce();

        $footballer_id = isset($_POST['footballer_id']) ? absint($_POST['footballer_id']) : 0;
        $guess = isset($_POST['guess']) ? sanitize_text_field(wp_unslash($_POST['guess'])) : '';

        if (!$footballer_id || $guess === '') {
            wp_send_json_error(
                array('message' => __('Eksik veri gönderildi.', 'guess-the-footballer')),
                400
            );
        }

        $correct_name = get_post_meta($footballer_id, GTF_Footballer_CPT::META_PLAYER_NAME, true);

        if (!$correct_name) {
            wp_send_json_error(
                array('message' => __('Futbolcu adı bulunamadı.', 'guess-the-footballer')),
                404
            );
        }

        $is_correct = self::normalize($guess) === self::normalize($correct_name);

        wp_send_json_success(
            array(
                'is_correct' => $is_correct,
                'correct_name' => $correct_name,
            )
        );
    }

    private static function normalize($string) {
        $string = trim($string);

        if (function_exists('mb_strtolower')) {
            $string = mb_strtolower($string, 'UTF-8');
        } else {
            $string = strtolower($string);
        }

        $replacements = array(
            'ı' => 'i', 'İ' => 'i',
            'ğ' => 'g', 'Ğ' => 'g',
            'ü' => 'u', 'Ü' => 'u',
            'ş' => 's', 'Ş' => 's',
            'ö' => 'o', 'Ö' => 'o',
            'ç' => 'c', 'Ç' => 'c',
        );

        return strtr($string, $replacements);
    }
}