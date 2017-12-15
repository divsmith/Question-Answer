<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:37 AM
 */

namespace App\Storage\Answer;


use App\Domain\Answer;

class AnswerRepository
{
    private $plugin;

    public function __construct(AnswerRepositoryInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getByID($uuid)
    {
        return $this->plugin->getByID($uuid);
    }

    public function getByQuestionID($uuid)
    {
        return $this->plugin->getByQuestionID($uuid);
    }

    public function store(Answer $answer)
    {
        return $this->plugin->store($answer);
    }
}