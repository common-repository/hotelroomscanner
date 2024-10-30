<?php

namespace HotelRoomScanner\Admin;

use HotelRoomScanner\App;

/**
 * Class Render
 * @package HotelRoomScanner\Admin
 */
class Render {

	/**
	 * @var App
	 */
	private $app;

	/**
	 * Render constructor.
	 *
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->app = $app;
	}

	/**
	 * Render the settings page
	 */
	public function buildSettingsPage() {
		if ( isset( $_POST['hotelroom_form_nonce'] ) && wp_verify_nonce( $_POST['hotelroom_form_nonce'], 'hotelroom_form_nonce' ) ) {
			$api_key = trim( $_POST['hotelroom']['google_maps_api_key'] );

			$api_key = sanitize_text_field( $api_key );

			if ( !empty( $api_key ) && strlen( $api_key ) >= 20 ) {
				$this->app->options['google_maps_api_key'] = $api_key;
				$this->app->saveOptions();

				echo $this->admin_notice_success( __( 'Your settings are saved successfully! You can now use the HotelRoomScanner plugin for WordPress.', 'hotelroomscanner' ) );
			} else {
				echo $this->admin_notice_error( __( 'Please enter a valid API key.', 'hotelroomscanner' ) );
			}
		} elseif ( isset( $_POST['hotelroom_form_nonce'] ) && !wp_verify_nonce( $_POST['hotelroom_form_nonce'], 'hotelroom_form_nonce' ) ) {
			// validation error
			echo $this->admin_notice_error( __( 'Could not validate the security fields. Please try again.', 'hotelroomscanner' ) );
		}

		if ( isset( $this->app->options['google_maps_api_key'] ) ) {
			$api_key = $this->app->options['google_maps_api_key'];
		}

		echo $this->templateSettings( [
			'title'   => 'HotelRoomScanner',
			'api_key' => $api_key,
		] );
	}

	/**
	 * Return the html for the settings page. To be refactored, soon.
	 *
	 * @param array $vars
	 *
	 * @return string
	 */
	private function templateSettings( $vars = [] ) {
		$html = '<div class="wrap">';
		$html .= '<h1>' . $vars['title'] . '</h1>';

		$html .= '<form method="post">';
		$html .= wp_nonce_field( 'hotelroom_form_nonce', 'hotelroom_form_nonce', true, false );
		$html .= '<div class="card">';
		$html .= '<h2>' . __( 'Usage of the HotelRoomScanner plugin', 'hotelroomscanner' ) . '</h2>';
		$html .= '<p>' . __( 'With a simple shortcode, you can display a Google Map with the nearest accommodations. The Google Map will be populated with hotels, B&B\'s, hostels and resorts. You can change the default location by adjusting the latitude and longitude coordinates in the shortcode arguments.', 'hotelroomscanner' ) . '</p>';
		$html .= '<p><strong>' . __( 'Use this simple shortcode to display an interactive Google Map on your website:', 'hotelroomscanner' ) . '</strong><br />';
		$html .= '<code>[hotelroomscanner lat="51.4521" long="4.3624"]</code></p>';
		$html .= '</div>';

		$html .= '<div class="card">';
		$html .= '<h2>' . __( 'Google Maps API key', 'hotelroomscanner' ) . '</h2>';
		$html .= '<p>' . sprintf(
				__( 'In order to use the maps functionality, you\' need to enter a free Google Maps API key. You can request a key at <a href="%s" target="_blank">Google\'s support pages</a> and click the <code>[Get a key]</code> button.', 'hotelroomscanner' ),
				'https://developers.google.com/maps/documentation/javascript/get-api-key#key'
			) . '</p>';
		$html .= '<p><strong>' . __( 'Your Google Maps API key:', 'hotelroomscanner' ) . '</strong><br />';
		$html .= '<input type="text" name="hotelroom[google_maps_api_key]" value="' . $vars['api_key'] . '" class="regular-text" style="margin-right: 15px;" />';
		$html .= '<input type="submit" name="submit" id="submit" class="button button-primary" value="' . __( 'Save Changes' ) . '"></p>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</form>';

		return $html;
	}

	/**
	 * Show an admin success notice
	 */
	public function admin_notice_success( $message ) {
		$class = 'notice notice-success';

		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}

	/**
	 * Show an admin error
	 */
	public function admin_notice_error( $message ) {
		$class = 'notice notice-error';

		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
}