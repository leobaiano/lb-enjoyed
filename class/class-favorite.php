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
		$favorite_position = apply_filters( 'lb_favorite_location_icon', 'after' );
		if ( $favorite_position !== 'after' && $favorite_position !== 'before' && $favorite_position !== 'both' ) {
			$favorite_position = 'after';
		}

		$favorite_content = self::genarate_template_html_for_favorite_icon( get_the_ID() );

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
	 * Template HTML for view favorite icon
	 *
	 * @param int $post_id POST id
	 * @return strin Template HTML
	 */
	public static function genarate_template_html_for_favorite_icon( $post_id ) {
		$favorite_content = '';
		$favorite_icon = apply_filters( 'lb_favorite_icon', 'grade' );
		$css_class = apply_filters( 'lb_favorite_container_classes_css', array( 'lb_favorite_container' ) );
		$css_class = implode( ' ', $css_class );

		$favorite_content .= '<div class="' . $css_class . '">';
			if ( ! is_bool( self::chek_if_post_is_favorite( get_the_ID(), self::get_favorites() ) ) ) {
				$favorite_content .= '<a href="javascript:;" title="' . __( 'Favorite post', 'lb-enjoyed' ) . '" class="active" data-post-id="' . get_the_ID() . '">';
			} else {
				$favorite_content .= '<a href="javascript:;" title="' . __( 'Favorite post', 'lb-enjoyed' ) . '" data-post-id="' . get_the_ID() . '">';
			}
				$favorite_content .= '<i class="material-icons">' . $favorite_icon . '</i> ' . __( 'Favorite', 'lb-enjoyed' );
			$favorite_content .= '</a>';
		$favorite_content .= '</div>';

		return $favorite_content;
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
			$position = array_search( $post_id, $favorites );
			if ( ! is_bool( $position ) ) {
				return $position;
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

		return self::convert_cookie_for_array( $_COOKIE['lb-enjoyed'] );
	}

	/**
	 * Convert Cookie to array
	 *
	 * @param string $cookie_lb_enjoyed Cookie with ids of favorite posts
	 * @return array Array with ids of favorite posts
	 *
	 * @since  0.1.0
	 */
	public static function convert_cookie_for_array( $cookie_lb_enjoyed ) {
		return explode( '-', $cookie_lb_enjoyed );
	}

	/**
	 * Convert array to cookie
	 *
	 * @param array $array_lb_enjoyed Array with ids of favorite posts
	 * @return string Text with ids of favorite posts
	 */
	public static function convert_array_for_cookie( $array_lb_enjoyed ) {
		return implode( '-', $array_lb_enjoyed );
	}

	/**
	 * Save Cookie
	 *
	 * @param string $favorite_list String with id of the favorite posts separated by commas
	 *
	 * @since  0.1.0
	 */
	public static function save_cookie( $text ) {
		if ( isset( $_COOKIE['lb-enjoyed'] ) ) {
			unset( $_COOKIE['lb-enjoyed'] );
		}
		@setcookie( 'lb-enjoyed', $text, time() + 3600, "/" );
	}
} // end class LB_Enjoyed_Favorite();
