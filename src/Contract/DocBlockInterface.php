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

use Laminas\Code\Generator\DocBlockGenerator;

/**
 * DocBlock Interface.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
interface DocBlockInterface
{
    /**
     * @param string      $normalizedName
     * @param string|null $author
     *
     * @return \Laminas\Code\Generator\DocBlockGenerator
     */
    public function get(string $normalizedName, ?string $author): DocBlockGenerator;
}
