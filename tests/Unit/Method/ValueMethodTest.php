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
use WickedOne\Muppet\Method\ValueMethod;

/**
 * ValueMethodTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ValueMethodTest extends TestCase
{
    /**
     * test get value method.
     */
    public function testGetValueMethod(): void
    {
        $method = (new ValueMethod())->get('Foo');

        self::assertSame('value', $method->getName());
    }
}
