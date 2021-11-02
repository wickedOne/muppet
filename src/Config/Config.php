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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Config.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Config
{
    /**
     * @var \Symfony\Component\OptionsResolver\OptionsResolver
     */
    private static OptionsResolver $resolver;

    /**
     * @var array<string, string|string[]|null>
     */
    private array $options;

    /**
     * @param array<string, string|string[]|null> $options
     */
    public function __construct(array $options = [])
    {
        if (!isset(self::$resolver)) {
            self::$resolver = new OptionsResolver();
            $this->configureOptions(self::$resolver);
        }

        $this->options = self::$resolver->resolve($options);
    }

    /**
     * @return string[]
     */
    public function getFragments(): array
    {
        return $this->options['fragments'];
    }

    /**
     * @return string
     */
    public function getBaseDir(): string
    {
        return $this->options['base_dir'];
    }

    /**
     * @return string
     */
    public function getTestDir(): string
    {
        return $this->options['test_dir'];
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->options['author'];
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'author' => null,
        ]);

        $resolver
            ->setRequired(['fragments', 'base_dir', 'test_dir'])
            ->setAllowedTypes('fragments', 'array')
            ->setAllowedTypes('base_dir', 'string')
            ->setAllowedTypes('test_dir', 'string')
            ->setAllowedTypes('author', ['string', 'null'])
        ;
    }
}
