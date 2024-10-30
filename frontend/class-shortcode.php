<?php

namespace HotelRoomScanner\Frontend;

use HotelRoomScanner\App;

/**
 * Class Shortcode
 * @package HotelRoomScanner\Frontend
 */
class Shortcode {

	/**
	 * @var App
	 */
	private $app;

	/**
	 * Shortcode constructor.
	 *
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->app = $app;

		add_shortcode( 'hotelroomscanner', array( $this, 'renderMap' ) );
	}

	/**
	 * Render the map by using a shortcode.
	 *
	 * Current arguments:
	 *  - lat
	 *  - long
	 *
	 * @param array $attr
	 *
	 * @return string
	 */
	public function renderMap( $attr = [] ) {
		if ( isset( $this->app->options['google_maps_api_key'] ) && !empty( $this->app->options['google_maps_api_key'] ) ) {
			$api_key = $this->app->options['google_maps_api_key'];

			if ( isset( $attr['lat'] ) && isset( $attr['long'] ) ) {
				$lat  = $attr['lat'];
				$long = $attr['long'];
			} else {
				return '<p><strong>Please set the latitude and longitude.</strong></p>';
			}

			$map = '<div id="map" style="width: 100%;height: 350px;"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById(\'map\'), {
          center: {lat: ' . $lat . ', lng: ' . $long . '},
          zoom: 12
        });
        
        var marker = new google.maps.Marker({
          position: {lat: ' . $lat . ', lng: ' . $long . '},
          map: map,
          title: \'Hello World!\'
        });
      }
      
       function loadJSON() {   
			var xobj = new XMLHttpRequest();
			xobj.overrideMimeType("application/json");
			xobj.open("GET", "https://hotelroomscanner.com/api/hotels/nearest?lat=' . $lat . '&long=' . $long . '", true);
			xobj.onreadystatechange = function () {
				if (xobj.readyState == 4 && xobj.status == "200") {
					setMarkers(xobj.responseText);
				}
			};
			xobj.send(null);  
		 }
		 
		 function setMarkers(json){
			var results = JSON.parse(json).results;
			
			for(var index in results) { 
				var attr = results[index]; 
				
				var latLng = new google.maps.LatLng(attr.latitude, attr.longitude); 
				
				var marker = new google.maps.Marker({
					position: latLng,
					map: map,
					title: attr.name,
					url: attr.url
				});
				
				google.maps.event.addListener(marker, \'click\', function() {
					window.open(this.url, \'_blank\');
				});
			}
		 }
		 
		 loadJSON();
    
    </script>
    <script src="' . esc_url('https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&callback=initMap') . '" async defer></script>';

			return $map;
		}

		return '<p><strong>HotelRoomScanner: No Google Maps API key set. Please configure the key in your admin area.</strong></p>';

	}

}