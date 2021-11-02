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
use WickedOne\Muppet\Method\NullifyPropertyValueMethod;

/**
 * nullify Property Value Method Test.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class NullifyPropertyValueMethodTest extends TestCase
{
    /**
     * test nullify property value method.
     */
    public function testGetNullifyPropertyValueMethod(): void
    {
        $method = (new NullifyPropertyValueMethod())->get('Foo');

        self::assertSame('testFooNullifyPropertyValues', $method->getName());
    }
}
