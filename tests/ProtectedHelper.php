<?php

namespace Leaveyou\Console\Tests;


class ProtectedHelper
{
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;

    /**
     * @var mixed $injectedClass
     */
    protected $injectedClass;

    /**
     * Make every property accessible
     * @param $class
     */
    public function __construct($class)
    {
        $this->injectedClass = $class;
        $this->reflectionClass = new \ReflectionClass($class);
    }

    public function __get($name)
    {
        $property = $this->reflectionClass->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($this->injectedClass);
    }
}