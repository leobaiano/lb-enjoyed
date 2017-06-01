<?php
/**
 * Favorite_API
 *
 * @package LB Enjoyed
 * @category Core
 * @author Leo Baiano <ljunior2005@gmail.com>
 */

namespace LBEnjoyed;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Favorite_API extends Favorite {
	/**
	 * Return Data
	 *
	 * @param array $data
	 * @return json
	 */
	private static function return_data( $data ) {
		@header( 'Content-Type: application/json' );
		wp_send_json( $data );
	}

	/**
	 * Add or remove post id in favorite list
	 */
	public static function add_or_remove_post_in_favorite_list() {
		$response = array();

		// Get favorites list in cookie
		$favorites = self::get_favorites();

		// Get the submitted id
		$post_id = intval( $_POST['post_id'] );

		// Checks if a list of favorites already exists, if it does not create with the submitted ID
		if ( empty( $favorites ) ) {
			$favorites = $post_id;

			// Prepare the data for return
			$response = array( 'status' => 'add', 'message' => __( 'Post successfully added to favorites list', 'lb-enjoyed' ) );
		} else { // Favorite list already exists

			// Checks if the submitted post ID is already in the favorites list
			// If it appears it will be removed
			// If not, it will be included
			$is_favorite = self::chek_if_post_is_favorite( $post_id, $favorites );
			if ( ! is_bool ($is_favorite ) ) {
				unset( $favorites[$is_favorite] );
				if ( ! empty( $favorites ) ) {
					$favorites = self::convert_array_for_cookie( $favorites );
				} else {
					$favorites = '';
				}

				// Prepare the data for return
				$response = array( 'status' => 'remove', 'message' => __( 'Post successfully removed the list of favorites', 'lb-enjoyed' ) );
			} else {
				$favorites = self::convert_array_for_cookie( $favorites );
				$favorites .= '-' . $post_id;

				// Prepare the data for return
				$response = array( 'status' => 'add', 'message' => __( 'Post successfully added to favorites list', 'lb-enjoyed' ) );
			}
		}
		self::save_cookie( $favorites );
		return self::return_data( $response );
	}
} // End class Favorite_API
