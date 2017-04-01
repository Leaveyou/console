<?php

namespace Leaveyou\Console;



trait ParameterIterator
{
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
