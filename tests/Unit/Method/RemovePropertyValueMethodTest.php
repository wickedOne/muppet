<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Method;

use PHPUnit\Framework\TestCase;
use WickedOne\Muppet\Method\RemovePropertyValueMethod;

/**
 * removePropertyValueMethodTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class RemovePropertyValueMethodTest extends TestCase
{
    /**
     * test get remove property value.
     */
    public function testGetRemovePropertyValue(): void
    {
        $method = (new RemovePropertyValueMethod())->get('Foo');

        self::assertSame('testFooRemovePropertyValues', $method->getName());
    }
}
