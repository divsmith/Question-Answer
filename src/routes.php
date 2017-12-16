<?php
/**
 * HTTP Routes defined here
 */
use Slim\Http\Request;
use Slim\Http\Response;

$auth = function($request, $response, $next) use ($app)
{
    $session = $app->getContainer()->get(\App\Storage\Session\SessionRepository::class);
    if ($session->has('auth') && $session->get('auth') == true)
    {
        $response = $next($request, $response);
        return $response;
    }

    return $response->withStatus(401, 'Authentication required');
};

// Get Routes
$app->get('/', App\Actions\HomeAction::class)->setName('homepage');

// Post Routes
$app->post('/profile', App\Actions\SessionAction::class . ':create');


// User
$app->get('/user/create', App\Actions\UserAction::class . ':create');
$app->post('/user', App\Actions\UserAction::class . ':register');

// Question
$app->get('/question', \App\Actions\QuestionAction::class . ':home')->setName('question.home');
$app->post('/question', \App\Actions\QuestionAction::class . ':post')->add($auth);
$app->get('/question/create', \App\Actions\QuestionAction::class . ':create')->add($auth);
$app->get('/question/{question_id}', \App\Actions\QuestionAction::class . ':find');
$app->delete('/question/{question_id}', \App\Actions\QuestionAction::class . ':delete')->add($auth);

// Answer
$app->post('/answer', \App\Actions\AnswerAction::class . ':post')->add($auth);
$app->post('/answer/{answer_id}', \App\Actions\AnswerAction::class . ':update')->add($auth);
$app->post('/answer/{answer_id}/upvote', \App\Actions\AnswerAction::class . ':upvote')->add($auth);

