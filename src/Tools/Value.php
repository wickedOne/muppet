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
use phpDocumentor\Reflection\Types\Array_;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionProperty;
use WickedOne\Muppet\Exception\LogicException;

/**
 * Value.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Value
{
    /**
     * @param string $class
     * @param bool   $includeNullable
     *
     * @return array<string, false|float|int|string|array<array-key, false|float|int|string|null>|null>
     */
    public static function all(string $class, bool $includeNullable): array
    {
        $properties = [];
        $refClass = (new BetterReflection())->classReflector()->reflect($class);

        foreach ($refClass->getProperties() as $property) {
            if (false === $includeNullable && $property->allowsNull()) {
                continue;
            }

            if (null === $type = $property->getType()) {
                continue;
            }

            if (false === $includeNullable && \in_array($type->getName(), ['array', ArrayCollection::class], true)) {
                continue;
            }

            $value = !class_exists((string) $type) ? self::getValue($property, $includeNullable) : (string) $type;
            $properties[$property->getName()] = $value;
        }

        return $properties;
    }

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionProperty $property
     * @param bool                                                  $includeNullable
     *
     * @return false|float|int|string|null
     */
    public static function getValue(ReflectionProperty $property, bool $includeNullable)
    {
        if (!$includeNullable && $property->allowsNull()) {
            return null;
        }

        if (!$includeNullable && \in_array((string) $property->getType(), ['array', ArrayCollection::class], true)) {
            return null;
        }

        $namedType = (string) $property->getType();

        switch ($namedType) {
            case '':
            case 'int':
            case 'string':
            case 'bool':
            case 'float':
                return self::scalarToValue($namedType);
            case 'array':
            case ArrayCollection::class:
                $types = $property->getDocBlockTypes();

                if (!isset($types[0])) {
                    return null;
                }

                /** @var Array_[] $types */
                $valueType = (string) $types[0]->getValueType();

                return class_exists($valueType) ? $valueType : self::scalarToValue($valueType);
            default:
                if (class_exists($namedType)) {
                    return $namedType;
                }

                throw new LogicException(sprintf('unable to generate dummy value for %s', $namedType));
        }
    }

    /**
     * @param string $type
     *
     * @return false|float|int|string|null
     */
    public static function scalarToValue(string $type)
    {
        switch ($type) {
            case '':
                return 'qux';
            case 'int':
                return 3;
            case 'string':
                return 'foo';
            case 'bool':
                return false;
            case 'float':
                return 0.43144251845378545;
            default:
                return null;
        }
    }
}
