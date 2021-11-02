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

        self::assertCount(1, $this->filter($result, Fooz::class));
        self::assertCount(1, $this->filter($result, Baz::class));
        self::assertCount(0, $this->filter($result, 'bar'));
    }

    /**
     * @param array $array
     * @param string $value
     *
     * @return array
     */
    public function filter(array $array, string $value): array
    {
        return array_filter($array, static function ($v) use ($value) {
            return $value === $v || in_array($value, $v, true);
        });
    }

    /**
     * test non existing fully qualified space name.
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
