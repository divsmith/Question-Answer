<?php
/**
 * DIC configuration
 */

$container = $app->getContainer();

// view
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);
    // Add extensions
    $view->addExtension(new \Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};

// flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

// database
$container['db'] = function ($c) {
    $capsule = new \Illuminate\Database\Capsule\Manager;

    $capsule->addConnection($c->get('settings')['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

// error handlers
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $c->get('logger')->error($exception->getMessage());
        $response->getBody()->rewind();
        return $response->withStatus(500)
                        ->withHeader('Content-Type', 'text/html')
                        ->write("<hr>Oops, something's gone wrong!<hr>");
    };
};

$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $error) use ($c) {
        $c->get('logger')->error($exception->getMessage());
        $response->getBody()->rewind();
        return $response->withStatus(500)
                        ->withHeader('Content-Type', 'text/html')
                        ->write("Oops, something's gone wrong!");
    };
};

// classes/objects
$container[App\Actions\HomeAction::class] = function ($c) {
    return new \App\Actions\HomeAction($c->get('view'), $c->get('logger'));
};

$container[App\Actions\ProfileAction::class] = function ($c) {
    $view = $c->get('view');
    $logger = $c->get('logger');
    $table = $c->get('db')->table('users');

    return new \App\Actions\ProfileAction($view, $logger, $table);
};

// custom
$container[\App\Storage\User\EloquentUserPlugin::class] = function($c)
{
    return new \App\Storage\User\EloquentUserPlugin($c->get('db')->table('users'));
};

$container[\App\Storage\Question\EloquentQuestionPlugin::class] = function($c)
{
    return new \App\Storage\Question\EloquentQuestionPlugin($c->get('db')->table('questions'));
};

$container[\App\Storage\Answer\EloquentAnswerPlugin::class] = function($c)
{
    return new \App\Storage\Answer\EloquentAnswerPlugin($c->get('db')->table('answers'));
};