<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit\Config;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;
use WickedOne\Muppet\Config\Config;
use WickedOne\Muppet\Config\FileConfig;
use WickedOne\Muppet\Exception\RuntimeException;

/**
 * FileConfigTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class FileConfigTest extends TestCase
{
    /**
     * test file config.
     */
    public function testFileConfig(): void
    {
        $fileInfo = new SplFileInfo(__DIR__.'/../../../src/Template/TestTemplate.php', __DIR__.'/../../../src/Template/TestTemplate.php', __DIR__.'/../../../src/Template');
        $config = new Config([
            'base_dir' => __DIR__.'/////',
            'test_dir' => __DIR__.'/////',
            'author' => 'foo <bar@qux.com>',
            'fragments' => [
                'WickedOne',
                'Muppet',
                'Tests',
                'Unit',
            ],
        ]);

        $fileConfig = new FileConfig($fileInfo, $config);

        self::assertSame('TestTemplate', $fileConfig->getFile());
        self::assertSame('Test Template', $fileConfig->getNormalizedName());
        self::assertSame('WickedOne\\Muppet\\Template\\TestTemplate', $fileConfig->getFqns());
        self::assertSame('WickedOne\\Muppet\\Tests\\Unit\\Template', $fileConfig->getTestNameSpace());
        self::assertSame('WickedOne\\Muppet\\Template', $fileConfig->getNameSpace());
        self::assertSame(__DIR__.'/Template', $fileConfig->getTestPath());
        self::assertSame(__DIR__.'/Template/TestTemplateTest.php', $fileConfig->getTestFileName());

        $path = $fileConfig->getTestPath();

        self::assertSame($path, $fileConfig->getTestPath());
        self::assertTrue(is_writable($path));

        rmdir($path);
    }

    /**
     * test no namespace.
     */
    public function testNoNamespace(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('no namespace found for foo.php');

        $fileInfo = new SplFileInfo(__DIR__.'/../../Stub/foo.php', __DIR__.'/../../Stub/foo.php', __DIR__.'/../../Stub/foo.php');
        $config = new Config([
            'base_dir' => __DIR__,
            'test_dir' => __DIR__,
            'author' => 'foo <bar@qux.com>',
            'fragments' => [
                'WickedOne',
                'Muppet',
                'Tests',
                'Unit',
            ],
        ]);

        new FileConfig($fileInfo, $config);
    }
}
