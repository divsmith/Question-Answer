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
        foreach($this->users as $user)
        {
            if ($user->email() == $email)
            {
                return $user;
            }
        }

        return null;
    }

    public function store(User $user)
    {
        // TODO: Implement store() method.
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}