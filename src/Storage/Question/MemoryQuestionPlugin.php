<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 3:52 PM
 */

namespace App\Storage\Question;


use App\Domain\Question;

class MemoryQuestionPlugin implements QuestionRepositoryInterface
{
    private $questions = [];

    public function __construct($questions = [])
    {
        $this->questions = [];
    }

    public function getByID($uuid)
    {
        if (isset($this->questions[$uuid]))
        {
            return $this->questions[$uuid];
        }

        return null;
    }

    public function getAllByUser($email)
    {
        $return = [];

        foreach($this->questions as $question)
        {
            if ($question->userEmail() == $email)
            {
                $return[] = $question;
            }
        }

        if (sizeof($return) > 0)
        {
            return $return;
        }

        return null;
    }

    public function getAll()
    {
        if (sizeof($this->questions) > 0)
        {
            return array_values($this->questions);
        }

        return null;
    }

    public function store(Question $question)
    {
        $this->questions[$question->uuid()] = $question;
        return true;
    }

    public function delete($uuid)
    {
        if (isset($this->questions[$uuid]))
        {
            unset($this->questions[$uuid]);
            return true;
        }

        return null;
    }

    public function deleteAll()
    {
        $this->questions = [];
    }
}