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
	 * Add post in favorite list
	 */
	public static function add_post_in_favorite_list() {
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
			$is_favorite = self::chek_if_post_is_favorite( $post_id, $favorites );
			if ( ! is_bool ($is_favorite ) ) {
				$response = array( 'status' => 'error', 'message' => __( 'This post is already on the list of favorites', 'lb-enjoyed' ) );
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

	/**
	 * Remove post in favorite list
	 */
	public static function remove_post_in_favorite_list() {
		$response = array();

		// Get favorites list in cookie
		$favorites = self::get_favorites();

		// Get the submitted id
		$post_id = intval( $_POST['post_id'] );

		// Checks if the submitted post ID is already in the favorites list
		$is_favorite = self::chek_if_post_is_favorite( $post_id, $favorites );

		// Checks if a list of favorites already exists, if it does not create with the submitted ID
		if ( empty( $favorites ) || is_bool( $is_favorite ) ) {
			$response = array( 'status' => 'error', 'message' => __( 'The post is not part of the list of favorites', 'lb-enjoyed' ) );
			return self::return_data( $response );
		}

		unset( $favorites[$is_favorite] );
		if ( ! empty( $favorites ) ) {
			$favorites = self::convert_array_for_cookie( $favorites );
		} else {
			$favorites = '';
		}

		// Prepare the data for return
		$response = array( 'status' => 'remove', 'message' => __( 'Post successfully removed the list of favorites', 'lb-enjoyed' ) );

		self::save_cookie( $favorites );
		return self::return_data( $response );
	}

	/**
	 * Get Favorites
	 */
	public static function get_favorites_list() {
		$favorites = self::get_favorites();
	}
} // End class Favorite_API
