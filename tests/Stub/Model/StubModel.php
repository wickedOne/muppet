<?php

declare(strict_types=1);

/*
 * This file is part of the Muppet library.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WickedOne\Muppet\Tests\Stub\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * StubModel.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class StubModel
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string|null
     */
    protected ?string $value = null;

    private $foo;

    private ArrayCollection $bor;

    /**
     * @var array
     */
    private array $bar = [];

    /**
     * @var bool
     */
    private bool $baz;

    private int $boo;

    private float $brrr;

    /**
     * @var bool|null
     */
    private ?bool $qux;

    /**
     * @var \WickedOne\Muppet\Tests\Stub\Model\SubStub
     */
    private SubStub $quux;

    private array $bas;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->foo = new ArrayCollection();
        $this->bor = new ArrayCollection();
    }

    /**
     * @return bool|null
     */
    public function getQux(): ?bool
    {
        return $this->qux;
    }

    /**
     * @param bool|null $qux
     */
    public function setQux(?bool $qux): void
    {
        $this->qux = $qux;
    }

    /**
     * @return bool
     */
    public function isBaz(): bool
    {
        return $this->baz;
    }

    /**
     * @param bool $baz
     */
    public function setBaz(bool $baz): void
    {
        $this->baz = $baz;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @param mixed $foo
     */
    public function setFoo($foo): void
    {
        $this->foo = $foo;
    }

    /**
     * @return array
     */
    public function getBar(): array
    {
        return $this->bar;
    }

    /**
     * @param $bar
     */
    public function addBar($bar): void
    {
        if (false === \in_array($bar, $this->bar, true)) {
            $this->bar[] = $bar;
        }
    }

    /**
     * @param $bar
     *
     * @return bool
     */
    public function removeBar($bar): bool
    {
        if (false === $key = array_search($bar, $this->bar, true)) {
            unset($this->bar[$key]);

            return true;
        }

        return false;
    }

    /**
     * @param $bas
     */
    public function addBa($bas): void
    {
        if (false === \in_array($bas, $this->bas, true)) {
            $this->bas[] = $bas;
        }
    }

    /**
     * @param $bas
     *
     * @return bool
     */
    public function removeBa($bas): bool
    {
        if (false === $key = array_search($bas, $this->bas, true)) {
            unset($this->bas[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getBoo(): int
    {
        return $this->boo;
    }

    /**
     * @param int $boo
     */
    public function setBoo(int $boo): void
    {
        $this->boo = $boo;
    }

    /**
     * @return float
     */
    public function getBrrr(): float
    {
        return $this->brrr;
    }

    /**
     * @param float $brrr
     */
    public function setBrrr(float $brrr): void
    {
        $this->brrr = $brrr;
    }

    /**
     * @return \WickedOne\Muppet\Tests\Stub\Model\SubStub
     */
    public function getQuux(): SubStub
    {
        return $this->quux;
    }

    /**
     * @param \WickedOne\Muppet\Tests\Stub\Model\SubStub $quux
     */
    public function setQuux(SubStub $quux): void
    {
        $this->quux = $quux;
    }
}
