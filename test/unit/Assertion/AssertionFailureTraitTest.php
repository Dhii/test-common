<?php

namespace Dhii\Test\Test\Assertion;

use Dhii\Test\Assertion\AssertionFailureTrait as TestSubject;

/**
 * Tests AssertionFailureTrait.
 *
 * Ultimately, this tests a test mechanism, which determines if an assertion fails.
 *
 * @since [*next-version*]
 */
class AssertionFailureTraitTest extends \PHPUnit_Framework_TestCase
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
    public function testAssertAssertionFailureSuccess()
    {
        $subjectClass = TestSubject::class;
        $subject = $this->createTestCaseTraitMock($subjectClass);

        $message = 'Asdasdasd';
        $subject->assertAssertionFailure(function () use ($message) {
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
        $subjectClass = TestSubject::class;
        $subject = $this->createTestCaseTraitMock($subjectClass);

        $message = 'Asdasdasd';
        $error = 'Because the innermost assertion is successful, the tested assertion must fail';

        try {
            $subject->assertAssertionFailure(function () use ($message) {
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
