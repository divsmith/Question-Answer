<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 3:00 PM
 */

namespace App\Storage\Session;


class PHPSessionPlugin implements SessionRepositoryPluginInterface
{
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function get($key)
    {
        if ($this->has($key))
        {
            return $_SESSION[$key];
        }

        return null;
    }

    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
        return true;
    }
}