<?php
// phpcs:ignoreFile

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Tools;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\BetterReflection;
use WickedOne\Muppet\Exception\LogicException;
use WickedOne\Muppet\Tests\Stub\Model\StubModel;
use WickedOne\Muppet\Tests\Stub\Model\SubStub;
use WickedOne\Muppet\Tools\Value;

/**
 * ValueTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ValueTest extends TestCase
{
    /**
     * test nullable property.
     */
    public function testNullableProperty(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(Foo::class);
        $method = $refClass->getProperty('foo');

        self::assertNull(Value::getValue($method, false));
    }

    /**
     * test nullable iterable.
     */
    public function testNullableIterable(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(Bar::class);
        $method = $refClass->getProperty('bar');

        self::assertNull(Value::getValue($method, false));

        $method = $refClass->getProperty('qux');

        self::assertNull(Value::getValue($method, false));
    }

    /**
     * test get borked array.
     */
    public function testGetValueBorkedArray(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(Bar::class);

        self::assertSame('foo', Value::getValue($refClass->getProperty('bar'), true));
        self::assertNull(Value::getValue($refClass->getProperty('bar'), false));
        self::assertNull(Value::getValue($refClass->getProperty('qux'), false));
        self::assertNull(Value::getValue($refClass->getProperty('qux'), true));
    }

    /**
     * test get composite class.
     */
    public function testGetCompositeClassValue(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(StubModel::class);
        $method = $refClass->getProperty('quux');

        self::assertSame(SubStub::class, Value::getValue($method, true));
    }

    /**
     * test get named unnamed.
     */
    public function testNamedUnnamedType(): void
    {
        $refClass = (new BetterReflection())->classReflector()->reflect(Bar::class);
        $method = $refClass->getProperty('baz');

        self::assertSame('qux', Value::getValue($method, true));
    }

    /**
     * test get unknown class value.
     */
    public function testGetCompositeUnknownClassValue(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('unable to generate dummy value for WickedOne\Muppet\Tests\Unit\Tools\What\The');

        $refClass = (new BetterReflection())->classReflector()->reflect(bar::class);

        Value::getValue($refClass->getProperty('foo'), true);
    }

    /**
     * test unknown scalar.
     */
    public function testUnknownScalar(): void
    {
        self::assertNull(Value::scalarToValue('foo'));
    }

    /**
     * test all.
     */
    public function testAll(): void
    {
        $all = Value::all(Foo::class, true);

        self::assertArrayHasKey('foo', $all);
        self::assertArrayHasKey('bar', $all);
        self::assertArrayHasKey('baz', $all);
        self::assertArrayHasKey('qux', $all);
        self::assertSame('foo', $all['foo']);
        self::assertSame('foo', $all['baz']);
        self::assertFalse($all['bar']);

        $all = Value::all(Foo::class, false);

        self::assertArrayNotHasKey('foo', $all);
        self::assertArrayNotHasKey('baz', $all);
        self::assertArrayNotHasKey('qux', $all);
        self::assertArrayHasKey('bar', $all);
    }
}

class Foo
{
    /**
     * @var string[]
     */
    private array $baz = [];

    private ArrayCollection $qux;
    private ?string $foo;
    public bool $bar = false;
}

class Bar
{
    /**
     * @var string[]
     */
    private array $bar = [];

    private ArrayCollection $qux;

    private $baz;

    private What\The $foo;

    public function __construct()
    {
        $this->qux = new ArrayCollection();
    }
}
