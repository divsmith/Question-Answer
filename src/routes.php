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
$app->post('/user', App\Actions\UserAction::class . ':register');
