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

use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\PropertyGenerator;
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
    public function get(string $class): PropertyGenerator
    {
        return PropertyGenerator::fromArray([
            'name' => 'nonNullable',
            'visibility' => AbstractMemberGenerator::VISIBILITY_PRIVATE,
            'defaultvalue' => Value::all($class, false),
            'static' => true,
        ]);
    }
}
