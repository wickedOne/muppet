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
 * Values Property.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class ValuesProperty implements PropertyInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(string $class): Property
    {
        return (new Property('values'))
            ->setPrivate()
            ->setValue(Value::all($class, true))
            ->setType('array')
            ->setComment(\PHP_EOL.'@var array<string, object|int|bool|string|float|null>')
        ;
    }
}
