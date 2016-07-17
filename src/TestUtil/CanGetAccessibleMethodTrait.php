<?php

namespace Dhii\Test\TestUtil;

/**
 * Functionality that helps calling a protected method from outside, via reflection.
 *
 * @since [*next-version*]
 */
trait CanGetAccessibleMethodTrait
{
    /**
     * @since [*next-version*]
     *
     * @param object|string $object The object or class name, for which to get the accessible method.
     * @param string        $method Name of the method to invoke.
     *
     * @return \ReflectionMethod The method, which now can be invoked.
     */
    public function getAccessibleMethod($object, $method)
    {
        $method = new \ReflectionMethod($object, $method);
        $method->setAccessible(true);

        return $method;
    }
}
