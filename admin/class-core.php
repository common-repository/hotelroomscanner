<?php

namespace HotelRoomScanner\Admin;

use HotelRoomScanner\App;

/**
 * Class Core
 * @package HotelRoomScanner\Admin
 */
class Core {

	private $app;

	/**
	 * @var Render
	 */
	private $render;

	/**
	 * Core constructor.
	 *
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->app    = $app;
		$this->render = new Render( $app );
	}

	/**
	 * Init the admin panel for HotelRoomScanner
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'hookMenuPage' ) );
	}

	/**
	 * Hook the sub menu items
	 */
	public function hookMenuPage() {
		add_menu_page(
			'HotelRoomScanner ' . __( 'Settings', 'hotelroomscanner' ),
			__( 'Hotel Rooms', 'hotelroomscanner' ),
			'manage_options',
			'hotelroomscanner_settings', [
			$this,
			'showPage',
		],
			plugins_url( '/images/icon_16.png', dirname(__FILE__) ),
			94.89778439
		);
	}

	/**
	 * Render the requested page
	 */
	public function showPage() {
		switch ( filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ) ) {
			case 'hotelroomscanner_settings':
				$this->render->buildSettingsPage();
				break;
		}
	}

}