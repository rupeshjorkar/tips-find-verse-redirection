<?php
/**
 * The plugin is Used Find Verse using TIPs Search Widget  
 *
 * @link              https://www.c-metric.com/
 * @since             1.2.3
 * @package           tips-auth
 *
 * @wordpress-plugin
 * Plugin Name:       TIPs: Find verse widget 
 * Plugin URI:        https://www.c-metric.com/
 * Description:       The Plugin allows you to quickly search for and find specific verses by redirecting users to the TIPs site. Using the shortcode [tips_find_verse], you can easily integrate a search feature into any page or post. Alternatively, you can utilize the TIPs Search Widget to provide users with a seamless search experience directly from your site.
 * Version:           1.2.3
 * Author:            cmetric
 * Author URI:        https://www.c-metric.com/
 * License:           GPL-2.0+
 */
// If this file is called directly, abort.

if (! defined( 'ABSPATH' ) ) {
    die( "Please don't try to access this file directly." );
}
if ( ! defined( 'PLUGIN_NAME' ) ) {
    define( 'PLUGIN_NAME', 'tips-find-widget' );
}
if ( ! defined( 'TIPS_FIND_VERSE_VERSION' ) ) {
    define( 'TIPS_FIND_VERSE_VERSION', '1.2.3' );
}

if ( ! defined( 'TIPS_FIND_VERSE_PLUGIN_URL' ) ) {
    define( 'TIPS_FIND_VERSE_PLUGIN_URL', __FILE__ );
}

if ( ! defined( 'TIPS_FIND_VERSE_DIR' ) ) {
    define( 'TIPS_FIND_VERSE_DIR', plugin_dir_path( TIPS_FIND_VERSE_PLUGIN_URL ) );
}

if ( ! defined( 'TIPS_FIND_VERSE_URL' ) ) {
    define( 'TIPS_FIND_VERSE_URL', plugin_dir_url( __FILE__ )  );
}

if ( ! defined( 'TIPS_FIND_VERSE_BASENAME' ) ) {

    define( 'TIPS_FIND_VERSE_BASENAME', plugin_basename( TIPS_FIND_VERSE_PLUGIN_URL ) );

}
if ( ! defined( 'TIPS_FIND_VERSE_TEXT_DOMAIN' ) ) {
    define( 'TIPS_FIND_VERSE_TEXT_DOMAIN', 'tips-find-verse' );
}

if ( ! defined( 'TIPS_FIND_VERSE_SLUG' ) ) {
    define( 'TIPS_FIND_VERSE_SLUG', 'tips-find-verse' );
}

$plugin_slug = TIPS_FIND_VERSE_SLUG;


require_once plugin_dir_path(__FILE__) . 'includes/class-tips-find-settings.php';

require_once plugin_dir_path(__FILE__) . 'includes/class-tips-find-verse.php';


require_once plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://cmetricbeta.c-metric.com/bible-tips-plugin/tips-find-verse.json',
    __FILE__, 
    'tips-find-verse'
);