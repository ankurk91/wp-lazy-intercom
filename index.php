<?php

namespace Ankur\Plugins\LazyIntercom;

/**
 * Plugin Name: Lazy Intercom
 * Plugin URI: https://github.com/ankurk91/wp-lazy-intercom
 * Description: Lazy load intercom widget
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.1
 * Author: Ankur Kumar
 * Author URI: https://ankurk91.github.io/
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

// No direct access
if (!defined('ABSPATH')) {
    die;
}

define('LIC_PLUGIN_VERSION', '1.0.0');
define('LIC_BASE_FILE', __FILE__);


if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
    require __DIR__.'/inc/class-admin.php';
    new Admin();
} else {
    require __DIR__.'/inc/class-frontend.php';
    new Frontend();
}
