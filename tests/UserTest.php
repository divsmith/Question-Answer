<?php

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testUsersEmptyArgumentsException()
    {
        // arrange
        $actual = null;
        $expected = "empty arguments";
        // act
        try {
            new \App\Domain\User("","");
        } catch(\Exception $e) {
            $actual = $e->getMessage();
            $this->assertEquals(\InvalidArgumentException::class, get_class($e));
        }
        // assert
        $this->assertEquals($expected, $actual);
    }

    public function testUsersNotStringsException()
    {
        // arrange
        $actual = null;
        $expected = "arguments are not strings";
        // act
        try {
            new \App\Domain\User(1,1);
        } catch(\Exception $e) {
            $actual = $e->getMessage();
            $this->assertEquals(\InvalidArgumentException::class, get_class($e));
        }
        // assert
        $this->assertEquals($expected, $actual);
    }

    public function testEmailNotValidException()
    {
        // arrange
        $actual = null;
        $expected = "email is not valid";
        // act
        try {
            new \App\Domain\User("anne@example","Anne Able");
        } catch(\Exception $e) {
            $actual = $e->getMessage();
            $this->assertEquals(\InvalidArgumentException::class, get_class($e));
        }
        // assert
        $this->assertEquals($expected, $actual);
    }

    public function testGetEmail()
    {
        // arrange
        $email = 'anne@example.com';
        $name = 'Anne Able';

        $user = new \App\Domain\User($email, $name);

        $this->assertEquals($email, $user->email());
    }
}
