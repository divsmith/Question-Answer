<?php

use Slim\App;

class EloquentAnswerPluginTest extends \PHPUnit_Framework_TestCase
{
    private $answer1;
    private $answer2;
    private $answer3;
    private $plugin;

    public function setUp()
    {
        // Use the application settings
        $settings = require __DIR__ . '/../src/settings.php';

        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../src/dependencies.php';

        $this->answer1 = new \App\Domain\Answer('1234', '4321', 'answer text', 'test@testing.com');
        $this->answer2 = new \App\Domain\Answer('asdf', 'fdsa', 'another answer text', 'test@testing.com');
        $this->answer3 = new \App\Domain\Answer('asdfasdf', '4321', 'more answer text', 'separate@testing.com');

        $this->plugin = $app->getContainer()->get(\App\Storage\Answer\EloquentAnswerPlugin::class);

        $this->plugin->store($this->answer1);
        $this->plugin->store($this->answer2);
        $this->plugin->store($this->answer3);
    }

    public function tearDown()
    {
        $this->plugin->deleteAll();
    }

    public function testStore()
    {
        $this->assertTrue($this->plugin->store(new \App\Domain\Answer('testuuid', 'testquestionid', 'new answer text', 'this@that.com')));
    }

    public function testGetByID()
    {
        $this->assertEquals($this->answer1, $this->plugin->getByID($this->answer1->uuid()));
    }

    public function testGetByIDDoesNotExist()
    {
        $this->assertNull($this->plugin->getByID('does not exist'));
    }

    public function testGetByQuestionID()
    {
        $this->assertEquals([$this->answer1, $this->answer3], $this->plugin->getByQuestionID('4321'));
    }

    public function testGetByQuestionIDDoesNotExist()
    {
        $this->assertNull($this->plugin->getByQuestionID('does not exist'));
    }

    public function testUpdate()
    {
        $this->answer1->text('new text now!!!');
        $this->assertTrue($this->plugin->store($this->answer1));

        $answer = $this->plugin->getByID($this->answer1->uuid());
        $this->assertEquals($this->answer1, $answer);

        $this->assertEquals('new text now!!!', $answer->text());
    }

    public function testDelete()
    {
        $this->assertTrue($this->plugin->delete($this->answer1->uuid()));
        $this->assertNull($this->plugin->getByID($this->answer1->uuid()));
    }

    public function testDeleteDoesNotExist()
    {
        $this->assertNull($this->plugin->delete('does not exist'));
    }
}