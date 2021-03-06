<?php

namespace App\Actions;

use App\Storage\Session\SessionRepository;
use App\Storage\User\UserRepository;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class SessionAction
{
    protected $view;
    protected $log;
    protected $users;
    protected $session;

    public function __construct(Twig $view, LoggerInterface $logger, UserRepository $users, SessionRepository $session)
    {
        $this->view = $view;
        $this->log = $logger;
        $this->users = $users;
        $this->session = $session;
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $this->session->put('auth', false);
        $this->session->put('auth_user', null);
        session_destroy();
        session_start();
        return $response->withRedirect('/');
    }

    public function create(Request $request, Response $response, array $args)
    {
        $this->log->info("Profilepage action dispatched");

        $args = $request->getParsedBody();

        $email = $args['f_username'];
        $password = $args['f_password'];

        if (!filter_var($args['f_username'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException($args['f_username'] . ' is invalid');
        }

        $user = $this->users->getByEmail($email);

        // No user in the database with this username
        if ($user === null) {
            return $this->view->render($response, 'profile.html.twig', ['loggedIn' => false]);
        }

        // Password check
        if (!$user->password_verify($password)) {
            return $this->view->render($response, 'profile.html.twig', ['loggedIn' => false]);
        }
        
        $this->session->put('auth', true);
        $this->session->put('auth_user', $user->email());
        return $this->view->render($response, 'profile.html.twig', ['name' => $user->name(), 'loggedIn' => true]);
    }
}
