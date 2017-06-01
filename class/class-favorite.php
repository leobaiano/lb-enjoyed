<?php
/**
 * Favorite
 *
 * @package LB Enjoyed
 * @category Core
 * @author Leo Baiano <ljunior2005@gmail.com>
 */

namespace LBEnjoyed;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Favorite {
	/**
	 * Add icone to bookmark post on post content
	 *
	 * @since  0.1.0
	 */
	public static function hook_insert_favorite_icon_in_post_content( $content ) {
		$favorite_content = '';
		$favorite_icon = apply_filters( 'lb_favorite_icon', 'grade' );
		$favorite_position = apply_filters( 'lb_favorite_location_icon', 'after' );
		$css_class = apply_filters( 'lb_favorite_container_classes_css', array( 'lb_favorite_container' ) );
		$css_class = implode( ' ', $css_class );

		if ( $favorite_position !== 'after' && $favorite_position !== 'before' && $favorite_position !== 'both' ) {
			$favorite_position = 'after';
		}

		// Block with the content of the favorite icon
		$favorite_content .= '<div class="' . $css_class . '">';
			if ( self::chek_if_post_is_favorite( get_the_ID(), self::get_favorites() ) ) {
				$favorite_content .= '<a href="javascript:;" title="' . __( 'Favorite post', 'lb-enjoyed' ) . '" class="active" data-post-id="' . get_the_ID() . '">';
			} else {
				$favorite_content .= '<a href="javascript:;" title="' . __( 'Favorite post', 'lb-enjoyed' ) . '" data-post-id="' . get_the_ID() . '">';
			}
				$favorite_content .= '<i class="material-icons">' . $favorite_icon . '</i> ' . __( 'Favorite', 'lb-enjoyed' );
			$favorite_content .= '</a>';
		$favorite_content .= '</div>';

		// Return the content of the post with the favorite icon
		switch ( $favorite_position ) {
			case 'before':
				return $favorite_content . $content;
				break;
			case 'both':
				return $favorite_content . $content . $favorite_content;
				break;
			case 'after':
			default:
				return $content . $favorite_content;
				break;
		}
		return $content;
	}

	/**
	 * Check if post is favorit
	 *
	 * @param int $post_id Post ID
	 * @param array $favorites List of favorite user posts saved in the cookie
	 * @return boolean True if the post is on the list of favorites
	 *
	 * @since  0.1.0
	 */
	public static function chek_if_post_is_favorite( $post_id, $favorites ) {
		if ( ! empty( $post_id ) && ! empty ( $favorites ) ) {
			$exist = array_search( $post_id, $favorites );
			if ( ! is_bool( $exist ) ) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	/**
	 * Get a list of favorite visitors
	 *
	 * @return boolean/array If there are favorites it returns the list, else it returns false
	 *
	 * @since  0.1.0
	 */
	public static function get_favorites() {
		if ( ! isset( $_COOKIE['lb-enjoyed'] ) ) {
			return false;
		}

		return $_COOKIE['lb-enjoyed'];
	}

	/**
	 * Save Cookie
	 *
	 * @param array $favorite_list Array with id of the favorite posts separated by commas
	 *
	 * @since  0.1.0
	 */
	public static function save_cookie( $favorite_list ) {
		if ( isset( $_COOKIE['lb-enjoyed'] ) ) {
			unset( $_COOKIE['lb-enjoyed'] );
		}
		@setcookie( 'lb-enjoyed', $favorite_list, time() + 3600, "/" );
	}
} // end class LB_Enjoyed_Favorite();
