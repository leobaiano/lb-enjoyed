# LB Enjoyed #

Plugin WordPress: Let your visitors bookmark your favorites posts

## Description ##

## Frequently Asked Questions ##

= How do I set whether the icon should appear before, after the content, or in both places? =

To set where the favorites icon will appear you should use the `lb_enjoyed_location_icon` filter and return a string with the before, after, or both values.

Example to display before content:

```php
add_filter( 'lb_enjoyed_location_icon', 'callback' );
function callback() {
	return 'before';
}
```

= How to add CSS classes to the favorite icon container? =

To add new classes to the container element you must use the `lb_enjoyed_container_classes_css` filter. The callback receives an array with the default class and must return an array with the classes of the container.

Example of how to add a new class:

```php
add_filter( 'lb_enjoyed_container_classes_css', 'callback' );
function callback( $class ) {
	return array_merge( $class, array( 'new_class' ) );
}
`

= How can I change the icon? =

The plugin uses [Google Icons](https://material.io/icons/), to change the icon you must use the `lb_enjoyed_icon` filter and return a string with the name of the icon.

Here's an example here:

```php
add_filter( 'lb_enjoyed_icon', 'callback' );
function callback( $class ) {
	return 'favorite';
}
```

## Contribute ##

You can contribute to the source code in our [GitHub](https://github.com/leobaiano/lb-enjoyed) page.

1. Take a [fork](https://help.github.com/articles/fork-a-repo/) repository;
3. [Configure your](https://help.github.com/articles/configuring-a-remote-for-a-fork/);
2. Check [issues](https://github.com/leobaiano/lb-enjoyed/issues) and choose one that does not have anyone working;
4. [Sincronize seu fork](https://help.github.com/articles/syncing-a-fork/);
2. Create a branch to work on the issue of responsibility: `git checkout -b issue-17`;
3. Commit the changes you made: `git commit -m 'Review commits you did'`;
4. Make a push to branch: `git push origin issue-17`;
5. Make a [Pull Request](https://help.github.com/articles/using-pull-requests/) :D

**Note:** If you want to contribute to something that was not recorded in the [issues](https://github.com/leobaiano/baianada/issues) it is important to create and subscribe to prevent someone else to start working on the same thing you.

If you need help performing any of the procedures above, please access the link and [learn how to make a Pull Request](https://help.github.com/articles/creating-a-pull-request/).
