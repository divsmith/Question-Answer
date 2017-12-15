<?php

class AnswerTest extends \PHPUnit_Framework_TestCase
{
    private $uuid = "asdf1234";
    private $text = "This is my answer to your question...";
    private $userEmail = "anne@example.com";
    private $answer;

    public function setUp()
    {
        $this->answer = new \App\Domain\Answer($this->uuid, $this->text, $this->userEmail);
    }

    public function testQuestionEmptyArguments()
    {
        $this->expectException(InvalidArgumentException::class);
        $answer = new \App\Domain\Answer("", "", "");
    }

    public function testQuestionArgumentsNotString()
    {
        $this->expectException(InvalidArgumentException::class);
        $answer = new \App\Domain\Answer(1, 1, 1);
    }

    public function testInvalidEmail()
    {
        $this->expectException(InvalidArgumentException::class);
        $answer = new \App\Domain\Answer($this->uuid, $this->text, "invalid");
    }

    public function testUuid()
    {
        $this->assertEquals($this->uuid, $this->answer->uuid());
    }

    public function testText()
    {
        $this->assertEquals($this->text, $this->answer->text());
    }

    public function testUserEmail()
    {
        $this->assertEquals($this->userEmail, $this->answer->userEmail());
    }
}