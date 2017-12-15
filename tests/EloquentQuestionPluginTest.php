<?php

use Slim\App;

class EloquentQuestionPluginTest extends \PHPUnit_Framework_TestCase
{
    private $question1;
    private $question2;
    private $question3;
    private $plugin;

    public function setUp()
    {
        // Use the application settings
        $settings = require __DIR__ . '/../src/settings.php';

        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../src/dependencies.php';

        $this->question1 = new \App\Domain\Question('asdf1234', 'This is first question', 'first question text', 'test@test.com');
        $this->question2 = new \App\Domain\Question('fdsa3242', 'This is my second question', 'second question text', 'test@test.com');
        $this->question3 = new \App\Domain\Question('87898', 'Separate user question', 'Separate question text', 'separate@test.com');

        $this->plugin = $app->getContainer()->get(\App\Storage\Question\EloquentQuestionPlugin::class);

        $this->plugin->store($this->question1);
        $this->plugin->store($this->question2);
        $this->plugin->store($this->question3);
    }

    public function tearDown()
    {
        $this->plugin->deleteAll();
    }

    public function testStore()
    {
        $this->assertTrue($this->plugin->store(new \App\Domain\Question('234233', 'Test Question Title', 'Test question text', 'test@testing.com')));
    }

    public function testGetAll()
    {
        $this->assertEquals([$this->question1, $this->question2, $this->question3], $this->plugin->getAll());
    }

    public function testGetAllByEmail()
    {
        $question4 = new \App\Domain\Question('greattest', 'Another test question', 'more text to test', 'test@test.com');
        $this->plugin->store($question4);
        $this->assertEquals([$this->question1, $this->question2, $question4], $this->plugin->getAllByUser('test@test.com'));
    }

    public function testGetAllNone()
    {
        $this->plugin->deleteAll();
        $this->assertNull($this->plugin->getAll());
    }

    public function testGetByUUID()
    {
        $this->assertEquals($this->question1, $this->plugin->getByID($this->question1->uuid()));
    }

    public function testGetByUUIDDoesNotExist()
    {
        $this->assertNull($this->plugin->getByID('does not exist id'));
    }

    public function testDelete()
    {
        $this->assertTrue($this->plugin->delete($this->question1->uuid()));
        $this->assertNull($this->plugin->getByID($this->question1->uuid()));
        $this->assertEquals([$this->question2, $this->question3], $this->plugin->getAll());
    }

    public function testDeleteDoesNotExist()
    {
        $this->assertNull($this->plugin->delete('doesnotexist@test.com'));
    }

    public function testUpdate()
    {
        $this->question1->title('new title');
        $this->question1->text('new text for this question');

        $this->assertTrue($this->plugin->store($this->question1));
        $this->assertEquals($this->question1, $this->plugin->getByID($this->question1->uuid()));
    }
}