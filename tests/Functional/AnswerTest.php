<?php

namespace Tests\Functional;

use App\Domain\Answer;
use App\Domain\Question;
use App\Domain\User;
use App\Storage\Answer\MemoryAnswerPlugin;
use App\Storage\Question\MemoryQuestionPlugin;
use App\Storage\User\MemoryUserPlugin;

class AnswerTest extends BaseMockEnvironmentTestCase
{
    public function setUp()
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
            $question1 = new Question('1', 'Question about Eloquent', 'I have a question about how to use eloquent', 'anne@example.com');
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
            $answer1 = new Answer('1', '1', 'You use eloquent like this...', 'chris@example.com', 1);
            $answer2 = new Answer('2', '1', 'You can also use eloquent like this...', 'ben@example.com');
            $answer3 = new Answer('3', '3', 'You use phinx like this...', 'anne@example.com');

            $plugin = new MemoryAnswerPlugin();
            $plugin->store($answer1);
            $plugin->store($answer2);
            $plugin->store($answer3);

            return $plugin;
        };

        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin();
        };
    }

    public function testPostAnswerLoggedIn()
    {
        $container = $this->app->getContainer();
        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin(['auth' => true, 'auth_user' => 'anne@example.com']);
        };

        $response = $this->runApp('POST', '/answer', ['text' => 'This is an answer to question 2.', 'question_id' => '2']);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->runApp('GET', '/question/2');
        $this->assertContains('This is an answer to question 2.', (string)$response->getBody());
        $this->assertContains('anne@example.com', (string)$response->getBody());
    }

    public function testPostAnswerInvalidQuestion()
    {
        $container = $this->app->getContainer();
        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin(['auth' => true, 'auth_user' => 'anne@example.com']);
        };

        $response = $this->runApp('POST', '/answer', ['text' => 'This is an answer to an invalid question', 'question_id' => '1234']);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testPostAnswerNotLoggedIn()
    {
        $response = $this->runApp('POST', '/answer', ['text' => 'This is an answer to question 2.', 'question_id' => '2']);
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testUpdateAnswer()
    {
        $container = $this->app->getContainer();
        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin(['auth' => true, 'auth_user' => 'anne@example.com']);
        };

        $response = $this->runApp('POST', '/answer/3', ['text' => 'This is a different answer to question 3.']);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->runApp('GET', '/question/3');
        $this->assertContains('This is a different answer to question 3.', (string)$response->getBody());
        $this->assertNotContains('You use phinx like this...', (string)$response->getBody());
    }

    public function testUpvoteNotLoggedIn()
    {
        $response = $this->runApp('POST', '/answer/1/upvote');
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testUpvoteAlreadyUpvoted()
    {
        $container = $this->app->getContainer();
        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin(['auth' => true, 'auth_user' => 'anne@example.com']);
        };

        $response = $this->runApp('POST', '/answer/1/upvote');
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertContains('Already upvoted', (string)$response->getBody());
    }

    public function testUpvote()
    {
        $container = $this->app->getContainer();
        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin(['auth' => true, 'auth_user' => 'chris@example.com']);
        };

        $response = $this->runApp('POST', '/answer/3/upvote');
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->runApp('GET', '/question/3');
        $this->assertContains('Upvotes: 1', (string)$response->getBody());
    }

    public function testUpvoteInvalidAnswer()
    {
        $container = $this->app->getContainer();
        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\MemorySessionPlugin(['auth' => true, 'auth_user' => 'chris@example.com']);
        };

        $response = $this->runApp('POST', '/answer/37/upvote');
        $this->assertEquals(404, $response->getStatusCode());
    }
}
