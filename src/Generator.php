<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet;

use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\ValueGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use WickedOne\Muppet\Config\Config;
use WickedOne\Muppet\Config\FileConfig;
use WickedOne\Muppet\Contract\DocBlockInterface;
use WickedOne\Muppet\DocBlock\DockBlock;
use WickedOne\Muppet\Exception\RuntimeException;
use WickedOne\Muppet\Method\NullifyPropertyValueMethod;
use WickedOne\Muppet\Method\ReadWriteTestMethod;
use WickedOne\Muppet\Method\RemovePropertyValueMethod;
use WickedOne\Muppet\Method\ValueMethod;
use WickedOne\Muppet\Property\AccessorsProperty;
use WickedOne\Muppet\Property\ClassProperty;
use WickedOne\Muppet\Property\NonNullableProperty;
use WickedOne\Muppet\Property\ValuesProperty;
use WickedOne\Muppet\Tools\Reflection;

/**
 * Generator.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Generator
{
    /**
     * @var \WickedOne\Muppet\Config\Config
     */
    private Config $config;

    /**
     * @var \WickedOne\Muppet\Contract\PropertyInterface[]
     */
    private iterable $properties;

    /**
     * @var \WickedOne\Muppet\Contract\MethodInterface[]
     */
    private iterable $methods;

    /**
     * @var \WickedOne\Muppet\Contract\DocBlockInterface
     */
    private DocBlockInterface $docBlock;

    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private Finder $finder;

    /**
     * @param \WickedOne\Muppet\Config\Config                             $config
     * @param iterable<\WickedOne\Muppet\Contract\PropertyInterface>|null $properties
     * @param iterable<\WickedOne\Muppet\Contract\MethodInterface>|null   $methods
     * @param \WickedOne\Muppet\Contract\DocBlockInterface|null           $docBlock
     * @param \Symfony\Component\Finder\Finder|null                       $finder
     */
    public function __construct(Config $config, iterable $properties = null, iterable $methods = null, DocBlockInterface $docBlock = null, Finder $finder = null)
    {
        $this->config = $config;
        $this->properties = $properties ?? $this->defaultProperties();
        $this->methods = $methods ?? $this->defaultMethods();
        $this->docBlock = $docBlock ?? new DockBlock();
        $this->finder = $finder ?? new Finder();
        $this->finder->in($this->config->getBaseDir());
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    public function generate(string $fileName): string
    {
        foreach ($this->finder->name(sprintf('%s.php', $fileName))->files() as $file) {
            $fileConfig = new FileConfig($file, $this->config);

            $file = FileGenerator::fromArray([
                'filename' => $fileConfig->getTestFileName(),
                'namespace' => $fileConfig->getTestNameSpace(),
                'uses' => Reflection::uses($fileConfig->getFqns(), [[TestCase::class, null]]),
                'declares' => [
                    'strict_types' => 1,
                ],
            ]);

            $class = ClassGenerator::fromArray([
                'name' => sprintf('%sTest', $fileConfig->getFile()),
                'flags' => ClassGenerator::FLAG_FINAL,
                'extendedclass' => new ValueGenerator('TestCase', ValueGenerator::TYPE_CONSTANT),
            ]);

            $class
                ->setDocBlock($this->docBlock->get($fileConfig->getNormalizedName(), $this->config->getAuthor()));

            foreach ($this->properties as $property) {
                $class->addPropertyFromGenerator($property->get($fileConfig->getFqns()));
            }

            foreach ($this->methods as $method) {
                $class->addMethodFromGenerator($method->get($fileConfig->getFile()));
            }

            $file
                ->setClass($class)
                ->write()
            ;
        }

        if (!isset($fileConfig)) {
            throw new RuntimeException(sprintf('no file found for %s', $fileName));
        }

        return $fileConfig->getTestFileName();
    }

    /**
     * @return \WickedOne\Muppet\Contract\PropertyInterface[]
     */
    private function defaultProperties(): iterable
    {
        return [
            new ClassProperty(),
            new ValuesProperty(),
            new NonNullableProperty(),
            new AccessorsProperty(),
        ];
    }

    /**
     * @return \WickedOne\Muppet\Contract\MethodInterface[]
     */
    private function defaultMethods(): iterable
    {
        return [
            new ReadWriteTestMethod(),
            new RemovePropertyValueMethod(),
            new NullifyPropertyValueMethod(),
            new ValueMethod(),
        ];
    }
}
