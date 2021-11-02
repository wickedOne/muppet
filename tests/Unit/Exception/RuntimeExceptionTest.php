<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Exception;

use PHPUnit\Framework\TestCase;
use WickedOne\Muppet\Exception\RuntimeException;

/**
 * RuntimeExceptionTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class RuntimeExceptionTest extends TestCase
{
    /**
     * Test logic exception.
     */
    public function testRuntimeException(): void
    {
        $previous = new \RuntimeException();
        $exception = new RuntimeException('foo', $previous);

        self::assertSame('foo', $exception->getMessage());
        self::assertSame(0, $exception->getCode());
        self::assertSame($previous, $exception->getPrevious());
    }
}
