<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 5:01 PM
 */

namespace App\Actions;


use App\Domain\User;
use App\Storage\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class QuestionAction
{
    protected $view;
    protected $log;
    protected $users;
    protected $questions;

    public function __construct(Twig $view, LoggerInterface $logger, UserRepository $users, QuestionRepository $questions)
    {
        $this->view = $view;
        $this->log = $logger;
        $this->users = $users;
        $this->questions = $questions;
    }

    public function home(Request $request, Response $response)
    {
        $questions = $this->questions->getAll();
    }

    public function post(Request $request, Response $response)
    {

    }

    public function find(Request $request, Response $response)
    {

    }

    public function create(Request $request, Response $response)
    {

    }

    public function delete(Request $request, Response $response)
    {

    }
}