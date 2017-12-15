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
    private $questionID;
    private $text;
    private $userEmail;
    private $upvotes;

    public function __construct($uuid, $questionID, $text, $userEmail, $upvotes = 0)
    {
        if (empty($uuid) || empty($text) || empty($userEmail) || empty($questionID)) {
            throw new \InvalidArgumentException("empty arguments");
        }

        if (!is_string($uuid) || !is_string($text) || !is_string($userEmail) || !is_string($questionID)) {
            throw new \InvalidArgumentException("arguments are not strings");
        }

        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("email is not valid");
        }

        $this->uuid = $uuid;
        $this->questionID = $questionID;
        $this->text = $text;
        $this->userEmail = $userEmail;
        $this->upvotes = $upvotes;
    }

    public function upvote()
    {
        $this->upvotes++;
        return true;
    }

    public function upvotes()
    {
        return $this->upvotes;
    }

    public function questionID()
    {
        return $this->questionID;
    }

    public function uuid()
    {
        return $this->uuid;
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