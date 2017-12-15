<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:44 AM
 */

namespace App\Storage\User;


use App\Domain\User;

class MemoryUserPlugin implements UserRepositoryPluginInterface
{
    private $users = [];

    public function __construct($users = [])
    {
        $this->users = $users;
    }

    public function getByEmail($email)
    {
        if (isset($this->users[$email]))
        {
            return $this->users[$email];
        }

        return null;
    }

    public function store(User $user)
    {
        $this->users[$user->email()] = $user;
        return true;
    }

    public function getAll()
    {
        if (sizeof($this->users) > 0)
        {
            return array_values($this->users);
        }

        return null;
    }

    public function delete($email)
    {
        if (isset($this->users[$email]))
        {
            unset($this->users[$email]);
            return true;
        }

        return null;
    }

    public function deleteAll()
    {
        $this->users = [];
    }
}