<?php

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    private $question;
    private $uuid = "asdf1234";
    private $title = "Test Title";
    private $text = "This is my question...";
    private $userEmail = "anne@example.com";

    public function setUp()
    {
        $this->question = new \App\Domain\Question($this->uuid, $this->title, $this->text, $this->userEmail);
    }
    public function testQuestionEmptyArguments()
    {
        $this->expectException(InvalidArgumentException::class);
        $question = new \App\Domain\Question("", "", "", "");
    }

    public function testQuestionArgumentsNotString()
    {
        $this->expectException(InvalidArgumentException::class);
        $question = new \App\Domain\Question(1, 1, 1, 1);
    }

    public function testInvalidEmail()
    {
        $this->expectException(InvalidArgumentException::class);
        $question = new \App\Domain\Question("1234", "1234", "1234", "1234");
    }

    public function testuuid()
    {
        $this->assertEquals($this->uuid, $this->question->uuid());
    }

    public function testGetTitle()
    {
        $this->assertEquals($this->title, $this->question->title());
    }

    public function testUpdateTitle()
    {
        $this->assertTrue($this->question->title('new title'));
        $this->assertEquals('new title', $this->question->title());
    }

    public function testText()
    {
        $this->assertEquals($this->text, $this->question->text());
    }

    public function testUpdateText()
    {
        $this->assertTrue($this->question->text('new question text'));
        $this->assertEquals('new question text', $this->question->text());
    }

    public function testUserEmail()
    {
        $this->assertEquals($this->userEmail, $this->question->userEmail());
    }
}