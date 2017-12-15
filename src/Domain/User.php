<?php
/**
 * 20171011User class
 */

namespace App\Domain;

class User
{
    private $email;
    private $name;
    private $hash;
    private $upvoted;

    public function __construct($email, $name, $hash, $upvoted = [])
    {
        if (empty($email) || empty($name) || empty($hash)) {
            throw new \InvalidArgumentException("empty arguments");
        }

        if (!is_string($email) || !is_string($name) || !is_string($hash)) {
            throw new \InvalidArgumentException("arguments are not strings");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("email is not valid");
        }

        $this->email = $email;
        $this->name = $name;
        $this->hash = $hash;
        $this->upvoted = $upvoted;
    }

    public function upvoted($uuid)
    {
        return in_array($uuid, $this->upvoted);
    }

    public function email()
    {
        return $this->email;
    }

    public function name()
    {
        return $this->name;
    }

    public function password_verify($password)
    {
        return password_verify($password, $this->hash);
    }
}
