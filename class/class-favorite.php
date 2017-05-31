<?php
/**
 * LB Enjoyed Favorite
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
	 */
	public static function hook_insert_favorite_icon_in_post_content( $content ) {
		$favorite_content = '';
		$favorite_icon = apply_filters( 'lb_enjoyed_icon', 'grade' );
		$favorite_position = apply_filters( 'lb_enjoyed_location_icon', 'after' );
		$css_class = apply_filters( 'lb_enjoyed_container_classes_css', array( 'lb_enjoyed_container' ) );
		$css_class = implode( ' ', $css_class );

		if ( $favorite_position !== 'after' && $favorite_position !== 'before' && $favorite_position !== 'both' ) {
			$favorite_position = 'after';
		}

		$favorite_content .= '<div class="' . $css_class . '">';
			$favorite_content .= '<a href="javascript:;" title="' . __( 'Favorite post', 'lb-enjoyed' ) . '">';
				$favorite_content .= '<i class="material-icons">' . $favorite_icon . '</i> ' . __( 'Favorite', 'lb-enjoyed' );
			$favorite_content .= '</a>';
		$favorite_content .= '</div>';

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
	 */
	public static function chek_if_post_is_favorite( $post_id, $favorites ) {
		$exist = array_search( $post_id, $favorites );
		if ( ! is_bool( $exist ) ) {
			return true;
		}
		return false;
	}
} // end class LB_Enjoyed_Favorite();
