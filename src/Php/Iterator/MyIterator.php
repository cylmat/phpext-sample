<?php

declare(strict_types=1);

namespace Iterator;

/**
 * PHP
 *
 * Interface for iterator (current, key, rewind, next, valid)
 */
class MyIterator implements \Iterator #Traversable
{
    protected $zero = 'propriete';
    protected $un = 'access';
    protected $semaphore = '3';
    protected $quatre = 'extrait';
    protected $cinq = 'partie';
    protected $différence = 887;
    private $_pointer = 'zero';
    private $_keys = [];

    public function __construct()
    {
        $this->_keys = array_diff(array_keys(get_class_vars(self::class)), ['_pointer','_keys']);
    }

    public function set($name, $value): bool
    {
        if (property_exists($this, $name) && in_array($name, $this->_keys)) {
            $this->$name = $value;
            return true;
        }
        return false;
    }

    public function get($name)
    {
        if (property_exists($this, $name) && in_array($name, $this->_keys)) {
            return $this->$name;
        }
        return null;
    }

    public function current() #mixed
    {
        return $this->get($this->_pointer);
    }
    public function key() #mixed
    {
        return $this->pointer;
    }
    public function next(): void
    {
        $this->_pointer = next($this->_keys);
    }
    public function rewind(): void
    {
        $this->_pointer = 'zero';
    }
    public function valid(): bool
    {
        return property_exists($this, $this->_pointer);
    }
}
