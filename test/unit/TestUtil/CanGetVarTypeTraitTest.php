<?php

namespace Dhii\Test\Test\TestUtil;

use Dhii\Test\TestUtil\CanGetVarTypeTrait;

/**
 * Tests CanGetVarTypeTrait.
 *
 * @since [*next-version*]
 */
class CanGetVarTypeTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @since [*next-version*]
     *
     * @return object A mock for the trait.
     */
    public function createTrait()
    {
        $trait = $this->getMockForTrait(CanGetVarTypeTrait::class);

        return $trait;
    }

    /**
     * Tests whether primitive types are correctly determined.
     *
     * @since [*next-version*]
     */
    public function testGetVarTypeForPrimitive()
    {
        $trait = $this->createTrait();
        $result = $trait->getVarType('oh look a string');
        $this->assertInternalType('string', $result, 'Type should be determined as "string"');
    }

    /**
     * Tests whether class types are correctly determined.
     *
     * @since [*next-version*]
     */
    public function testGetVarTypeForClass()
    {
        $trait = $this->createTrait();
        $subject = new \stdClass();
        $result = $trait->getVarType($subject);
        $expected = get_class($subject);
        $this->assertSame($expected, $result, sprintf('Type should be determined as "%1$s"', $expected));
    }
}
