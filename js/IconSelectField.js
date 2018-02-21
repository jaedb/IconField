/**
 * Icon Selection Field
 * Additional CMS functionality
 * By James Barnsley (james@barnsley.nz, Github: jaedb)
 * Created April 2016
 **/
 
(function($) {
	$.entwine('ss', function($) {
	/*
		// on load, find our currently selected icon
		$('.field.iconselect textarea.data').entwine({
			onmatch: function(){
				if( $(this).html() != '' ){
					var current = $(this).closest('.field').find('data:contains("'+$(this).html()+'")');
					current = current.closest('.option');
					current.addClass('selected');
				}
			}
		});
		
		// functionality for each option
		$('.field.iconselect .option').entwine({
			onclick: function(event) {
			
				var option = $(event.target);
				if( !option.hasClass('option') ) option = option.closest('.option');
				
				// update UI
				option.siblings().removeClass('selected');
				option.addClass('selected');
				
				// parse the data to our field
				var data = option.find('data').html();
				option.closest('.field').find('textarea.data').val( data );
			}
		});
		*/
	})
})(jQuery);