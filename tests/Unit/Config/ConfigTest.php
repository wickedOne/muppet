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
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use WickedOne\Muppet\Config\Config;

/**
 * ConfigTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ConfigTest extends TestCase
{
    /**
     * test invalid fragments.
     */
    public function testInvalidFragments(): void
    {
        $this->expectException(MissingOptionsException::class);
        $this->expectExceptionMessage('The required option "fragments" is missing.');

        new Config([
            'base_dir' => __DIR__,
            'test_dir' => __DIR__,
        ]);
    }

    /**
     * test invlid base dir.
     */
    public function testInvalidBaseDir(): void
    {
        $this->expectException(MissingOptionsException::class);
        $this->expectExceptionMessage('The required option "base_dir" is missing.');

        new Config([
            'test_dir' => __DIR__,
            'fragments' => [
                'Foo',
            ],
        ]);
    }

    /**
     * test invalid test dir.
     */
    public function testInvalidTestDir(): void
    {
        $this->expectException(MissingOptionsException::class);
        $this->expectExceptionMessage('The required option "test_dir" is missing.');

        new Config([
            'base_dir' => __DIR__,
            'fragments' => [
                'Foo',
            ],
        ]);
    }

    /**
     * test optional author.
     */
    public function testOptionalAuthor(): void
    {
        $options = new Config([
            'base_dir' => __DIR__,
            'test_dir' => __DIR__,
            'author' => 'foo <bar@qux.com>',
            'fragments' => [
                'Foo',
            ],
        ]);

        self::assertSame('foo <bar@qux.com>', $options->getAuthor());
        self::assertSame(__DIR__, $options->getBaseDir());
        self::assertSame(__DIR__, $options->getTestDir());
        self::assertSame(['Foo'], $options->getFragments());
    }
}
