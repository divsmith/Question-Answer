<?php

namespace Tests\Functional;

use App\Domain\Answer;
use App\Domain\Question;
use App\Domain\User;
use App\Storage\Answer\MemoryAnswerPlugin;
use App\Storage\Question\MemoryQuestionPlugin;
use App\Storage\User\MemoryUserPlugin;

class RegisterUserTest extends BaseMockEnvironmentTestCase
{
    public function __construct()
    {
        $this->setupApp();
        $container = $this->app->getContainer();

        // Plugin Interfaces
        $container[\App\Storage\User\UserRepositoryPluginInterface::class] = function($c)
        {
            $user1 = new User('anne@example.com', 'Anne Anderson', password_hash('1234pass', PASSWORD_DEFAULT), [1]);
            $user2 = new User('ben@example.com', 'Ben Bennett', password_hash('1234pass', PASSWORD_DEFAULT));
            $user3 = new User('chris@example.com', 'Chris Christensen', password_hash('1234pass', PASSWORD_DEFAULT));

            $plugin = new MemoryUserPlugin();
            $plugin->store($user1);
            $plugin->store($user2);
            $plugin->store($user3);

            return $plugin;
        };

        $container[\App\Storage\Question\QuestionRepositoryInterface::class] = function($c)
        {
            $question1 = new Question('1', 'Question about Eloquent', 'I have a quesiton about how to use eloquent', 'anne@example.com');
            $question2 = new Question('2', 'another Question about Eloquent', 'I have a another quesiton about how to use eloquent', 'anne@example.com');
            $question3 = new Question('3', 'Question about Phinx', 'I have a quesiton about how to use Phinx', 'ben@example.com');

            $plugin = new MemoryQuestionPlugin();
            $plugin->store($question1);
            $plugin->store($question2);
            $plugin->store($question3);

            return $plugin;
        };

        $container[\App\Storage\Answer\AnswerRepositoryInterface::class] = function($c)
        {
            $answer1 = new Answer(1, 1, 'You use eloquent like this...', 'christ@example.com', 1);
            $answer2 = new Answer(2, 1, 'You can also use eloquent like this...', 'ben@example.com');
            $answer3 = new Answer(3, 3, 'You use phinx like this...', 'anne@example.com');

            $plugin = new MemoryAnswerPlugin();
            $plugin->store($answer1);
            $plugin->store($answer2);
            $plugin->store($answer3);

            return $plugin;
        };

        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\PHPSessionPlugin();
        };
    }

    public function testPostRegister()
    {
        $response = $this->runApp('POST', '/user', ['email' => 'newguy@example.com', 'name' => 'New Guy', 'password' => 'testing password']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Thank you for registering!', (string)$response->getBody());

        $response = $this->runApp('POST', '/profile', ['f_username' => 'newguy@example.com', 'f_password' => 'testing password']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Member', (string)$response->getBody());
        $this->assertContains('Hello, New Guy!', (string)$response->getBody());
    }
}
