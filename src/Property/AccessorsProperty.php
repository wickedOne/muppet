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
use WickedOne\Muppet\Tools\Accessor;

/**
 * Accessors Property.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class AccessorsProperty implements PropertyInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(string $class): Property
    {
        return (new Property('accessors'))
            ->setPrivate()
            ->setStatic()
            ->setType('array')
            ->setValue(Accessor::all($class))
            ->setComment(\PHP_EOL.'@var array<string, array<string, string|null>>')
        ;
    }
}
