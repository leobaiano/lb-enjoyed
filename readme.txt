=== LB Enjoyed ===
Contributors: leobaiano
Tags: enjoyed, enjoyed post, favorite, favorite posts
Requires at least: 3.7
Tested up to: 4.7.5
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Let your visitors bookmark your favorites posts

== Description ==

== Installation ==

To install just follow the installation steps of most WordPress plugin's:

e.g.

1. Download the file lb-enjoyed.zip;
2. Unzip the file on your computer;
3. Upload folder lb-enjoyed, you just unzip to `/wp-content/plugins/` directory;
4. Activate the plugin through the `Plugins` menu in WordPress;
5. Be happy.

== Frequently Asked Questions ==

= How do I set whether the icon should appear before, after the content, or in both places? =

To set where the favorites icon will appear you should use the `lb_enjoyed_location_icon` filter and return a string with the before, after, or both values.

Example to display before content:

`
add_filter( 'lb_enjoyed_location_icon', 'callback' );
function callback() {
	return 'before';
}
`

= How to add CSS classes to the favorite icon container? =

To add new classes to the container element you must use the `lb_enjoyed_container_classes_css` filter. The callback receives an array with the default class and must return an array with the classes of the container.

Example of how to add a new class:

`
add_filter( 'lb_enjoyed_container_classes_css', 'callback' );
function callback( $class ) {
	return array_merge( $class, array( 'new_class' ) );
}
`

= How can I change the icon? =

The plugin uses [Google Icons](https://material.io/icons/), to change the icon you must use the `lb_enjoyed_icon` filter and return a string with the name of the icon.

Here's an example here:

add_filter( 'lb_enjoyed_icon', 'callback' );
function callback( $class ) {
	return 'favorite';
}

== Screenshots ==

== Changelog ==
