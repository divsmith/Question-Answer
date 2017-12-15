<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 4:05 PM
 */

namespace App\Storage\Answer;


use App\Domain\Answer;

class MemoryAnswerPlugin implements AnswerRepositoryInterface
{
    private $answers = [];

    public function getByID($uuid)
    {
        if (isset($this->answers[$uuid]))
        {
            return $this->answers[$uuid];
        }

        return null;
    }

    public function getByQuestionID($uuid)
    {
        $return = [];

        foreach($this->answers as $answer)
        {
            if ($answer->questionID() == $uuid)
            {
                $return[] = $answer;
            }
        }

        if (sizeof($return) > 0)
        {
            return $return;
        }

        return null;
    }

    public function store(Answer $answer)
    {
        $this->answers[$answer->uuid()] = $answer;
        return true;
    }

    public function delete($uuid)
    {
        if (isset($this->answers[$uuid]))
        {
            unset($this->answers[$uuid]);
            return true;
        }

        return null;
    }

    public function deleteAll()
    {
        $this->answers = [];
    }
}