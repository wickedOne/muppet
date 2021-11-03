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

/**
 * Generator.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
interface GeneratorInterface
{
    /**
     * @param string $fileName
     *
     * @return string
     */
    public function generate(string $fileName): string;
}
