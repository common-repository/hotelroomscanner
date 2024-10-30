<?php
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * Class HotelRoomScannerMapsWidget
 */
class HotelRoomScannerMapsWidget extends \WP_Widget {

	/**
	 * Construct the widget
	 */
	public function __construct() {
		parent::__construct( false, 'Hotel Room - Map ', array(
			'description' => __( 'Show a Google Map with the nearest hotels from HotelRoomScanner.com.', 'hotelroomscanner' ),
		) );
	}

	/**
	 * Output the widget
	 *
	 * @param $args
	 * @param $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo '<div id="map" style="width:100%;"></div>';
		echo "<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>";
		echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA17T73tuuVwUf5q_mNZOi4J0iVeatvx9U&callback=initMap" async defer></script>';
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}

}