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

use Symfony\Component\Finder\SplFileInfo;
use WickedOne\Muppet\Exception\RuntimeException;

/**
 * FileConfig.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class FileConfig
{
    /**
     * @var string
     */
    private string $nameSpace;

    /**
     * @var string
     */
    private string $testNameSpace;

    /**
     * @var string
     */
    private string $testPath;

    /**
     * @var string
     */
    private string $file;
    /**
     * @var string
     */
    private string $normalizedName;

    /**
     * @var string
     *
     * @phpstan-var class-string
     */
    private string $fqns;

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $fileInfo
     * @param \WickedOne\Muppet\Config\Config       $config
     */
    public function __construct(SplFileInfo $fileInfo, Config $config)
    {
        if (0 === preg_match('/namespace ([^;]+);/', $fileInfo->getContents(), $matches)) {
            throw new RuntimeException(sprintf('no namespace found for %s', $fileInfo->getFilename()));
        }

        $this->file = $fileInfo->getFilenameWithoutExtension();

        $this->nameSpace = $matches[1];
        $this->testNameSpace = implode('\\', array_merge($config->getFragments(), \array_slice(explode('\\', $this->nameSpace), 2)));

        $this->normalizedName = preg_replace('/(?<=[a-z])(?=[A-Z])/', ' ', $this->file) ?? $this->file;
        $this->fqns = sprintf('%s\\%s', $this->nameSpace, $this->file); /* @phpstan-ignore-line */

        /* @infection-ignore-all */
        $this->testPath = sprintf('%s/%s', rtrim($config->getTestDir(), '/'), implode('/', \array_slice(explode('\\', $this->nameSpace), 2)));
        $this->testPath = realpath($this->testPath) ?: $this->testPath;

        /* @infection-ignore-all */
        if (!is_dir($this->testPath) && !mkdir($concurrentDirectory = $this->testPath, 0755, true) && !is_dir($concurrentDirectory)) {
            // @codeCoverageIgnoreStart
            throw new RuntimeException(sprintf('directory "%s" was not created', $concurrentDirectory));
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->nameSpace;
    }

    /**
     * @return string
     */
    public function getTestNameSpace(): string
    {
        return $this->testNameSpace;
    }

    /**
     * @return string
     */
    public function getTestPath(): string
    {
        return $this->testPath;
    }

    /**
     * @return string
     */
    public function getTestFileName(): string
    {
        return sprintf('%s/%sTest.php', $this->getTestPath(), $this->getFile());
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getNormalizedName(): string
    {
        return $this->normalizedName;
    }

    /**
     * @return string
     *
     * @phpstan-return class-string
     */
    public function getFqns(): string
    {
        return $this->fqns;
    }
}
