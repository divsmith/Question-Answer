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
use App\Storage\Question\QuestionRepository;
use App\Storage\Session\SessionRepository;
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
    protected $answers;
    protected $session;

    /**
     * QuestionAction constructor.
     * @param Twig $view
     * @param LoggerInterface $logger
     * @param UserRepository $users
     * @param QuestionRepository $questions
     * @param AnswerRepository $answers
     * @param SessionRepository $session
     */
    public function __construct(Twig $view, LoggerInterface $logger, UserRepository $users,
                                QuestionRepository $questions, AnswerRepository $answers,
                                SessionRepository $session)
    {
        $this->view = $view;
        $this->log = $logger;
        $this->users = $users;
        $this->questions = $questions;
        $this->answers = $answers;
        $this->session = $session;
    }

    public function home(Request $request, Response $response)
    {
        $questions = $this->questions->getAll();

        return $this->view->render($response, 'questions.home.html.twig', ['questions' => $questions]);
    }

    public function post(Request $request, Response $response)
    {
        $args = $request->getParsedBody();

        $title = $args['title'];
        $text = $args['text'];

        
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