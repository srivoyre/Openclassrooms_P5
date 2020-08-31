<?php

namespace App\src;

/**
 * Class Parameter
 * @package App\src
 */
class Parameter
{
    private $parameter;

    /**
     * Parameter constructor.
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if( isset($this->parameter[$name])) {
            return $this->parameter[$name];
        }
    }

    /**
     * @param string $name
     * @param $value
     */
    public function set(string $name, $value)
    {
        $this->parameter[$name] = $value;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->parameter;
    }
}