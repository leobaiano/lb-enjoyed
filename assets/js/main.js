(function($) {
	$(document).ready(function() {
		// Get the Ajax URL and Home URL passed by wp_localize_script
		var ajax_url = data.ajax_url;
		var home_url = data.home_url;

		/**
		 * Add post in favorite list
		 *
		 * @param int post_id Post ID
		 */
		function add_post_in_favorite_list( post_id ) {
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: {
						"action": 	"add_post_in_favorite_list",
						"post_id": 	post_id
					},
				success: function ( response ) {
					if ( response.status == 'add' ) {
						$( 'a[data-post-id="' + post_id + '"]' ).addClass( 'active' );
						$( 'a[data-post-id="' + post_id + '"]' ).removeClass( 'inactive' );
					} else {
						console.log( response.status + ': ' + response.message );
					}
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					console.log( textStatus, errorThrown );
				}
			});
		}

		/**
		 * Remove post in favorite list
		 *
		 * @param int post_id Post ID
		 */
		function remove_post_in_favorite_list( post_id ) {
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: {
						"action": 	"remove_post_in_favorite_list",
						"post_id": 	post_id
					},
				success: function ( response ) {
					if ( response.status == 'remove' ) {
						$( 'a[data-post-id="' + post_id + '"]' ).removeClass( 'active' );
						$( 'a[data-post-id="' + post_id + '"]' ).addClass( 'inactive' );
					} else {
						console.log( response.status + ': ' + response.message );
					}
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					console.log( textStatus, errorThrown );
				}
			});
		}

		/**
		 * Action when inactive favorite icon receives a click
		 */
		$( document ).on( 'click', '.lb_favorite_container .inactive', function() {
			const post_id = $( this ).data( 'post-id' );
			add_post_in_favorite_list( post_id );
		});

		/**
		 * Action when active favorite icon receives a click
		 */
		$( document ).on( 'click', '.lb_favorite_container .active', function() {
			const post_id = $( this ).data( 'post-id' );
			remove_post_in_favorite_list( post_id );
		});
	});
})(jQuery);
