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
//
//// error handlers
//$container['errorHandler'] = function ($c) {
//    return function ($request, $response, $exception) use ($c) {
//        $c->get('logger')->error($exception->getMessage());
//        $response->getBody()->rewind();
//        return $response->withStatus(500)
//                        ->withHeader('Content-Type', 'text/html')
//                        ->write("<hr>Oops, something's gone wrong!<hr>");
//    };
//};
//
//$container['phpErrorHandler'] = function ($c) {
//    return function ($request, $response, $exception) use ($c) {
//        $c->get('logger')->error($exception->getMessage());
//        $response->getBody()->rewind();
//        return $response->withStatus(500)
//                        ->withHeader('Content-Type', 'text/html')
//                        ->write("Oops, something's gone wrong!");
//    };
//};

// Actions
$container[App\Actions\HomeAction::class] = function ($c) {
    return new \App\Actions\HomeAction($c->get('view'), $c->get('logger'));
};

$container[App\Actions\ProfileAction::class] = function ($c) {
    $view = $c->get('view');
    $logger = $c->get('logger');
    $users = $c->get(\App\Storage\User\UserRepository::class);
    $session = $c->get(\App\Storage\Session\SessionRepository::class);

    return new \App\Actions\ProfileAction($view, $logger, $users, $session);
};

$container[\App\Actions\UserAction::class] = function($c)
{
    $view = $c->get('view');
    $logger = $c->get('logger');
    $users = $c->get(\App\Storage\User\UserRepository::class);

    return new \App\Actions\UserAction($view, $logger, $users);
};


// Specific Plugins (must be resolved through IOC container for testing
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


// Plugin Interfaces
$container[\App\Storage\User\UserRepositoryPluginInterface::class] = function($c)
{
    return new \App\Storage\User\EloquentUserPlugin($c->get('db')->table('users'));
};

$container[\App\Storage\Question\QuestionRepositoryInterface::class] = function($c)
{
    return new \App\Storage\Question\EloquentQuestionPlugin($c->get('db')->table('questions'));
};

$container[\App\Storage\Answer\AnswerRepositoryInterface::class] = function($c)
{
    return new \App\Storage\Answer\EloquentAnswerPlugin($c->get('db')->table('answers'));
};

$container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
{
    return new \App\Storage\Session\PHPSessionPlugin();
};


// Repositories
$container[\App\Storage\User\UserRepository::class] = function($c)
{
    return new \App\Storage\User\UserRepository($c->get(\App\Storage\User\UserRepositoryPluginInterface::class));
};

$container[\App\Storage\Question\QuestionRepository::class] = function($c)
{
    return new \App\Storage\Question\QuestionRepository($c->get(\App\Storage\Question\QuestionRepositoryInterface::class));
};

$container[\App\Storage\Answer\AnswerRepository::class] = function($c)
{
    return new \App\Storage\Answer\AnswerRepository($c->get(\App\Storage\Answer\AnswerRepositoryInterface::class));
};

$container[\App\Storage\Session\SessionRepository::class] = function($c)
{
    return new \App\Storage\Session\SessionRepository($c->get(\App\Storage\Session\SessionRepositoryPluginInterface::class));
};
