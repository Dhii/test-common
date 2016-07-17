<?php

namespace Dhii\Test\Test\TestUtil;

use Dhii\Test\TestUtil\CanGetAccessibleMethodTrait;

/**
 * Tests CanGetAccessibleMethodTrait.
 *
 * This trait allows calling previously inaccessible methods.
 *
 * @since [*next-version*]
 */
class CanGetAccessibleMethodTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that `getAccessibleMethod()` really returns an accessible method instance.
     * @since [*next-version*]
     */
    public function testGetAccessibleMethod()
    {
        $trait = $this->getMockForTrait(CanGetAccessibleMethodTrait::class);
        $method = $trait->getAccessibleMethod($this, '_inaccessibleMethod');
        /* @var $method \ReflectionMethod */
        $this->assertSame($this->getMessageToken(), $method->invoke($this),
            'Method must run');
    }

    /**
     * @since [*next-version*]
     * @return string The message token that signifies correct operation.
     */
    protected function _inaccessibleMethod()
    {
        return $this->getMessageToken();
    }

    /**
     * This is here to centralize access to a message token.
     * @return string A message token.
     */
    public function getMessageToken()
    {
        return 'Here I am 123dsadsadwq';
    }
}