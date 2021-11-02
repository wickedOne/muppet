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

/**
 * ClassProperty.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class ClassProperty implements PropertyInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(string $class): PropertyGenerator
    {
        return PropertyGenerator::fromArray([
            'name' => 'class',
            'visibility' => AbstractMemberGenerator::VISIBILITY_PRIVATE,
            'defaultvalue' => $class,
            'static' => true,
        ]);
    }
}
