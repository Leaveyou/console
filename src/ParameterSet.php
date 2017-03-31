<?php

namespace Leaveyou\Console;


use BadMethodCallException;

class ParameterSet implements \ArrayAccess, \Iterator
{
    /**
     * The accepted parameters indexed by longName
     * @var Parameter[]
     */
    protected $parameterIndex = [];

    /**
     * The accepted parameters indexed by shortName
     * This is so that parameters can be looked up efficiently
     * Objects are assigned by reference
     * @var Parameter[]
     */
    protected $reverseIndex = [];

    /**
     * @param Parameter $parameter
     * @throws BadMethodCallException
     */
    public function addParameter(Parameter $parameter)
    {
        $this->pushMainIndex($parameter);
        $this->pushReverseIndex($parameter);
    }

    /**
     * @param $shortName
     * @return Parameter
     */
    public function getByShortName($shortName)
    {
        if (!isset($this->reverseIndex[$shortName])) {
            return null;
        }
        return $this->reverseIndex[$shortName];
    }


    /**
     * @param string$longName
     * @return Parameter
     */
    public function getByLongName($longName)
    {
        if (!isset($this->parameterIndex[$longName])) {
            return null;
        }
        return $this->parameterIndex[$longName];
    }

    /**
     * @param Parameter $parameter
     * @throws BadMethodCallException
     */
    protected function pushMainIndex(Parameter $parameter)
    {
        $longName = $parameter->getLongName();
        if (!is_null($this->getByLongName($longName))) {
            throw new BadMethodCallException("The parameter longName property \"--$longName\" is already defined");
        }
        $this->parameterIndex[$longName] = $parameter;
    }

    /**
     * @param Parameter $parameter
     * @throws BadMethodCallException
     */
    protected function pushReverseIndex(Parameter $parameter)
    {
        $shortName = $parameter->getShortName();
        if (!is_null($this->getByShortName($shortName))) {
            throw new BadMethodCallException("The parameter shortName property \"-$shortName\" is already defined");
        }
        $this->parameterIndex[$shortName] = $parameter;
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     * @return boolean true on success or false on failure.
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}