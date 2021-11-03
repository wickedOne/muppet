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

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use WickedOne\Muppet\Contract\MethodInterface;
use WickedOne\Muppet\Template\TestTemplate;

/**
 * Read Write Test Method.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class ReadWriteTestMethod implements MethodInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(string $file): Method
    {
        return ClassType::from(TestTemplate::class, true)
            ->getMethod('testReadWritePropertiesMethods')
            ->cloneWithName(sprintf('test%sReadWritePropertiesMethods', $file))
        ;
    }
}
