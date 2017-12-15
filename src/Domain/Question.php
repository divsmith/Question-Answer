<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/14/17
 * Time: 5:11 PM
 */

namespace App\Domain;


class Question
{
    private $uuid;
    private $title;
    private $text;
    private $userEmail;

    public function __construct($uuid, $title, $text, $userEmail)
    {
        if (empty($uuid) || empty($title) || empty($text) || empty($userEmail)) {
            throw new \InvalidArgumentException("empty arguments");
        }

        if (!is_string($uuid) || !is_string($title) || !is_string($text) || !is_string($userEmail)) {
            throw new \InvalidArgumentException("arguments are not strings");
        }

        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("email is not valid");
        }

        $this->uuid = $uuid;
        $this->title = $title;
        $this->text = $text;
        $this->userEmail = $userEmail;
    }

    public function uuid()
    {
        return $this->uuid;
    }

    public function title($title = null)
    {
        if ($title == null) {
            return $this->title;
        }

        $this->title = $title;
        return true;
    }

    public function text($text = null)
    {
        if ($text == null)
        {
            return $this->text;
        }

        $this->text = $text;
        return true;
    }

    public function userEmail()
    {
        return $this->userEmail;
    }
}