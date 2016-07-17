<?php

namespace Dhii\Test;

/**
 * Functionality for asserting that a PHPUnit assertion fails.
 *
 * @since [*next-version*]
 */
trait CanAssertAssertionFailureTrait
{
    use CanAssertThatTrait;

    /**
     * @since [*next-version*]
     *
     * @param callable    $callback    The callback containing an assertion.
     * @param string|null $withMessage If specified, assertion would only pass if the subject
     *                                 fails with this specific message.
     * @param string      $message     The message to display if this assertion fails.
     */
    public function assertAssertionFailure($callback, $withMessage = null, $message = '')
    {
        $this->assertThat($callback, new Constraint\AssertionFailure($withMessage), $message);
    }
}
