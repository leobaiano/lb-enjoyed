<?php
/**
 * Shortcode Favorite List
 *
 * @package LB Enjoyed
 * @category Core
 * @author Leo Baiano <ljunior2005@gmail.com>
 */

namespace LBEnjoyed;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Shortcode_Favorite_List {

	/**
	 * Favorite list.
	 *
	 * @var array $favorites
	 */
	protected static $favorites;

	public function __construct() {
		// Get Favorites
		self::$favorites = self::get_favorite_list();
	}

	public static function ShowOfFavorites() {
		$css_class = apply_filters( 'lb_favorite_shortcode_classes_css', array( 'lb_favorite_shortcode_container' ) );
		$css_class = implode( ' ', $css_class );

		$view .= '<ul class="' . $css_class . '">';
			if ( ! empty( self::$favorites ) ) {
        		foreach ( self::$favorites as $favorite ) {
        			echo '<li class="post-id-' . $favorite['post_id'] .  '"><a href="' . $favorite['post_link'] . '" title="' . $favorite['post_title'] . '">' . $favorite['post_title'] . '</li>';
        		}
        	} else {
        		echo '<li>' . __( 'You do not have any posts added to favorites.', 'lb-enjoyed' ) . '</li>';
        	}
		$view .= "</ul>";
	}

	/**
	 * Get Favorites
	 *
	 * @return Return array with favorite list or false
	 *
	 * @since  0.1.0
	 */
	public static function get_favorite_list() {
		if ( ! isset( $_COOKIE['lb-enjoyed'] ) ) {
			return false;
		}

		if ( isset( $_COOKIE['lb-enjoyed'] ) && ! empty( $_COOKIE['lb-enjoyed'] ) ) {
			$id_posts_favorites = explode( '-', $_COOKIE['lb-enjoyed'] );
			if ( ! empty( $id_posts_favorites ) ) {
				$favorite_list = array();
				foreach( $id_posts_favorites as $post_id ) {
					$post_favorite = array(
											'post_id'		=> $post_id,
											'post_title'	=> get_the_title( $post_id ),
											'post_link'		=> get_the_permalink( $post_id )
										);
					$favorite_list[] = apply_filters( 'lb_enjoyed_favorite_list', $post_favorite );
				}
				return $favorite_list;
			}
			return false;
		} else {
			return false;
		}
	}
}
