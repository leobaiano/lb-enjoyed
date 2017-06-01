<?php
/**
 * Class Favorite_Test
 *
 * @package LBEnjoyed
 */

namespace LBEnjoyed\Favorite\Test;
use LogFavorite\Favorite;

class FavoriteTest extends \WP_UnitTestCase {
	public function setUp()
    {
	    parent::setUp();
        $this->favorites = new \LogFavorite\Favorite();
	    $_COOKIE['log-favorites'] = 'foo,bar';

    }

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
