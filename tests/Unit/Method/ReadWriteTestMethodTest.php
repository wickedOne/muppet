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
use WickedOne\Muppet\Method\ReadWriteTestMethod;

/**
 * ReadWriteTestMethodTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ReadWriteTestMethodTest extends TestCase
{
    /**
     * test get read write test method.
     */
    public function testGetReadWriteTestMethod(): void
    {
        $method = (new ReadWriteTestMethod())->get('Foo');

        self::assertSame('testFooReadWritePropertiesMethods', $method->getName());
    }
}
