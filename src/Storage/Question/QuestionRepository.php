<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 10:34 AM
 */

namespace App\Storage\Question;


class QuestionRepository
{
    private $plugin;

    public function __construct(QuestionRepositoryInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getByID($uuid)
    {
        return $this->plugin->getByID($uuid);
    }

    public function getAllByUser($email)
    {
        return $this->plugin->getAllByUser($email);
    }

    public function getAll()
    {
        return $this->plugin->getAll();
    }

    public function store(Question $question)
    {
        return $this->plugin->store($question);
    }

    public function delete($uuid)
    {
        return $this->plugin->delete($uuid);
    }

    public function deleteAll()
    {
        return $this->plugin->deleteAll();
    }
}