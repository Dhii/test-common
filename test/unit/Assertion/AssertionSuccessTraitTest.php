<?php

namespace Dhii\Test\Test;

use Dhii\Test\Assertion\AssertionSuccessTrait as TestSubject;

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
     * @since [*next-version*]
     * @param string $name Name of the trait, for which to create a mock.
     * @param \PHPUnit_Framework_TestCase|null The test case, which will perform assertions instead of the mock.
     *  Default: this test case instance.
     * @return PHPUnit_Framework_MockObject_MockObject Mock of the trait.
     *  This mock will use the given test case for assertions.
     */
    public function createTestCaseTraitMock($name, $testCase = null)
    {
        if (is_null($testCase)) {
            $testCase = $this;
        }

        $mock = $this->getMockForTrait($name);
        $mock->method('assertThat')->will($this->returnCallback(function($value, $constraint, $message) {
            $this->assertThat($value, $constraint, $message);
        }));

        return $mock;
    }

    /**
     * Fails if the assertion of failure by subject fails, i.e. if the tested test succeeds.
     *
     * @since [*next-version*]
     */
    public function testAssertAssertionSuccessSuccess()
    {
        $subjectClass = TestSubject::class;
        $subject = $this->createTestCaseTraitMock($subjectClass);

        $subject->assertAssertionSuccess(function () {
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
        $subjectClass = TestSubject::class;
        $subject = $this->createTestCaseTraitMock($subjectClass);

        $error = 'Because the innermost assertion is unsuccessful, the tested assertion must fail';
        $token = 'ASd9qd1d091e';

        try {
            $subject->assertAssertionSuccess(function () {
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
