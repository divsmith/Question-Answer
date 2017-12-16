<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 5:01 PM
 */

namespace App\Actions;


use App\Domain\Question;
use App\Domain\User;
use App\Storage\Answer\AnswerRepository;
use App\Storage\Question\QuestionRepository;
use App\Storage\Session\SessionRepository;
use App\Storage\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

class QuestionAction
{
    protected $view;
    protected $log;
    protected $users;
    protected $questions;
    protected $answers;
    protected $session;
    protected $router;

    /**
     * QuestionAction constructor.
     * @param Twig $view
     * @param LoggerInterface $logger
     * @param UserRepository $users
     * @param QuestionRepository $questions
     * @param AnswerRepository $answers
     * @param SessionRepository $session
     * @param Router $router
     */
    public function __construct(Twig $view, LoggerInterface $logger, UserRepository $users,
                                QuestionRepository $questions, AnswerRepository $answers,
                                SessionRepository $session, Router $router)
    {
        $this->view = $view;
        $this->log = $logger;
        $this->users = $users;
        $this->questions = $questions;
        $this->answers = $answers;
        $this->session = $session;
        $this->router = $router;
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
        $email = $this->session->get('auth_user');

        $this->questions->store(new Question(uniqid(), $title, $text, $email));
        $uri = $request->getUri()->withPath($this->router->pathFor('question.home'));
        return $response->withRedirect($uri, 201);
    }

    public function find(Request $request, Response $response, $args)
    {
        $uuid = $args['question_id'];

        $question = $this->questions->getByID($uuid);
        $answers = $this->answers->getByQuestionID($uuid);

        if ($question == null)
        {
            return $response->withStatus(400, 'Invalid question ID');
        }
        return $this->view->render($response, 'question.detail.twig.html', ['question' => $question, 'answers' => $answers]);
    }

    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'question.form.html.twig');
    }

    public function delete(Request $request, Response $response)
    {

    }
}