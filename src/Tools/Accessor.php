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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionProperty;

/**
 * Accessor.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Accessor
{
    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionProperty $property
     *
     * @return string
     */
    public static function reader(ReflectionProperty $property): string
    {
        if (null === $type = $property->getType()) {
            return sprintf('get%s', ucfirst($property->getName()));
        }

        /** @var \ReflectionNamedType $type */
        if ('bool' === $type->getName() && false === $type->allowsNull()) {
            return sprintf('is%s', ucfirst($property->getName()));
        }

        return sprintf('get%s', ucfirst($property->getName()));
    }

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionProperty $property
     *
     * @return string
     */
    public static function writer(ReflectionProperty $property): string
    {
        if (null === $property->getType()) {
            return sprintf('set%s', ucfirst($property->getName()));
        }

        return self::isIterable($property) ? sprintf('add%s', ucfirst(rtrim($property->getName(), 's'))) : sprintf('set%s', ucfirst($property->getName()));
    }

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionProperty $property
     *
     * @return string
     */
    public static function remover(ReflectionProperty $property): string
    {
        return sprintf('remove%s', ucfirst(rtrim($property->getName(), 's')));
    }

    /**
     * @param string $class
     *
     * @phpstan-param class-string $class
     *
     * @return array<string, array<string, string|null>>
     *
     * @throws \Roave\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public static function all(string $class): array
    {
        $refClass = (new BetterReflection())->classReflector()->reflect($class);

        $accessors = [];

        foreach ($refClass->getProperties() as $property) {
            $accessors[$property->getName()] = [
                'reader' => self::reader($property),
                'writer' => self::writer($property),
                'remover' => self::isIterable($property) ? self::remover($property) : null,
            ];
        }

        return $accessors;
    }

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionProperty $property
     *
     * @return bool
     *
     * @infection-ignore-all
     */
    public static function isIterable(ReflectionProperty $property): bool
    {
        // tested @ \WickedOne\Muppet\Tests\Unit\Tools\AccessorTest::testIterable with property 'foo'
        if (null === $type = $property->getType()) {
            return false;
        }

        /** @var \ReflectionNamedType $type */
        $namedType = $type->getName();

        // tested @ \WickedOne\Muppet\Tests\Unit\Tools\AccessorTest::testIterable with property 'bor', 'bar' & 'baz'
        return \in_array($namedType, ['array', ArrayCollection::class, Collection::class], true);
    }
}
