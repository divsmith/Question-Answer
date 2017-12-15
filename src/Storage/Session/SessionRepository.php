<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:39 AM
 */

namespace App\Storage\Session;


class SessionRepository
{
    private $plugin;

    public function __construct(SessionRepositoryPluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function has($key)
    {
        return $this->plugin->has($key);
    }

    public function get($key)
    {
        return $this->plugin->get($key);
    }

    public function put($key, $value)
    {
        return $this->plugin->put($key, $value);
    }
}