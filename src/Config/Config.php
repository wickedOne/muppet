<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Config;

/**
 * Config.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Config
{
    /**
     * @var array
     */
    private array $fragments;

    /**
     * @var string
     */
    private string $baseDir;

    /**
     * @var string
     */
    private string $testDir;

    /**
     * @var string|null
     */
    private ?string $author;

    /**
     * @param string      $baseDir
     * @param string      $testDir
     * @param array       $fragments
     * @param string|null $author
     */
    public function __construct(string $baseDir, string $testDir, array $fragments, ?string $author = null)
    {
        $this->fragments = $fragments;
        $this->baseDir = $baseDir;
        $this->testDir = $testDir;
        $this->author = $author;
    }

    /**
     * @return array
     */
    public function getFragments(): array
    {
        return $this->fragments;
    }

    /**
     * @return string
     */
    public function getBaseDir(): string
    {
        return $this->baseDir;
    }

    /**
     * @return string
     */
    public function getTestDir(): string
    {
        return $this->testDir;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }
}
