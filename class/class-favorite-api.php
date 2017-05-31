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
	private function return_data( $data ) {
		@header( 'Content-Type: application/json' );
		wp_send_json( $data );
	}

	/**
	 * save_or_remove_favorites
	 */
	public function save_or_remove_favorite() {
		$response = array();

		// Get favorites list in cookie
		$favorites = self::get_favorites();

		// Get the submitted id
		$post_id = int( $_POST['post_id'] );

		// Checks if a list of favorites already exists, if it does not create with the submitted ID
		if ( empty( $favorites ) ) {
			$favorites = $post_id;

			// Prepare the data for return
			$response = array( 'stattus' => 'add', 'message' => __( 'Post successfully added to favorites list', 'lb-enjoyed' ) );
		} else { // Favorite list already exists
			// Convert favorites list for array
			$array_favorites = self::convert_cookie_for_array( $favorites );

			// Checks if the submitted post ID is already in the favorites list
			// If it appears it will be removed
			// If not, it will be included
			if ( $is_favorite = self::chek_if_post_is_favorite( $post_id, $favorites ) ) {
				unset( $array_favorites[$is_favorite] );
				if ( ! empty( $array_favorites ) ) {
					$favorites = self::convert_array_for_cookie( $array_favorites );
				}

				// Prepare the data for return
				$response = array( 'stattus' => 'add', 'message' => __( 'Post successfully removed the list of favorites', 'lb-enjoyed' ) );
			} else {
				$favorites .= ',' . $post_id;

				// Prepare the data for return
				$response = array( 'stattus' => 'add', 'message' => __( 'Post successfully added to favorites list', 'lb-enjoyed' ) );
			}
		}
		self::save_cookie( $favorites );
		return self::return_data( $response );
	}
} // End class Favorite_API
