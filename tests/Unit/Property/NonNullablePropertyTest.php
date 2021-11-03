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
use WickedOne\Muppet\Property\NonNullableProperty;
use WickedOne\Muppet\Tests\Stub\Model\StubModel;

/**
 * NonNullablePropertyTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class NonNullablePropertyTest extends TestCase
{
    /**
     * test non-nullable property.
     */
    public function testNonNullableProperty(): void
    {
        $property = (new NonNullableProperty())->get(StubModel::class);

        self::assertSame('nonNullable', $property->getName());
        self::assertContains('name', $property->getValue());
        self::assertNotContains('value', $property->getValue());
        self::assertTrue($property->isPrivate());
        self::assertTrue($property->isStatic());
        self::assertSame('array', $property->getType());
        self::assertStringContainsString(\PHP_EOL.'@var string[]', $property->getComment());
    }
}
