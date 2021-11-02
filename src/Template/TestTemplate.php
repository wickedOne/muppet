<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Template;

use PHPUnit\Framework\TestCase;

/**
 * Test Template.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 *
 * @codeCoverageIgnore
 *
 * @infection-ignore-all
 */
class TestTemplate extends TestCase
{
    /**
     * @var string
     *
     * @phpstan-param class-string $class
     */
    private static string $class = '';

    /**
     * @var array<string, mixed>
     */
    private array $values = [];

    /**
     * @var array<string, array<string, string|null>>
     */
    private static array $accessors = [];

    /**
     * @var array<string, mixed>
     */
    private static array $nonNullable = [];

    /**
     * @return object
     *
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testReadWritePropertiesMethods(): object
    {
        $instance = new self::$class();

        foreach ($this->values as $name => $value) {
            [$reader, $writer, $remover] = self::$accessors[$name];

            $this->values[$name] = $value = $this->value($value);
            $instance->$writer($value);

            if (null === $remover) {
                self::assertSame($value, $instance->$reader());
            } else {
                self::assertContains($value, $instance->$reader());
            }
        }

        return $instance;
    }

    /**
     * @depends testReadWritePropertiesMethods
     *
     * @param object $instance
     */
    public function testRemovePropertyValues(object $instance): void
    {
        foreach (self::$accessors as $property => $accessors) {
            if (null === $remover = $accessors['remover']) {
                continue;
            }

            $reader = $accessors['reader'];

            self::assertTrue($instance->$remover($this->values[$property]));
            self::assertNotContains($this->values[$property], $instance->$reader());
            self::assertFalse($instance->$remover($this->values[$property]));
        }
    }

    /**
     * @depends testReadWritePropertiesMethods
     *
     * @param object $instance
     */
    public function testNullifyPropertyValues(object $instance): void
    {
        foreach (array_diff_key($this->values, self::$nonNullable) as $name => $value) {
            [$reader, $writer] = self::$accessors[$name];

            $instance->$writer(null);

            self::assertNull($instance->$reader());
        }
    }

    /**
     * @param string|int|float|bool|iterable<array-key, mixed> $value
     *
     * @return object|string|int|float|bool|iterable<array-key, mixed>
     */
    private function value($value)
    {
        return \is_string($value) && class_exists($value) ? new $value() : $value;
    }
}
