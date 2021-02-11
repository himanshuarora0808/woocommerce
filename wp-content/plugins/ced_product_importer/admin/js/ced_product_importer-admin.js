(function( $ ) {
	'use strict';

    
	$(document).ready(function(){
		
		$('#product_list').change(function(){
			var file_name = $(this).val();
			alert(file_name);
			
			$.ajax({
				url : product_files.ajax_url,
				type : 'post',
				data :{
					action    :'product_files_ajax' ,
					send_file : file_name
				},
				success:function(response) {
					$('#content').html(response);
				}

			});
		});

		$(document).on('click','.import', function(){
			var prod_id=$(this).data('id');
			alert(prod_id);
			var file_name = $('#product_list').val();
			alert(file_name);

			$.ajax({
				url : product_files.ajax_url,
				type : 'post',
				data :{
					action    :'import_files_ajax' ,
					import_file : file_name,
					prod_sku    : prod_id
				},
				success:function(response) {
					alert(response);
					
				}

			});
		});
		
		$(document).on('click','#doaction',function(){
			var file_name = $('#product_list').val();
			var bulk_action = [];
			$("input:checked").each(function(){
				bulk_action.push($(this).val());
			});
			$.ajax({
				url : product_files.ajax_url,
				type : 'post',
				data :{
					action    :'import_bulk_files_ajax' ,
					import_file : file_name,
					bulk_action    : bulk_action
				},
				success:function(response) {
					alert(response);
					
				}

			});
		});


		$(document).on('change','#order_list', function(){
			var order_file = $('#order_list').val();
			$.ajax({
				url : product_files.ajax_url,
				type : 'post',
				data :{
					action    :'create_order_ajax' ,
					order_file : order_file,
				},
				success:function(response) {
					alert(response);
					
				}

			});
		});
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
