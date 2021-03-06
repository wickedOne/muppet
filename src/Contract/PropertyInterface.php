<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Contract;

use Nette\PhpGenerator\Property;

/**
 * Property Interface.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
interface PropertyInterface
{
    /**
     * @param string $class
     *
     * @phpstan-param class-string $class
     *
     * @return \Nette\PhpGenerator\Property
     */
    public function get(string $class): Property;
}
