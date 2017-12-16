<?php
/**
 * HTTP Routes defined here
 */
use Slim\Http\Request;
use Slim\Http\Response;

// Get Routes
$app->get('/', App\Actions\HomeAction::class)->setName('homepage');

// Post Routes
$app->post('/profile', App\Actions\ProfileAction::class)->setName('profilepage');


// User
$app->post('/user', App\Actions\UserAction::class . ':register');

// Question
$app->get('/question', \App\Actions\QuestionAction::class . ':home');
$app->post('/question', \App\Actions\QuestionAction::class . ':post');
$app->get('/question/create', \App\Actions\QuestionAction::class . ':create');
$app->get('/question/{question_id}', \App\Actions\QuestionAction::class . ':find');
$app->delete('/question/{question_id}', \App\Actions\QuestionAction::class . ':delete');

// Answer
$app->post('/question/{question_id}/answer', \App\Actions\AnswerAction::class . ':post');
$app->post('/question/{question_id}/answer/{answer_id}', \App\Actions\AnswerAction::class . ":update");
$app->post('/question/{question_id}/answer/{answer_id}/upvote', \App\Actions\AnswerAction::class . ':upvote');

