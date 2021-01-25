(function( $ ) {
	'use strict';

	$( document ).ready(
		function(){
			$( "[name='radio_buttons']" ).hide();

			$( '#wholesale_checkbox' ).click(
				function(){
					if ($( '#wholesale_checkbox' ).prop( 'checked' ) == true) {
						$( "[name='radio_buttons']" ).show();
					} else {
						$( "[name='radio_buttons']" ).hide();
					}
				}
			);

			$( "[name='inventory_radio_buttons']" ).hide();

			$( '#invetory_checkbox' ).click(
				function(){
					if ($( '#invetory_checkbox' ).prop( 'checked' ) == true) {
						$( "[name='inventory_radio_buttons']" ).show();
					} else {
						$( "[name='inventory_radio_buttons']" ).hide();
					}
				}
			);
			$( '#common_min_quantity' ).keyup(
				function(){
					var min_quantity = $( '#common_min_quantity' ).val()
					if (min_quantity < 1) {
						alert( "Minimum quantity should be greater than 1" );
					}
				}
			);
			$( '#_wholesale_price' ).mouseleave(
				function(){
					var original  = $( '#_regular_price' ).val();
					var wholesale = $( '#_wholesale_price' ).val();
					if (original <= wholesale) {
						alert( 'Wholesale Price cannot be greater than or equal to Regular Price' );
						$( '#_wholesale_price' ).val( '' );
					}
				}
			);
		}
	);
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
