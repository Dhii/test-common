<?php

namespace Dhii\Test\Constraint;

/**
 * Fails if passed callback contains a failed assertion.
 *
 * @since [*next-version*]
 */
class AssertionSuccess extends AbstractAssertion
{
    protected $failureMessage;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     *
     * @param callable $other The function that must contani a failed assertion.
     *
     * @return bool False if function contains a failed assertion; true otherwise.
     */
    public function matches($other)
    {
        if (!is_callable($other)) {
            throw new \PHPUnit_Framework_Exception(sprintf('Callable specified for %1$s is not a valid callable', get_class($this)));
        }

        try {
            call_user_func_array($other, []);
        } catch (\PHPUnit_Framework_ExpectationFailedException $ex) {
            $this->_setFailureMessage($ex->getMessage());

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     *
     * @return string String representation of this constraint.
     */
    public function toString()
    {
        return 'does not contain a failed assertion';
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function additionalFailureDescription($other)
    {
        return sprintf('An assertion failed with message:
``%1$s``',  $this->_getFailureMessage());
    }
}
