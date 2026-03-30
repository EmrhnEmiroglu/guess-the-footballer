<?php

/**
 * Oyun mantığı yardımcıları.
 */

defined('ABSPATH') || exit;

class GTF_Game_Logic {
    public static function normalize($string) {
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

    public static function is_correct_guess($guess, $correct_name) {
        return self::normalize($guess) === self::normalize($correct_name);
    }

    public static function blur_levels() {
        return array(20, 15, 10, 5, 0);
    }
}