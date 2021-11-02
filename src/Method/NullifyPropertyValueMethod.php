<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Method;

use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Reflection\MethodReflection;
use WickedOne\Muppet\Contract\MethodInterface;
use WickedOne\Muppet\Template\TestTemplate;

/**
 * nullify Property Value Method.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class NullifyPropertyValueMethod implements MethodInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(string $file): MethodGenerator
    {
        $generator = MethodGenerator::fromReflection(new MethodReflection(TestTemplate::class, 'testNullifyPropertyValues'));
        $generator->setName(sprintf('test%sNullifyPropertyValues', $file));

        return $generator;
    }
}
