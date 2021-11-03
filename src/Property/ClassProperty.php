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

/**
 * Class Property.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class ClassProperty implements PropertyInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(string $class): Property
    {
        return (new Property('class'))
            ->setPrivate()
            ->setStatic()
            ->setType('string')
            ->setValue($class)
            ->setComment(\PHP_EOL.'@var class-string')
        ;
    }
}
