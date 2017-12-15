<?php

class AnswerTest extends \PHPUnit_Framework_TestCase
{
    private $uuid = "asdf1234";
    private $questionID = '1234asdf';
    private $text = "This is my answer to your question...";
    private $userEmail = "anne@example.com";
    private $answer;

    public function setUp()
    {
        $this->answer = new \App\Domain\Answer($this->uuid, $this->questionID, $this->text, $this->userEmail);
    }

    public function testQuestionEmptyArguments()
    {
        $this->expectException(InvalidArgumentException::class);
        $answer = new \App\Domain\Answer("", "", "", "");
    }

    public function testQuestionArgumentsNotString()
    {
        $this->expectException(InvalidArgumentException::class);
        $answer = new \App\Domain\Answer(1, 1, 1, 1);
    }

    public function testInvalidEmail()
    {
        $this->expectException(InvalidArgumentException::class);
        $answer = new \App\Domain\Answer($this->uuid, $this->questionID, $this->text, "invalid");
    }

    public function testUuid()
    {
        $this->assertEquals($this->uuid, $this->answer->uuid());
    }

    public function testText()
    {
        $this->assertEquals($this->text, $this->answer->text());
    }

    public function testUpdateText()
    {
        $this->assertTrue($this->answer->text('new text now'));
        $this->assertEquals('new text now', $this->answer->text());
    }

    public function testUserEmail()
    {
        $this->assertEquals($this->userEmail, $this->answer->userEmail());
    }

    public function testgetQuestionID()
    {
        $this->assertEquals($this->questionID, $this->answer->questionID());
    }

    public function testUpvote()
    {
        $this->assertTrue($this->answer->upvote());
        $this->assertTrue($this->answer->upvote());

        $this->assertEquals(2, $this->answer->upvotes());
    }
}