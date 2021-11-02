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

use Laminas\Code\Generator\DocBlockGenerator;
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
    public function get(string $normalizedName, ?string $author = null): DocBlockGenerator
    {
        if (null !== $author) {
            $tags = [
                [
                    'name' => 'author',
                    'description' => $author,
                ],
            ];
        } else {
            $tags = [];
        }

        return DocBlockGenerator::fromArray([
            'shortDescription' => sprintf('%s Test.', $normalizedName),
            'tags' => $tags,
        ]);
    }
}
