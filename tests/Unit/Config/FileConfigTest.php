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
        $config = new Config(
            __DIR__.'/////',
            __DIR__.'/////',
            [
                'WickedOne',
                'Muppet',
                'Tests',
                'Unit',
            ],
            'foo <bar@qux.com>'
        );

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
     * test generating correct namespace when fragments have keys which are out of sync.
     */
    public function testArrayValues(): void
    {
        $fileInfo = new SplFileInfo(__DIR__.'/../../../src/Template/TestTemplate.php', __DIR__.'/../../../src/Template/TestTemplate.php', __DIR__.'/../../../src/Template');
        $config = new Config(
            __DIR__.'/////',
            __DIR__.'/////',
            [
                2 => 'WickedOne',
                3 => 'Muppet',
                4 => 'Tests',
                5 => 'Unit',
            ],
            'foo <bar@qux.com>'
        );

        $fileConfig = new FileConfig($fileInfo, $config);

        self::assertSame('WickedOne\\Muppet\\Tests\\Unit\\Template', $fileConfig->getTestNameSpace());

        $path = $fileConfig->getTestPath();

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
        $config = new Config(
            __DIR__.'/////',
            __DIR__.'/////',
            [
                'WickedOne',
                'Muppet',
                'Tests',
                'Unit',
            ],
            'foo <bar@qux.com>'
        );

        new FileConfig($fileInfo, $config);
    }

    /**
     * Test no `Tests` in namespace.
     */
    public function testNoTestsNamespace(): void
    {
        $fileInfo = new SplFileInfo(__DIR__.'/../../../src/Template/TestTemplate.php', __DIR__.'/../../../src/Template/TestTemplate.php', __DIR__.'/../../../src/Template');
        $config = new Config(
            __DIR__.'/////',
            __DIR__.'/////',
            [
                'WickedOne',
                'Muppet',
                'Unit',
            ],
            'foo <bar@qux.com>'
        );

        $fileConfig = new FileConfig($fileInfo, $config);

        self::assertSame('WickedOne\Muppet\Unit\Muppet\Template', $fileConfig->getTestNameSpace());

        rmdir($fileConfig->getTestPath());
        rmdir(\dirname($fileConfig->getTestPath(), 1));
    }
}
