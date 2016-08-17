<?php

namespace Dhii\Test\Test\Constraint;

use Dhii\Test;

/**
 * Testing AssertionSuccess PHPUnit constraint.
 *
 * This constraint matches if the function it is testing does not contain a failed assertion.
 *
 * @since [*next-version*]
 */
class AssertionSuccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Creates a new constraint instance.
     *
     * @since [*next-version*]
     *
     * @return \Dhii\Test\Constraint\AssertionFailure The constraint instance.
     */
    public function createConstraint()
    {
        $constraint = new Test\Constraint\AssertionSuccess();

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
     * Tests whether the constraint can successfully match a successful assertion.
     *
     * @since [*next-version*]
     */
    public function testMatchSuccess()
    {
        $constraint = $this->createConstraint();
        $function = function () {
            $this->assertTrue(true, 'This must succeed');
        };
        $result = $constraint->matches($function);
        $this->assertTrue($result, 'Constraint must match successful assertion');
    }

    /**
     * Tests whether the constraint can fail matching a failed assertion.
     *
     * @since [*next-version*]
     */
    public function testMatchFailure()
    {
        $constraint = $this->createConstraint();
        $function = function () {
            $this->assertTrue(false, 'This must fail');
        };
        $result = $constraint->matches($function);
        $this->assertFalse($result, 'Constraint must not match a failed assertion');
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

    /**
     * Tests that the string representation of the constraint is correct.
     *
     * @since [*next-version*]
     */
    public function testToString()
    {
        $constraint = $this->createConstraint();
        $this->assertInternalType('string', $constraint->toString(), 'The constraint string must be a valid string');
    }

    /**
     * Tests that the string representation of the constraint is correct.
     *
     * @since [*next-version*]
     */
    public function testAdditionalFailureDescription()
    {
        $constraint = $this->createConstraint();
        $this->assertContains('failed with message',
                $constraint->additionalFailureDescription(''),
                'The additional failure description is wrong',
                true);
    }
}
