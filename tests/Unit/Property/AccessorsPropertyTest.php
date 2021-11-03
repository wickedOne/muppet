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
use WickedOne\Muppet\Property\AccessorsProperty;
use WickedOne\Muppet\Tests\Stub\Model\StubModel;

/**
 * AccessorsPropertyTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class AccessorsPropertyTest extends TestCase
{
    /**
     * tes get accessor property.
     */
    public function testGetAccessorsProperty(): void
    {
        $accessors = (new AccessorsProperty())->get(StubModel::class);

        self::assertSame('accessors', $accessors->getName());
        self::assertTrue($accessors->isPrivate());
        self::assertTrue($accessors->isStatic());
        self::assertSame('array', $accessors->getType());
        self::assertStringContainsString(\PHP_EOL.'@var array<string, array<string, string|null>>', $accessors->getComment());
    }
}
