(function($) {
	$(document).ready(function() {
		// Get the Ajax URL and Home URL passed by wp_localize_script
		var ajax_url = data.ajax_url;
		var home_url = data.home_url;

		/**
		 * Add or remove post in favorite list
		 */
		$( '.lb_favorite_container a' ).on( 'click', function() {
			const post_id = $( this ).data( 'post-id' );

			$.ajax({
				type: "POST",
				url: ajax_url,
				data: {
						"action": 	"save_or_remove_favorite",
						"post_id": 	post_id
					},
				success: function ( response ) {
					if ( response.status == 'add ' ) {
						$( '.lb_favorite_container a' ).addClass( 'active' );
					} else {
						$( '.lb_favorite_container a' ).removeClass( 'active' );
					}
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					console.log( textStatus, errorThrown );
				}
			});
		});
	});
})(jQuery);
