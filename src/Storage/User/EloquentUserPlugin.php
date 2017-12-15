<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 12:09 PM
 */

namespace App\Storage\User;


use App\Domain\User;
use Illuminate\Database\Query\Builder;

class EloquentUserPlugin implements UserRepositoryPluginInterface
{
    private $table;

    public function __construct(Builder $table)
    {
        $this->table = $table;
    }

    public function store(User $user)
    {
        $eloquentUser = new \App\Models\User(['name' => $user->name(), 'email' => $user->email(), 'password' => $user->hash()]);

        return $eloquentUser->save();
    }

    public function getAll()
    {
        $eloquentUsers = \App\Models\User::all()->toArray();

        $return = null;

        if (sizeof($eloquentUsers) > 0)
        {
            $return = [];
            foreach($eloquentUsers as $eloquentUser)
            {
                $return[] = new User($eloquentUser['email'], $eloquentUser['name'], $eloquentUser['password']);
            }
        }

        return $return;
    }

    public function getByEmail($email)
    {
        $user = \App\Models\User::whereEmail($email)->first();

        if ($user)
        {
            $user = $user->toArray();
            return new User($user['email'], $user['name'], $user['password']);
        }

        return null;
    }

    public function delete($email)
    {
        $user = \App\Models\User::whereEmail($email)->first();

        if ($user)
        {
            $user->delete();
            return true;
        }

        return null;
    }

    public function deleteAll()
    {
        \App\Models\User::truncate();
    }
}