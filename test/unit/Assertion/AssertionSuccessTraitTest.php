<?php

namespace Dhii\Test\Test;

/**
 * Tests AssertionSuccessTrait.
 *
 * Ultimately, this tests a test mechanism, which determines if assertions succeed.
 *
 * @since [*next-version*]
 */
class AssertionSuccessTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Fails if the assertion of failure by subject fails, i.e. if the tested test succeeds.
     *
     * @since [*next-version*]
     */
    public function testAssertAssertionSuccessSuccess()
    {
        $subjectClass = \Dhii\Test\Assertion\AssertionSuccessTrait::class;
        $trait = $this->getMockForTrait($subjectClass);
        $trait->method('assertThat')
            ->will($this->returnCallback(function ($value, $constraint, $message = '') {
                $this->assertThat($value, $constraint, $message);
            }));

        $trait->assertAssertionSuccess(function () {
            $this->assertTrue(true, 'This must succeed');
        }, 'Successful assertion must succeed');
    }

    /**
     * Fails if the assertion of failure by subject succeeds, i.e. if the tested test fails.
     *
     * @since [*next-version*]
     */
    public function testAssertAssertionSuccessFailure()
    {
        $subjectClass = \Dhii\Test\Assertion\AssertionSuccessTrait::class;
        $trait = $this->getMockForTrait($subjectClass);
        $trait->method('assertThat')
            ->will($this->returnCallback(function ($value, $constraint, $message = '') {
                $this->assertThat($value, $constraint, $message);
            }));

        $error = 'Because the innermost assertion is unsuccessful, the tested assertion must fail';
        $token = 'ASd9qd1d091e';

        try {
            $trait->assertAssertionSuccess(function () {
                $this->assertTrue(true, 'This must fail');
            }, $token);
        } catch (\PHPUnit_Framework_ExpectationFailedException $ex) {
            /* If the expected exception is thrown,
             * it means asserting that the innermost assertion is successful failed.
             * Other exceptions should not cause the test to fail.
             */
            $this->assertNotContains($token, $ex->getMessage(), $error);

            return;
        }

        // No exception means asserting that the innermost assertion is unsuccessful didn't succeed
        $this->assertTrue(true, $error);
    }
}
