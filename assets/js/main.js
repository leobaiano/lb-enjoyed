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
		 * Updates favorites list in Widget
		 */
		function update_favorite_list_in_widget_and_short_code() {
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: {
						"action": 	"get_favorite_list",
					},
				success: function ( response ) {
					var html = '';
					if ( ! response.status && response.status !== 'empty' ) {
						jQuery.each(response, function( key, value ){
							html += '<li class="post-id-' + value.post_id + '"><a href="' + value.post_link+ '" title="' + value.post_title + '">' + value.post_title + '</li>';
						});
					} else {
						html = '<li>You do not have any posts added to favorites.</li>';
					}
					$( '.lb_favorite_widget_container' ).html( html );
					$( '.lb_favorite_shortcode_container' ).html( html );
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
			setTimeout(function(){
				update_favorite_list_in_widget_and_short_code();
			}, 1000);
		});

		/**
		 * Action when active favorite icon receives a click
		 */
		$( document ).on( 'click', '.lb_favorite_container .active', function() {
			const post_id = $( this ).data( 'post-id' );
			remove_post_in_favorite_list( post_id );
			setTimeout(function(){
				update_favorite_list_in_widget_and_short_code();
			}, 1000);
		});
	});
})(jQuery);
