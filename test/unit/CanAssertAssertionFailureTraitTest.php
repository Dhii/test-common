<?php

namespace Dhii\Test\Test;

/**
 * Tests CanAssertAssertionFailureTrait.
 *
 * Ultimately, this tests a test mechanism, which determines if an assertion fails.
 *
 * @since [*next-version*]
 */
class CanAssertAssertionFailureTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Fails if the assertion of failure by subject fails, i.e. if the tested test succeeds.
     *
     * @since [*next-version*]
     */
    public function testAssertAssertionFailureSuccess()
    {
        $subjectClass = \Dhii\Test\CanAssertAssertionFailureTrait::class;
        $trait = $this->getMockForTrait($subjectClass);
        $trait->method('assertThat')
            ->will($this->returnCallback(function ($value, $constraint, $message = '') {
                $this->assertThat($value, $constraint, $message);
            }));

        $message = 'Asdasdasd';
        $trait->assertAssertionFailure(function () use ($message) {
            $this->assertTrue(false, $message);
        }, $message);
    }

    /**
     * Fails if the assertion of failure by subject succeeds, i.e. if the tested test fails.
     *
     * @since [*next-version*]
     */
    public function testAssertAssertionFailureFails()
    {
        $subjectClass = \Dhii\Test\CanAssertAssertionFailureTrait::class;
        $trait = $this->getMockForTrait($subjectClass);
        $trait->method('assertThat')
            ->will($this->returnCallback(function ($value, $constraint, $message = '') {
                $this->assertThat($value, $constraint, $message);
            }));

        $message = 'Asdasdasd';
        $error = 'Because the innermost assertion is successful, the tested assertion must fail';

        try {
            $trait->assertAssertionFailure(function () use ($message) {
                $this->assertTrue(true, $message);
            }, $message);
        } catch (\PHPUnit_Framework_ExpectationFailedException $ex) {
            /* If the expected exception is thrown,
             * it means asserting that the innermost assertion is unsuccessful succeeded
             */
            $this->assertContains('contains a failed assertion', $ex->getMessage(),
                'Because the innermost assertion is successful, the tested assertion must fail');

            return;
        }

        // No exception means asserting that the innermost assertion is unsuccessful didn't succeed
        $this->assertTrue(false, $error);
    }
}
