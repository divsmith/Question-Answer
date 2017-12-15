<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:21 AM
 */

namespace App\Storage\Question;


use App\Domain\Question;

interface QuestionRepositoryInterface
{
    public function getByID($uuid);
    public function getAllByUser($email);
    public function getAll();
    public function store(Question $question);
    public function delete($uuid);
    public function deleteAll();
}