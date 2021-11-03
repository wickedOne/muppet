<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Property;

use PHPUnit\Framework\TestCase;
use WickedOne\Muppet\Property\ClassProperty;
use WickedOne\Muppet\Tests\Stub\Model\StubModel;

/**
 * ClassPropertyTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ClassPropertyTest extends TestCase
{
    /**
     * test get class property.
     */
    public function testGetClassProperty(): void
    {
        $property = (new ClassProperty())->get(StubModel::class);

        self::assertSame('class', $property->getName());
        self::assertSame(StubModel::class, $property->getValue());
        self::assertTrue($property->isPrivate());
        self::assertTrue($property->isStatic());
        self::assertSame('string', $property->getType());
        self::assertStringContainsString(\PHP_EOL.'@var class-string', $property->getComment());
    }
}
