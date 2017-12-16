<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 5:01 PM
 */

namespace App\Actions;


use App\Domain\User;
use App\Storage\Answer\AnswerRepository;
use App\Storage\Session\SessionRepository;
use App\Storage\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class AnswerAction
{
    protected $view;
    protected $log;
    protected $users;
    protected $questions;
    protected $answers;
    protected $session;

    public function __construct(Twig $view, LoggerInterface $logger, UserRepository $users,
                                QuestionRepository $questions, AnswerRepository $answers, SessionRepository $session)
    {
        $this->view = $view;
        $this->log = $logger;
        $this->users = $users;
        $this->questions = $questions;
        $this->answers = $answers;
        $this->session = $session;
    }

    public function post(Request $request, Response $response, $args)
    {
        $question_id = $args['question_id'];
        $parameters = $request->getParsedBody();

        $text = $parameters['text'];
        $email = $this->session->get('auth_user');


    }

    public function upvote(Request $request, Response $response)
    {

    }

    public function update(Request $request, Response $response)
    {

    }
}