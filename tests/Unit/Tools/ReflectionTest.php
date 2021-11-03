<?php
// phpcs:ignoreFile

declare(strict_types=1);

namespace WickedOne\Muppet\Tests\Unit\Tools;

use WickedOne\Muppet\Tools\Reflection;
use PHPUnit\Framework\TestCase;
use function Pipeline\map;

/**
 * ReflectionTest
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class ReflectionTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testComposites(): void
    {
        $result = Reflection::composites(Fooz::class);

        self::assertArrayHasKey(Fooz::class, $result);
        self::assertArrayHasKey(Baz::class, $result);
        self::assertArrayNotHasKey('qux', $result);
    }

    /**
     * test uses.
     */
    public function testUses(): void
    {
        $result = Reflection::uses(Fooz::class);

        self::assertContains(Fooz::class, $result);
        self::assertContains(Baz::class, $result);
        self::assertNotContains('bar', $result);
    }

    /**
     * test non-existing fully qualified space name.
     */
    public function testNonExistentFqns(): void
    {
        $result = Reflection::uses('Foo\Bar');

        self::assertEmpty($result);
    }
}

class Baz {}

class Fooz
{
    private $bar;
    private Baz $baz;
    private int $qux = 0;
}
