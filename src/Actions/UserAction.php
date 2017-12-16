<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 5:01 PM
 */

namespace App\Actions;


use App\Domain\User;
use App\Storage\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class UserAction
{
    protected $view;
    protected $log;
    protected $users;

    public function __construct(Twig $view, LoggerInterface $logger, UserRepository $users)
    {
        $this->view = $view;
        $this->log = $logger;
        $this->users = $users;
    }

    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'register.html.twig', ['dump' => $this->users->getAll()]);
    }

    public function register(Request $request, Response $response)
    {
        $this->log->info("User action register action dispatched");

        $args = $request->getParsedBody();

        $email = $args['email'];
        $name = $args['name'];
        $password = $args['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException($args['f_username'] . ' is invalid');
        }

        $user = $this->users->getByEmail($email);

        // No user in the database with this username
        if (!$user == null) {
            //return $response->getBody()->write("You've already registered!");
            return $this->view->render($response->withStatus(403), 'thankyou.html.twig', ['already_registered' => true]);
        }

        $user = new User($email, $name, password_hash($password, PASSWORD_DEFAULT));

        if ($this->users->store($user))
        {
            //return $response->getBody()->write("Thank you for registering!");
            //return $this->view->render($response, 'thankyou.html.twig', ['already_registered' => false]);
            return $response->withRedirect('/');
        }

        return $response->getBody()->write("Something went wrong!");
    }
}