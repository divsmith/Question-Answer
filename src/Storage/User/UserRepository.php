<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:31 AM
 */

namespace App\Storage\User;


use App\Domain\User;

class UserRepository
{
    private $plugin;

    public function __construct(UserRepositoryPluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getByEmail($email)
    {
        return $this->plugin->getByEmail($email);
    }

    public function store(User $user)
    {
        return $this->plugin->store($user);
    }

    public function getAll()
    {
        return $this->plugin->getAll();
    }

    public function delete($email)
    {
        return $this->plugin->delete($email);
    }

    public function deleteAll()
    {
        return $this->plugin->deleteAll();
    }
}