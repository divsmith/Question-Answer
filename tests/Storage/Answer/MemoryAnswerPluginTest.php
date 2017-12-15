<?php

/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 4:04 PM
 */
class MemoryAnswerPluginTest extends \PHPUnit_Framework_TestCase
{
    private $answer1;
    private $answer2;
    private $answer3;
    private $plugin;

    public function setUp()
    {
        $this->answer1 = new \App\Domain\Answer('1234', '4321', 'answer text', 'test@testing.com', 17);
        $this->answer2 = new \App\Domain\Answer('asdf', 'fdsa', 'another answer text', 'test@testing.com', 2);
        $this->answer3 = new \App\Domain\Answer('asdfasdf', '4321', 'more answer text', 'separate@testing.com');

        $this->plugin = new \App\Storage\Answer\MemoryAnswerPlugin();

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
        $this->answer1->upvote();
        $this->assertTrue($this->plugin->store($this->answer1));

        $answer = $this->plugin->getByID($this->answer1->uuid());
        $this->assertEquals($this->answer1, $answer);

        $this->assertEquals('new text now!!!', $answer->text());
        $this->assertEquals(18, $answer->upvotes());
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