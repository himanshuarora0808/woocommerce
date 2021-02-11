(function( $ ) {
	'use strict';

	$(document).ready(function(){
		$(document).on('click','#save',function(){
			var appkey = $('#appkey').val();
			var appsecret = $('#appsecret').val();
			var redirect_url = 'http://localhost/woo_wordpress/wp-admin/admin.php?page=dropbox';
			var url = 'https://www.dropbox.com/oauth2/authorize?client_id='+appkey+'&redirect_uri='+redirect_url+'&response_type=code';
			window.open(url);
		});
		// $(document).on('click','#authenticate',function(){
		// 	var auth_code = $('#auth_code').val();
		// 	var app_secret = $('#appsecret').val();
		// 	var redirect_uri_token = 'http://localhost/woo_wordpress/wp-admin/admin.php?page=dropbox';

		// });
	});
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
