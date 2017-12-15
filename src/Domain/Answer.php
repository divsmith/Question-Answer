<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/14/17
 * Time: 5:35 PM
 */

namespace App\Domain;


class Answer
{
    private $uuid;
    private $text;
    private $userEmail;

    public function __construct($uuid, $text, $userEmail)
    {
        if (empty($uuid) || empty($text) || empty($userEmail)) {
            throw new \InvalidArgumentException("empty arguments");
        }

        if (!is_string($uuid) || !is_string($text) || !is_string($userEmail)) {
            throw new \InvalidArgumentException("arguments are not strings");
        }

        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("email is not valid");
        }

        $this->uuid = $uuid;
        $this->text = $text;
        $this->userEmail = $userEmail;
    }

    public function uuid()
    {
        return $this->uuid;
    }

    public function text()
    {
        return $this->text;
    }

    public function userEmail()
    {
        return $this->userEmail;
    }
}