<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:30 AM
 */

namespace App\Storage\Session;


interface SessionRepositoryPluginInterface
{
    public function has($key);
    public function get($key);
    public function put($key, $value);
}