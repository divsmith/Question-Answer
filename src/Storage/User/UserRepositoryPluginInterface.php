<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:18 AM
 */

namespace App\Storage\User;


use App\Domain\User;

interface UserRepositoryPluginInterface
{
    public function getByEmail($email);
    public function store(User $user);
    public function getAll();
    public function delete($email);
    public function deleteAll();
}