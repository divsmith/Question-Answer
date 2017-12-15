<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 2:07 PM
 */

namespace App\Storage\Answer;


use App\Domain\Answer;
use Illuminate\Database\Query\Builder;

class EloquentAnswerPlugin implements AnswerRepositoryInterface
{
    private $table;

    public function __construct(Builder $table)
    {
        $this->table = $table;
    }

    public function getByID($uuid)
    {
        $answer = \App\Models\Answer::whereUuid($uuid)->first();

        if ($answer)
        {
            $answer = $answer->toArray();
            return new Answer($answer['uuid'], $answer['question_uuid'], $answer['text'], $answer['user_email']);
        }

        return null;
    }

    public function getByQuestionID($uuid)
    {
        $eloquentAnswers = \App\Models\Answer::whereQuestionUuid($uuid)->get();

        $return = null;

        if (sizeof($eloquentAnswers) > 0)
        {
            $return = [];
            $eloquentAnswers = $eloquentAnswers->toArray();
            foreach($eloquentAnswers as $answer)
            {
                $return[] = new Answer($answer['uuid'], $answer['question_uuid'], $answer['text'], $answer['user_email']);
            }
        }

        return $return;
    }

    public function store(Answer $answer)
    {
        $eloquentAnswer = \App\Models\Answer::whereUuid($answer->uuid())->first();

        if (!$eloquentAnswer)
        {
            $eloquentAnswer = new \App\Models\Answer(['uuid' => $answer->uuid(),
                'question_uuid' => $answer->questionID(),
                'text' => $answer->text(),
                'user_email' => $answer->userEmail()]);
        }
        else
        {
            $eloquentAnswer->text = $answer->text();
        }

        return $eloquentAnswer->save();
    }

    public function delete($uuid)
    {
        $answer = \App\Models\Answer::whereUuid($uuid)->first();

        if ($answer)
        {
            $answer->delete();
            return true;
        }

        return null;
    }

    public function deleteAll()
    {
        \App\Models\Answer::truncate();
    }
}