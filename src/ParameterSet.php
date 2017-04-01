<?php

namespace Leaveyou\Console;

use InvalidArgumentException;

class ParameterSet implements \Iterator
{
    /**
     * The accepted parameters indexed by longName
     * @var Parameter[]
     */
    protected $parameterIndex = [];

    /**
     * The accepted parameters indexed by shortName
     * This is so that parameters can be looked up efficiently
     * Objects are assigned by reference so this has little memory impact
     * @var Parameter[]
     */
    protected $reverseIndex = [];

    /**
     * @param Parameter $parameter
     * @throws InvalidArgumentException
     */
    public function addParameter(Parameter $parameter)
    {
        $this->pushMainIndex($parameter);
        $this->pushReverseIndex($parameter);
    }

    /**
     * Returns parameter by name.
     * @param string $name
     * @return Parameter
     */
    public function getByEitherName($name)
    {
        if (strlen($name) == 1) {
            $return = $this->getByShortName($name);
        } else {
            $return = $this->getByLongName($name);
        }


        return $return;
    }

    /**
     * @param $shortName
     * @return Parameter
     * @throws InvalidArgumentException
     */
    protected function getByShortName($shortName)
    {
        if (!isset($this->reverseIndex[$shortName])) {
            throw new InvalidArgumentException("Parameter with short name \"$shortName\" isn't defined");
        }
        return $this->reverseIndex[$shortName];
    }


    /**
     * @param string $longName
     * @return Parameter
     * @throws InvalidArgumentException
     */
    protected function getByLongName($longName)
    {
        if (!isset($this->parameterIndex[$longName])) {
            throw new InvalidArgumentException("Parameter with name \"$longName\" isn't defined");
        }
        return $this->parameterIndex[$longName];
    }

    /**
     * @param Parameter $parameter
     * @throws InvalidArgumentException
     */
    protected function pushMainIndex(Parameter $parameter)
    {
        $longName = $parameter->getLongName();
        if (isset($this->parameterIndex[$longName])) {
            throw new InvalidArgumentException("The parameter longName property \"--$longName\" is already defined");
        }

        // prepend value
        $this->parameterIndex = [$longName => $parameter] + $this->parameterIndex;
    }

    /**
     * @param Parameter $parameter
     * @throws InvalidArgumentException
     */
    protected function pushReverseIndex(Parameter $parameter)
    {
        $shortName = $parameter->getShortName();
        if (strlen($shortName) && isset($this->reverseIndex[$shortName])) {
            throw new InvalidArgumentException("The parameter shortName property \"-$shortName\" is already defined");
        }
        $this->reverseIndex[$shortName] = $parameter;
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return Parameter Can return any type.
     */
    public function current()
    {
        return current($this->parameterIndex);
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->parameterIndex);
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->parameterIndex);
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        $key = key($this->parameterIndex);
        return ($key !== null && $key !== false);
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->parameterIndex);
    }
}
