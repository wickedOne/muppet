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

use Nette\PhpGenerator\Method;

/**
 * Method Interface.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
interface MethodInterface
{
    /**
     * @param string $file
     *
     * @return \Nette\PhpGenerator\Method
     */
    public function get(string $file): Method;
}
