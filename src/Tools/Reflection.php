<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tools;

/**
 * Reflection.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Reflection
{
    /**
     * @param string $class
     *
     * @phpstan-param class-string $class
     *
     * @return \ArrayObject
     *
     * @throws \ReflectionException
     */
    public static function composites(string $class): \ArrayObject
    {
        $refClass = new \ReflectionClass($class);
        $composites = [$class => $refClass->newInstanceWithoutConstructor()];

        foreach ($refClass->getProperties() as $property) {
            if (null === $type = $property->getType()) {
                continue;
            }

            /** @var \ReflectionNamedType $type */
            $name = $type->getName();

            if (class_exists($name)) {
                $composites[$name] = new $name();
            }
        }

        return new \ArrayObject($composites);
    }

    /**
     * @param string   $class
     * @param string[] $uses
     *
     * @return string[]
     *
     * @phpstan-param class-string $class
     */
    public static function uses(string $class, array $uses = []): array
    {
        try {
            $fqns = self::composites($class);
        } catch (\ReflectionException $e) {
            $fqns = [];
        }

        foreach ($fqns as $fqn) {
            $uses[] = \get_class($fqn);
        }

        return $uses;
    }
}
