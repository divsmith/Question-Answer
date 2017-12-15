<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 1:22 PM
 */

namespace App\Storage\Question;

use App\Domain\Question;
use Illuminate\Database\Query\Builder;

class EloquentQuestionPlugin implements QuestionRepositoryInterface
{
    private $table;

    public function __construct(Builder $table)
    {
        $this->table = $table;
    }

    public function store(Question $question)
    {
        $eloquentQuestion = \App\Models\Question::whereUuid($question->uuid())->first();

        if (!$eloquentQuestion)
        {
            $eloquentQuestion = new \App\Models\Question(['uuid' => $question->uuid(),
                                                            'title' => $question->title(),
                                                            'text' => $question->text(),
                                                            'user_email' => $question->userEmail()]);
        }
        else
        {
            $eloquentQuestion->title = $question->title();
            $eloquentQuestion->text = $question->text();
        }

        return $eloquentQuestion->save();
    }

    public function deleteAll()
    {
        \App\Models\Question::truncate();
    }

    public function getByID($uuid)
    {
        $return = null;

        $question = \App\Models\Question::whereUuid($uuid)->first();

        if ($question)
        {
            $question = $question->toArray();
            $return = new Question($question['uuid'], $question['title'], $question['text'], $question['user_email']);
        }

        return $return;
    }

    public function getAllByUser($email)
    {
        $eloquentQuestions = \App\Models\Question::whereUserEmail($email)->get();

        $return = null;

        if (sizeof($eloquentQuestions) > 0)
        {
            $return = [];
            $eloquentQuestions = $eloquentQuestions->toArray();
            foreach($eloquentQuestions as $question)
            {
                $return[] = new Question($question['uuid'], $question['title'], $question['text'], $question['user_email']);
            }
        }

        return $return;
    }

    public function getAll()
    {
        $eloquentQuestions = \App\Models\Question::all()->toArray();

        $return = null;

        if (sizeof($eloquentQuestions) > 0)
        {
            $return = [];
            foreach($eloquentQuestions as $question)
            {
                $return[] = new Question($question['uuid'], $question['title'], $question['text'], $question['user_email']);
            }
        }

        return $return;
    }

    public function delete($uuid)
    {
        $question = \App\Models\Question::whereUuid($uuid)->first();

        if ($question)
        {
            $question->delete();
            return true;
        }

        return null;
    }
}