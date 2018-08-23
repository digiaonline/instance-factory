<?php

namespace Digia\InstanceFactory\Tests;

use Digia\InstanceFactory\InstanceFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class InstanceFactoryTest
 * @package Digia\InstanceFactory\Tests
 */
class InstanceFactoryTest extends TestCase
{

    /**
     * @throws \ReflectionException
     */
    public function testFromPropertiesWithoutOptional(): void
    {
        $properties = [
            'bar' => 42,
            'foo' => 'asd',
            'qux' => 'asd',
        ];

        $dummy = InstanceFactory::fromProperties(Dummy::class, $properties);

        $this->assertEquals($properties['foo'], $dummy->foo);
        $this->assertEquals($properties['bar'], $dummy->bar);
        $this->assertEquals([], $dummy->baz);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFromPropertiesWithOptional(): void
    {
        $properties = [
            'bar' => 42,
            'foo' => 'asd',
            'qux' => 'asd',
            'baz' => [1, 2, 3],
        ];

        $dummy = InstanceFactory::fromProperties(Dummy::class, $properties);

        $this->assertEquals($properties['foo'], $dummy->foo);
        $this->assertEquals($properties['bar'], $dummy->bar);
        $this->assertEquals($properties['baz'], $dummy->baz);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFromPropertiesWithNullable(): void
    {
        $properties = [
            'bar' => 42,
            'foo' => 'asd',
            'qux' => null,
        ];

        $dummy = InstanceFactory::fromProperties(Dummy::class, $properties);

        $this->assertEquals($properties['foo'], $dummy->foo);
        $this->assertEquals($properties['bar'], $dummy->bar);
        $this->assertEquals($properties['qux'], $dummy->qux);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @throws \ReflectionException
     */
    public function testFromPropertiesWithInvalid(): void
    {
        InstanceFactory::fromProperties(Dummy::class, ['quuix' => 1.23]);
    }
}

/**
 * Class Dummy
 * @package Digia\InstanceFactory\Tests
 */
class Dummy
{

    /**
     * @var string
     */
    public $foo;

    /**
     * @var int
     */
    public $bar;

    /**
     * @var ?string
     */
    public $qux;

    /**
     * @var array
     */
    public $baz;

    /**
     * Dummy constructor.
     *
     * @param string      $foo
     * @param int         $bar
     * @param string|null $qux
     * @param array       $baz
     */
    public function __construct(string $foo, int $bar, ?string $qux, array $baz = [])
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->qux = $qux;
        $this->baz = $baz;
    }
}

