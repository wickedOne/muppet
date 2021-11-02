<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Tools;

use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\BetterReflection;
use WickedOne\Muppet\Tests\Stub\Model\StubModel;
use WickedOne\Muppet\Tools\Accessor;

/**
 * AccessorTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class AccessorTest extends TestCase
{
    /**
     * test reader.
     */
    public function testReader(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(StubModel::class);

        self::assertSame('getFoo', Accessor::reader($refClass->getProperty('foo')));
        self::assertSame('getValue', Accessor::reader($refClass->getProperty('value')));
        self::assertSame('isBaz', Accessor::reader($refClass->getProperty('baz')));
        self::assertSame('getQux', Accessor::reader($refClass->getProperty('qux')));
    }

    /**
     * test writer.
     */
    public function testWriter(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(StubModel::class);

        self::assertSame('setFoo', Accessor::writer($refClass->getProperty('foo')));
        self::assertSame('addBar', Accessor::writer($refClass->getProperty('bar')));
        self::assertSame('setBrrr', Accessor::writer($refClass->getProperty('brrr')));
    }

    /**
     * test remover.
     */
    public function testRemover(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(StubModel::class);

        self::assertSame('removeBar', Accessor::remover($refClass->getProperty('bar')));
    }

    /**
     * test is iterable.
     */
    public function testIterable(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(StubModel::class);

        self::assertTrue(Accessor::isIterable($refClass->getProperty('bar')));
        self::assertTrue(Accessor::isIterable($refClass->getProperty('bor')));
        self::assertTrue(Accessor::isIterable($refClass->getProperty('bas')));
        self::assertFalse(Accessor::isIterable($refClass->getProperty('foo')));
        self::assertFalse(Accessor::isIterable($refClass->getProperty('name')));
        self::assertFalse(Accessor::isIterable($refClass->getProperty('value')));
    }

    /**
     * test all.
     */
    public function testAll(): void
    {
        $accessors = Accessor::all(StubModel::class);

        self::assertArrayHasKey('name', $accessors);
        self::assertArrayHasKey('value', $accessors);
        self::assertArrayHasKey('foo', $accessors);
        self::assertArrayHasKey('bar', $accessors);
        self::assertNotNull($accessors['bar']['remover']);
        self::assertArrayHasKey('baz', $accessors);
        self::assertArrayHasKey('boo', $accessors);
        self::assertArrayHasKey('brrr', $accessors);
        self::assertArrayHasKey('qux', $accessors);
        self::assertArrayHasKey('quux', $accessors);
        self::assertArrayHasKey('bas', $accessors);
        self::assertSame('addBa', $accessors['bas']['writer']);
        self::assertSame('removeBa', $accessors['bas']['remover']);

        foreach ($accessors as $generated) {
            self::assertArrayHasKey('reader', $generated);
            self::assertArrayHasKey('writer', $generated);
            self::assertArrayHasKey('remover', $generated);
        }
    }
}
