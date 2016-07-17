<?php

namespace Dhii\Test;

/**
 * Base trait that contains functionalty common to all traits which require the class to be a PHPUnit constraint.
 *
 * @since [*next-version*]
 */
trait CanAssertThatTrait
{
    /**
     * @codeCoverageIgnore
     *
     * @since [*next-version*]
     */
    abstract public function assertThat($value, \PHPUnit_Framework_Constraint $constraint, $message = '');
}
