<?php
/**
 * Plugin Name: Guess The Footballer
 * Description: Bulanık futbolcu fotoğrafından 5 denemede tahmin oyunu.
 * Version: 0.1.0
 * Author: EmrhnEmiroglu
 * Author URI: https://github.com/EmrhnEmiroglu
 * License: GPL-2.0-or-later
 * Text Domain: guess-the-footballer
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

define('GTF_VERSION', '0.1.0');
define('GTF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GTF_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GTF_AJAX_NONCE_ACTION', 'gtf_ajax_nonce');

require_once GTF_PLUGIN_DIR . 'includes/class-footballer-cpt.php';
require_once GTF_PLUGIN_DIR . 'includes/class-ajax-handler.php';

function gtf_init_plugin() {
    if (class_exists('GTF_Footballer_CPT')) {
        GTF_Footballer_CPT::init();
    }

    if (class_exists('GTF_Ajax_Handler')) {
        GTF_Ajax_Handler::init();
    }
}
add_action('plugins_loaded', 'gtf_init_plugin');