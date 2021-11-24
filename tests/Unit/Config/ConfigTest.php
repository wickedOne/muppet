<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Config;

use PHPUnit\Framework\TestCase;
use WickedOne\Muppet\Config\Config;

/**
 * ConfigTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ConfigTest extends TestCase
{
    /**
     * test optional author.
     */
    public function testOptionalAuthor(): void
    {
        $options = new Config(
            __DIR__,
            __DIR__,
            [
                'Foo',
            ],
            'foo <bar@qux.com>'
        );

        self::assertSame('foo <bar@qux.com>', $options->getAuthor());
        self::assertSame(__DIR__, $options->getBaseDir());
        self::assertSame(__DIR__, $options->getTestDir());
        self::assertSame(['Foo'], $options->getFragments());

        $options = new Config(
            __DIR__,
            __DIR__,
            [
                'Foo',
            ]
        );

        self::assertNull($options->getAuthor());
    }
}
