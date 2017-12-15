<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 2:53 PM
 */

namespace App\Storage\Session;


class MemorySessionPlugin implements SessionRepositoryPluginInterface 
{
    private $values = [];

    public function __construct($values = [])
    {
        $this->values = $values;
    }

    public function has($key)
    {
        return isset($this->values[$key]);
    }

    public function get($key)
    {
        if ($this->has($key))
        {
            return $this->values[$key];
        }

        return null;
    }

    public function put($key, $value)
    {
        $this->values[$key] = $value;
        return true;
    }
}