<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 5:01 PM
 */

namespace App\Actions;


use App\Domain\Answer;
use App\Domain\User;
use App\Storage\Answer\AnswerRepository;
use App\Storage\Question\QuestionRepository;
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

    /**
     * AnswerAction constructor.
     * @param Twig $view
     * @param LoggerInterface $logger
     * @param UserRepository $users
     * @param QuestionRepository $questions
     * @param AnswerRepository $answers
     * @param SessionRepository $session
     */
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

    public function upvote(Request $request, Response $response, $args)
    {
        $answer_id = $args['answer_id'];
        $answer = $this->answers->getByID($answer_id);
        $user = $this->users->getByEmail($this->session->get('auth_user'));

        if ($answer == null)
        {
            $response->getBody()->write('Invalid Answer');
            return $response->withStatus(404);
        }

        if ($user->upvote($answer->uuid()))
        {
            $answer->upvote();
            $this->answers->store($answer);
            $this->users->store($user);

            $response->getBody()->write('Answer Upvoted');
            return $response->withRedirect('/question/' . $answer->questionID());
        }

        $response->getBody()->write('Already upvoted');
        return $response->withStatus(401);
    }

    public function post(Request $request, Response $response, $args)
    {
        $parameters = $request->getParsedBody();

        $question_id = $parameters['question_id'];
        $text = $parameters['text'];
        $email = $this->session->get('auth_user');
        $question = $this->questions->getByID($question_id);

        if ($question == null)
        {
            $response->getBody()->write('Invalid Question');
            return $response->withStatus(404);
        }

        $this->answers->store(new Answer(uniqid(), $question_id, $text, $email));

        $response->getBody()->write('Answer posted!');
        return $response->withRedirect('/question/' . $question_id);
    }

    public function update(Request $request, Response $response, $args)
    {
        $answer_id = $args['answer_id'];

        $parameters = $request->getParsedBody();

        $text = $parameters['text'];

        $answer = $this->answers->getById($answer_id);
        $authEmail = $this->session->get('auth_user');

        if ($answer == null)
        {
            $response->getBody()->write('Invalid answer ID');
            return $response->withStatus(400);
        }

        if ($answer->userEmail() == $authEmail)
        {
            $answer->text($text);
            $this->answers->store($answer);

            $response->getBody()->write('Updated Answer!');
            return $response->withStatus(202);
        }

        $response->getBody()->write('Unauthorized!');
        return $response->withStatus(401);
    }
}