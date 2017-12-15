<?php

namespace Tests\Functional;

use App\Domain\Answer;
use App\Domain\Question;
use App\Storage\Question\MemoryQuestionPlugin;
use App\Storage\User\MemoryUserPlugin;

class ProfilepageTest extends BaseMockEnvironmentTestCase
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

            return new MemoryUserPlugin([$user1, $user2, $user3]);
        };

        $container[\App\Storage\Question\QuestionRepositoryInterface::class] = function($c)
        {
            $question1 = new Question('1', 'Question about Eloquent', 'I have a quesiton about how to use eloquent', 'anne@example.com');
            $question2 = new Question('2', 'another Question about Eloquent', 'I have a another quesiton about how to use eloquent', 'anne@example.com');
            $question3 = new Question('3', 'Question about Phinx', 'I have a quesiton about how to use Phinx', 'ben@example.com');

            return new MemoryQuestionPlugin([$question1, $question2, $question3]);
        };

        $container[\App\Storage\Answer\AnswerRepositoryInterface::class] = function($c)
        {
            $answer1 = new Answer(1, 1, 'You use eloquent like this...', 'christ@example.com', 1);
            $answer2 = new Answer(2, 1, 'You can also use eloquent like this...', 'ben@example.com');
            $answer3 = new Answer(3, 3, 'You use phinx like this...', 'anne@example.com');
        };

        $container[\App\Storage\Session\SessionRepositoryPluginInterface::class] = function($c)
        {
            return new \App\Storage\Session\PHPSessionPlugin();
        };
    }

    public function testGetProfilepageNotAllowed()
    {
        $response = $this->runApp('GET', '/profile');

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }

    public function testPostLoginpageSuccess00()
    {
        $response = $this->runApp('POST', '/profile', ['f_username' => 'anne@example.com', 'f_password' => '1234pass']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Member', (string)$response->getBody());
        $this->assertContains('Hello, Anne Anderson!', (string)$response->getBody());
    }

    public function testPostLoginpageSuccess01()
    {
        $response = $this->runApp('POST', '/profile', ['f_username' => 'ben@example.com', 'f_password' => '1234pass']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Member', (string)$response->getBody());
        $this->assertContains('Hello, Ben Bennett!', (string)$response->getBody());
    }

    public function testPostLoginpageSuccess02()
    {
        $response = $this->runApp('POST', '/profile', ['f_username' => 'chris@example.com', 'f_password' => '1234pass']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Member', (string)$response->getBody());
        $this->assertContains('Hello, Chris Christensen!', (string)$response->getBody());
    }

    public function testPostLoginpageFail00()
    {
        $response = $this->runApp('POST', '/profile', ['f_username' => 'bob@example.com', 'f_password' => '1234pass']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Unauthorized, Chuck Norris has been dispatch to find you!', (string)$response->getBody());
    }

    public function testPostLoginpageFail01()
    {
        $response = $this->runApp('POST', '/profile', ['f_username' => 'ben@example.com', 'f_password' => '1234pas']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Unauthorized, Chuck Norris has been dispatch to find you!', (string)$response->getBody());
    }
}
