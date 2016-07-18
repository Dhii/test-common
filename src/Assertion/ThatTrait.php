<?php

namespace Dhii\Test\Assertion;

/**
 * Base trait that contains functionalty common to all traits which require the class to be a PHPUnit constraint.
 *
 * @since [*next-version*]
 */
trait ThatTrait
{
    /**
     * @codeCoverageIgnore
     *
     * @since [*next-version*]
     */
    abstract public function assertThat($value, \PHPUnit_Framework_Constraint $constraint, $message = '');
}
