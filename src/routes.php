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
$app->post('/profile', App\Actions\ProfileAction::class)->setName('profilepage');


// User
$app->get('/user/create', App\Actions\UserAction::class . ':create');
$app->post('/user', App\Actions\UserAction::class . ':register');

// Question
$app->get('/question', \App\Actions\QuestionAction::class . ':home');
$app->post('/question', \App\Actions\QuestionAction::class . ':post')->add($auth);
$app->get('/question/create', \App\Actions\QuestionAction::class . ':create');
$app->get('/question/{question_id}', \App\Actions\QuestionAction::class . ':find');
$app->delete('/question/{question_id}', \App\Actions\QuestionAction::class . ':delete');

// Answer
$app->post('/question/{question_id}/answer', \App\Actions\AnswerAction::class . ':post');
$app->post('/question/{question_id}/answer/{answer_id}', \App\Actions\AnswerAction::class . ":update");
$app->post('/question/{question_id}/answer/{answer_id}/upvote', \App\Actions\AnswerAction::class . ':upvote');

