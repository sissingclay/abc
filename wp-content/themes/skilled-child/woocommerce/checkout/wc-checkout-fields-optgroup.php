<?php

/**
 * Plugin Name: Add optgroup support to WooCommerce select form fields
 * Description: Converts <code>Group: Option</code> syntax in WooCommerce select form fields into <code>&lt;optgroup...&gt;&lt;option...&gt;</code>
 * Author: QWp6t
 * Author URI: https://qwp6t.me/
 */

/** NOTE: This shit was quickly hacked together. Worked for me. YMMV. */ 
add_filter('woocommerce_form_field_select', function ($html, $unused, $args, $value) {
    if (empty($args['options'])) {
        return $html;
    }

    $option_groups = ['-' => []];
    $options = '';

    foreach ($args['options'] as $option_key => $option_text) {
        $option = array_map('trim', explode(':', $option_text));
        if (count($option) >= 2) {
            $option_groups[array_shift($option)][$option_key] = implode(':', $option);
        } else {
            $option_groups['-'][$option_key] = $option[0];
        }
    }

    foreach ($option_groups as $group => $option) {
        if ($group !== '-') $options .= '<optgroup label="' . esc_attr($group) . '">';
        foreach ($option as $option_key => $option_text) {
            if ($option_key === '') {
                // If we have a blank option, select2 needs a placeholder
                if (empty($args['placeholder'])) {
                    $args['placeholder'] = $option_text ?: __( 'Choose an option', 'woocommerce' );
                }
                $custom_attributes[] = 'data-allow_clear="true"';
            }
            $options .= '<option value="' . esc_attr($option_key) . '" '. selected($value, $option_key, false) . '>' . esc_attr($option_text) . '</option>';
        }
        if ($group !== '-') $options .= '</optgroup>';
    }

    return preg_replace('/(?:<select[^>]+>)\\K(.*)(?:<\\/option>)/s', $options, $html);
}, 10, 4);
