<?php
/*
Plugin Name: PaySum Checkout
Description: Add a PaySum payment button to a WordPress page.
Version: 0.1.0
Requires PHP: 7.4
Author: PaySum
License: GPL-2.0-or-later
*/

defined('ABSPATH') || exit;

add_shortcode('paysum_checkout', static function ($attributes): string {
    $attributes = shortcode_atts(['url' => '', 'label' => 'Buy now'], $attributes, 'paysum_checkout');
    $url = wp_parse_url($attributes['url']);
    if (!is_array($url) || ($url['scheme'] ?? '') !== 'https'
        || !preg_match('/^[a-z0-9-]+\.mypaysum\.io$/iD', $url['host'] ?? '')
        || isset($url['user']) || isset($url['pass']) || isset($url['port'])) {
        return '';
    }
    return sprintf(
        '<a class="wp-element-button paysum-checkout" href="%s">%s</a>',
        esc_url($attributes['url']),
        esc_html($attributes['label'])
    );
});
