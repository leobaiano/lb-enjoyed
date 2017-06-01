<?php
/**
 * Widget Favorite List
 *
 * @package LB Enjoyed
 * @category Core
 * @author Leo Baiano <ljunior2005@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_Favorite_List extends WP_Widget {

	/**
	 * Favorite list.
	 *
	 * @var array $favorites
	 */
	protected static $favorites;

	public function __construct() {
		$widget_ops = array(
			'classname' => 'Widget_Favorite_List',
			'description' => __( 'Favorite List', 'lb-enjoyed' )
		);
		parent::__construct( 'Widget_Favorite_List', __( 'Favorite List', 'lb-enjoyed' ), $widget_ops );

		// Get Favorites
		// self::$favorites = array( array( 'post_id' => 1, 'post_title' => 'title', 'post_link' => 'http://teste.com' ) );
		self::$favorites = self::get_favorite_list();
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$widget_title = apply_filters( 'lb_favorite_widget_title', $instance['title'] );
		$css_class = apply_filters( 'lb_favorite_widget_classes_css', array( 'lb_favorite_widget_container' ) );
		$css_class = implode( ' ', $css_class );

        echo $args['before_widget'];
			if ( ! empty( $widget_title ) ) {
				echo $args['before_title'] . $widget_title . $args['after_title'];
			}
        	echo '<ul class="' . $css_class . '">';
        		if ( ! empty( self::$favorites ) ) {
	        		foreach ( self::$favorites as $favorite ) {
	        			echo '<li class="post-id-' . $favorite['post_id'] .  '"><a href="' . $favorite['post_link'] . '" title="' . $favorite['post_title'] . '">' . $favorite['post_title'] . '</li>';
	        		}
	        	} else {
	        		echo '<li>' . __( 'You do not have any posts added to favorites.', 'lb-enjoyed' ) . '</li>';
	        	}
        	echo '</ul>';
        echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'Favorite List', 'lb-enjoyed' );
        }

        echo '<p>';
            echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Widget Title:', 'lb-enjoyed' ) . '</label>';
            echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '"/>';
        echo '</p>';
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
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

		$id_posts_favorites = explode( '-', $cookie_lb_enjoyed );
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
			return $favorite_list();
		} else {
			return false;
		}
	}
}
