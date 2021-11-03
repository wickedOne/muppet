<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Unit;

use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\Property;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use WickedOne\Muppet\Config\Config;
use WickedOne\Muppet\Contract\DocBlockInterface;
use WickedOne\Muppet\Contract\MethodInterface;
use WickedOne\Muppet\Contract\PropertyInterface;
use WickedOne\Muppet\Exception\RuntimeException;
use WickedOne\Muppet\Generator;

/**
 * GeneratorTest.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class GeneratorTest extends TestCase
{
    /**
     * test generate.
     */
    public function testGenerate(): void
    {
        $config = new Config([
            'base_dir' => __DIR__,
            'test_dir' => __DIR__,
            'author' => 'foo <bar@qux.com>',
            'fragments' => [
                'Foo',
                'Bar',
                'Tests',
                'Unit',
            ],
        ]);

        $docBlock = $this->getMockBuilder(DocBlockInterface::class)->getMock();
        $docBlock->expects(self::once())->method('get')->willReturn([]);

        $fileInfo = new SplFileInfo(__DIR__.'/../../src/Template/TestTemplate.php', __DIR__.'/../../src/Template/TestTemplate.php', __DIR__.'/../../src/Template');

        $finder = $this->getMockBuilder(Finder::class)->getMock();
        $finder->expects(self::once())->method('name')->with('foo.php')->willReturnSelf();
        $finder->expects(self::once())->method('files')->willReturnSelf();
        $finder->expects(self::once())->method('getIterator')->willReturn(new \ArrayIterator([$fileInfo]));

        $property = $this->getMockBuilder(PropertyInterface::class)->getMock();
        $property->expects(self::once())->method('get')->willReturn(new Property('foo'));

        $method = $this->getMockBuilder(MethodInterface::class)->getMock();
        $method->expects(self::once())->method('get')->willReturn(new Method('bar'));

        $generator = new Generator($config, [$property], [$method], $docBlock, $finder);
        $path = $generator->generate('foo');

        unlink($path);
        rmdir(\dirname($path));
    }

    /**
     * test defaults.
     */
    public function testDefaultMethodsAndProperties(): void
    {
        $config = new Config([
            'base_dir' => __DIR__.'/../Stub',
            'test_dir' => __DIR__,
            'author' => 'foo <bar@qux.com>',
            'fragments' => [
                'WickedOne',
                'Muppet',
                'Tests',
                'Unit',
            ],
        ]);

        $generator = new Generator($config);

        $fileInfo = new SplFileInfo($generator->generate('StubModel'), __DIR__, __DIR__);

        self::assertStringContainsString('testStubModelReadWritePropertiesMethods', $fileInfo->getContents());
        self::assertStringContainsString('private function value', $fileInfo->getContents());
        self::assertStringContainsString('private static string $class', $fileInfo->getContents());
        self::assertStringContainsString('private array $values', $fileInfo->getContents());
        self::assertStringContainsString('private static array $nonNullable', $fileInfo->getContents());
        self::assertStringContainsString('private static array $accessors', $fileInfo->getContents());
        self::assertStringContainsString('namespace WickedOne\Muppet\Tests\Unit\Tests\Stub\Model', $fileInfo->getContents());
        self::assertStringContainsString('declare(strict_types=1)', $fileInfo->getContents());
        self::assertStringContainsString('use PHPUnit\Framework\TestCase;', $fileInfo->getContents());
        self::assertStringContainsString('use WickedOne\Muppet\Tests\Stub\Model\StubModel;', $fileInfo->getContents());
        self::assertStringContainsString('@author foo <bar@qux.com>', $fileInfo->getContents());

        unlink($fileInfo->getPathname());

        rmdir(\dirname($fileInfo->getPathname()));
        rmdir(\dirname($fileInfo->getPathname(), 2));
        rmdir(\dirname($fileInfo->getPathname(), 3));
    }

    /**
     * test no file found exception.
     */
    public function testNoFileFoundException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('no file found for foo');

        $config = new Config([
            'base_dir' => __DIR__,
            'test_dir' => __DIR__,
            'author' => 'foo <bar@qux.com>',
            'fragments' => [
                'Foo',
                'Bar',
                'Test',
                'Unit',
            ],
        ]);

        $generator = new Generator($config);

        $generator->generate('foo');
    }
}
