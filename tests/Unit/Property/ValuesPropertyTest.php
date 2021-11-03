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
use WickedOne\Muppet\Property\ValuesProperty;
use WickedOne\Muppet\Tests\Stub\Model\StubModel;

/**
 * ValuesPropertyTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ValuesPropertyTest extends TestCase
{
    /**
     * test get values property.
     */
    public function testGetValuesProperty(): void
    {
        $property = (new ValuesProperty())->get(StubModel::class);

        $expected = [
            'name' => 'foo',
            'value' => 'foo',
            'bor' => 'Doctrine\Common\Collections\ArrayCollection',
            'bar' => null,
            'baz' => false,
            'boo' => 3,
            'brrr' => 0.43144251845378545,
            'qux' => false,
            'quux' => 'WickedOne\Muppet\Tests\Stub\Model\SubStub',
            'bas' => null,
        ];

        self::assertSame('values', $property->getName());
        self::assertSame($expected, $property->getValue());
        self::assertTrue($property->isPrivate());
        self::assertSame('array', $property->getType());
        self::assertSame(\PHP_EOL.'@var array<string, object|int|bool|string|float|null>', $property->getComment());
    }
}
