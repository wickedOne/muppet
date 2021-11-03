<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Property;

use Nette\PhpGenerator\Property;
use WickedOne\Muppet\Contract\PropertyInterface;
use WickedOne\Muppet\Tools\Value;

/**
 * Non Nullable Property.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class NonNullableProperty implements PropertyInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(string $class): Property
    {
        return (new Property('nonNullable'))
            ->setPrivate()
            ->setStatic()
            ->setType('array')
            ->setValue(array_keys(Value::all($class, false)))
            ->setComment(\PHP_EOL.'@var string[]')
        ;
    }
}
