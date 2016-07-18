<?php

namespace Dhii\Test;

/**
 * Functionality for asserting that a PHPUnit assertion succeeds.
 *
 * @since [*next-version*]
 */
trait CanAssertAssertionSuccessTrait
{
    use CanAssertThatTrait;

    /**
     * @since [*next-version*]
     *
     * @param callable    $callback    The callback containing an assertion.
     * @param string|null $withMessage If specified, assertion would only pass if the subject succeeds.
     * @param string      $message     The message to display if this assertion fails.
     */
    public function assertAssertionSuccess($callback, $message = '')
    {
        $this->assertThat($callback, new Constraint\AssertionSuccess(), $message);
    }
}
