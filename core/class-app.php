<?php

namespace HotelRoomScanner;

use HotelRoomScanner\Admin\Core;
use HotelRoomScanner\Frontend\Shortcode;

/**
 * Class App
 * @package HotelRoomScanner
 */
class App {

	/**
	 * @var array
	 */
	public $options = [];

	/**
	 * @var Shortcode
	 */
	protected $shortcode;

	/**
	 * App constructor.
	 */
	public function __construct() {
		if ( is_admin() === true ) {
			$this->init_admin();
		} else {
			$this->init_frontend();
		}

		$this->options = $this->getOptions();
	}

	/**
	 * Init admin
	 */
	public function init_admin() {
		$admin = new Core( $this );
		$admin->init();
	}

	/**
	 * Init frontend
	 */
	public function init_frontend() {
		$this->shortcode = new Shortcode( $this );
	}

	/**
	 * Get the shortcode class
	 *
	 * @return Shortcode
	 */
	public function getShortcode() {
		return $this->shortcode;
	}

	/**
	 * Save the options.
	 *
	 * @return bool
	 */
	public function saveOptions() {
		return update_option( 'hotelroomscanner', $this->options );
	}


	/**
	 * @return array
	 */
	private function getOptions() {
		return get_option( 'hotelroomscanner', [] );
	}

}