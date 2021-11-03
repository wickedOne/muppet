<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\DocBlock;

use WickedOne\Muppet\Contract\DocBlockInterface;

/**
 * Dock Block.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class DockBlock implements DocBlockInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(string $normalizedName, ?string $author = null): iterable
    {
        $return = [
            sprintf('%s Test.', $normalizedName),
        ];

        if (null !== $author) {
            $return[] = \PHP_EOL;
            $return[] = sprintf('@author %s', $author);
        }

        return $return;
    }
}
