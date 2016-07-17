<?php

namespace Dhii\Test\Test\Constraint;

use Dhii\Test;

/**
 * Testing AssertionFailure PHPUnit constraint.
 *
 * This constraint matches if the function it is testing contains a failed assertion.
 * Optionally, will also fail if the failure message of the assertion does not contain the configured string.
 *
 * @since [*next-version*]
 */
class AssertionFailureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Creates a new constraint instance.
     *
     * @since [*next-version*]
     *
     * @param string $message The message constraint to add, if any.
     *
     * @return \Dhii\Test\Constraint\AssertionFailure The constraint instance.
     */
    public function createConstraint($message = null)
    {
        $constraint = new Test\Constraint\AssertionFailure($message);

        return $constraint;
    }

    /**
     * Tests whether a valid constraint can be instantiated.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $constraint = $this->createConstraint();
        $this->assertInstanceOf(\PHPUnit_Framework_Constraint::class, $constraint,
            'Constraint is not a valid constraint');
    }

    /**
     * Tests whether the constraint can successfully match a failed assertion without a message.
     *
     * @since [*next-version*]
     */
    public function testMatchSuccessNoMessage()
    {
        $constraint = $this->createConstraint();
        $function = function () {
            $this->assertTrue(false);
        };
        $result = $constraint->matches($function);
        $this->assertTrue($result, 'Constraint must match a failed assertion');
    }

    /**
     * Tests whether the constraint can fail matching a successful assertion without a message.
     *
     * @since [*next-version*]
     */
    public function testMatchFailureNoMessage()
    {
        $constraint = $this->createConstraint();
        $function = function () {
            $this->assertTrue(true);
        };
        $result = $constraint->matches($function);
        $this->assertFalse($result, 'Constraint must not match a successful assertion');
    }

    /**
     * Tests whether the constraint can successfully match a failed assertion with a message.
     *
     * @since [*next-version*]
     */
    public function testMatchSuccessWithMessage()
    {
        $message = '123asd';
        $constraint = $this->createConstraint($message);
        $function = function () use ($message) {
            $this->assertTrue(false, $message);
        };
        $result = $constraint->matches($function);
        $this->assertTrue($result, 'Constraint must match a failed assertion');
    }

    /**
     * Tests whether the constraint can fail matching a successful assertion with a message.
     *
     * @since [*next-version*]
     */
    public function testMatchFalureWithMessage()
    {
        $message = '123asd';
        $constraint = $this->createConstraint($message);
        $function = function () {
            $this->assertTrue(false, 'Wrong message here, does not contain token');
        };
        $result = $constraint->matches($function);
        $this->assertFalse($result, 'Constraint must not match a successful assertion');
    }

    /**
     * Tests whether the constraint throws the correct exception when given an incorrect subject.
     *
     * @since [*next-version*]
     */
    public function testNonCallableSubject()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessage('not a valid callable');

        $constraint = $this->createConstraint();
        $function = 'not a callable';
        $constraint->matches($function);
    }
}
