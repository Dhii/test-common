<?php

namespace Dhii\Test\Constraint;

/**
 * Fails if passed callback does not contain a failed assertion.
 * Optionally, fails if that assertion's failure message does not contain the specified message.
 *
 * @since [*next-version*]
 */
class AssertionFailure extends \PHPUnit_Framework_Constraint
{
    protected $message;
    protected $failureMessage;

    /**
     * @since [*next-version*]
     *
     * @param string $message The message, if any, that the failed assertion has to produce.
     *
     * @throws Exception If type is not a string.
     */
    public function __construct($message = null)
    {
        $this->message = $message;
        parent::__construct();
    }

    /**
     * Runs the callback, and sees if it fails, optionally with the configured message.
     *
     * @since [*next-version*]
     *
     * @param callable $other The function that must contani a failed assertion.
     *
     * @return bool True if function contains a failed assertion; false otherwise.
     */
    public function matches($other)
    {
        if (!is_callable($other)) {
            throw new \PHPUnit_Framework_Exception(sprintf('Callable specified for %1$s is not a valid callable', get_class($this)));
        }

        try {
            call_user_func_array($other, []);
        } catch (\PHPUnit_Framework_ExpectationFailedException $ex) {
            $failureMessage = $ex->getMessage();
            $this->_setFailureMessage($failureMessage);
            if ($message = $this->_getMessage()) {
                return stripos($failureMessage, $message) !== false;
            }

            return true;
        }

        return false;
    }

    /**
     * @since [*next-version*]
     *
     * @return string|null The message, with which the assertion must fail, or null if not constrained to message.
     */
    protected function _getMessage()
    {
        return $this->message;
    }

    /**
     * @codeCoverageIgnore
     * @since [*next-version*]
     * @param string|null $message The failure message. Null to ignore message constraint.
     * @return \Dhii\Test\Constraint\AssertionFailure This instance.
     */
    protected function _setFailureMessage($message)
    {
        $this->failureMessage = $message;

        return $this;
    }

    protected function _getFailureMessage()
    {
        return $this->failureMessage;
    }

    /**
     * @since [*next-version*]
     *
     * @return string String representation of this constraint.
     */
    public function toString()
    {
        return sprintf('contains a failed assertion' .
            (($message = $this->_getMessage()) ?
                (($failureMessage = $this->_getFailureMessage()) ?
                    ' with message "%2$s"' :
                    '') . ' containing "%1$s"' :
                ''),
            $message,
            $failureMessage);
    }
}
