<?php

namespace Dhii\Test\Constraint;

/**
 * Common functionality for assertion constraints.
 *
 * @since [*next-version*]
 */
abstract class AbstractAssertion extends AbstractConstraint
{
    protected $failureMessage;

    /**
     * @codeCoverageIgnore
     *
     * @since [*next-version*]
     *
     * @param string|null $message The failure message. Null to ignore message constraint.
     *
     * @return \Dhii\Test\Constraint\AssertionFailure This instance.
     */
    protected function _setFailureMessage($message)
    {
        $this->failureMessage = $message;

        return $this;
    }

    /**
     * @since [*next-version*]
     *
     * @return string The message, with which the assertion failed.
     */
    protected function _getFailureMessage()
    {
        return $this->failureMessage;
    }
}
