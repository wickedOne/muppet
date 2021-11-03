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
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testReadWritePropertiesMethods(): void
    {
        $instance = new self::$class();

        foreach ($this->values as $name => $value) {
            [$reader, $writer, $remover] = array_values(self::$accessors[$name]);

            $this->values[$name] = $value = $this->value($value);
            $instance->$writer($value);

            if (null === $remover) {
                self::assertSame($value, $instance->$reader());
            } else {
                self::assertContains($value, $instance->$reader());
            }
        }

        foreach (self::$accessors as $property => $accessors) {
            if (null === $remover = $accessors['remover']) {
                continue;
            }

            $reader = $accessors['reader'];

            self::assertTrue($instance->$remover($this->values[$property]));
            self::assertNotContains($this->values[$property], $instance->$reader());
            self::assertFalse($instance->$remover($this->values[$property]));
        }

        foreach (array_diff_key($this->values, array_flip(self::$nonNullable)) as $name => $value) {
            [$reader, $writer] = array_values(self::$accessors[$name]);

            $instance->$writer(null);

            self::assertNull($instance->$reader());
        }
    }

    /**
     * @param object|string|int|float|bool|null $value
     *
     * @return object|string|int|float|bool|null
     */
    private function value($value)
    {
        return \is_string($value) && class_exists($value) ? new $value() : $value;
    }
}
