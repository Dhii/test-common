<?php

namespace Dhii\Test\TestUtil;

/**
 * Functionality for getting the type of a value.
 *
 * @since [*next-version*]
 */
trait CanGetVarTypeTrait
{
    /**
     * Retrieve the type name of the value.
     *
     * @since [*next-version*]
     *
     * @param mixed $var The value for which to get the type.
     *
     * @return string The primitive type of the variable, or, if object, the class name of that object.
     */
    public function getVarType($var)
    {
        $type = gettype($var);

        return $type === 'object'
            ? get_class($var)
            : $type;
    }
}
