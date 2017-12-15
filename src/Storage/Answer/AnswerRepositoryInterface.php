<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:24 AM
 */

namespace App\Storage\Answer;


use App\Domain\Answer;

interface AnswerRepositoryInterface
{
    public function getByID($uuid);
    public function getByQuestionID($uuid);
    public function store(Answer $answer);
    public function delete($uuid);
    public function deleteAll();
}