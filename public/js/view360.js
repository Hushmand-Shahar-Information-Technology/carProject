( function( $ ) {
	"use strict";

	$(document).ready(function() {

		/***************************************
		:: 360 Popup
		***************************************/

		$('.modal-popup-vehicle-view360').on('shown.bs.modal', function () {
			var dataFolder = $(this).find('.cloudimage-360-data').data('360-folder');
			var dataImages = $(this).find('.cloudimage-360-data').data('360-images');
			var dataNumber = $(this).find('.cloudimage-360-data').data('360-number');
	    
			$('.cloudimage-360-main').html(`
				<div class="cloudimage-360" data-folder="${dataFolder}" data-filename-x="${dataImages}" data-amount-x="${dataNumber}"></div>
			`);
	    
			window.CI360.init();
	  	});

		$('.modal-popup-vehicle-view360').on('hidden.bs.modal', function () {
			$('.cloudimage-360-main').empty();
		});
	});

}( jQuery ) );
