<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\DocBlock;

use PHPUnit\Framework\TestCase;
use WickedOne\Muppet\DocBlock\DockBlock;

/**
 * DockBlockTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class DockBlockTest extends TestCase
{
    /**
     * test generic docblock without author.
     */
    public function testNoAuthor(): void
    {
        $block = (new DockBlock())->get('foo');

        self::assertCount(1, $block);
        self::assertSame('foo Test.', $block[0]);
    }

    /**
     * test docboc with author.
     */
    public function testWithAuthor(): void
    {
        $block = (new DockBlock())->get('foo', 'henk <henk@example.com>');

        self::assertCount(3, $block);
        self::assertStringContainsString('author', $block[2]);
    }
}
