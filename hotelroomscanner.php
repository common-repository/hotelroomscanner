<?php
/**
 * Plugin Name: HotelRoomScanner
 * Plugin URI: https://hotelroomscanner.com
 * Description: Find the nearest hotels using a widget with latitude and longitude coordinates, or by using the Google Maps integration. This plugin uses the free live data API from HotelRoomScanner.com.
 * Author: HotelRoomScanner
 * Version: 1.0.0
 * Requires at least: 4.2
 * Author URI: https://hotelroomscanner.com
 * License: GPL v3
 * Text Domain: hotelroomscanner
 * Domain Path: /languages
 */

namespace HotelRoomScanner;

require( 'vendor/autoload.php' );

define( 'SM_WP_VERSION', '1.0.0' );
define( 'SM_WP_ROOT_PATH', __FILE__ );
define( 'SM_WP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'SM_WP_PLUGIN_ROOT', dirname( plugin_basename( __FILE__ ) ) );

new App();