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
            new \App\Domain\User("","", "");
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
            new \App\Domain\User(1,1, 1);
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
        $password = password_hash('testing', PASSWORD_DEFAULT);

        // act
        try {
            new \App\Domain\User("anne@example","Anne Able", $password);
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
        $password = password_hash('testing', PASSWORD_DEFAULT);

        $user = new \App\Domain\User($email, $name, $password);

        $this->assertEquals($email, $user->email());
    }

    public function testGetName()
    {
        $email = 'anne@example.com';
        $name = 'Anne Able';
        $password = password_hash('testing', PASSWORD_DEFAULT);

        $user = new \App\Domain\User($email, $name, $password);

        $this->assertEquals($name, $user->name());
    }

    public function testVerifyPasswordInvalidPassword()
    {
        $email = 'anne@example.com';
        $name = 'Anne Able';
        $password = password_hash('testing', PASSWORD_DEFAULT);

        $user = new \App\Domain\User($email, $name, $password);

        $this->assertFalse($user->password_verify('Invalid Password'));
    }

    public function testVerifyPasswordValidPassword()
    {
        $email = 'anne@example.com';
        $name = 'Anne Able';
        $password = password_hash('testing', PASSWORD_DEFAULT);

        $user = new \App\Domain\User($email, $name, $password);

        $this->assertTrue($user->password_verify('testing'));
    }

    public function testUpvotedFalse()
    {
        $email = "anne@example.com";
        $name = "Anne Able";
        $password = password_hash('testing', PASSWORD_DEFAULT);
        $upvoted = ['asdf1234', '431324asdfasdf', '1234'];

        $user = new \App\Domain\User($email, $name, $password, $upvoted);

        $this->assertFalse($user->upvoted("12345"));
    }

    public function testUpvotedTrue()
    {
        $email = "anne@example.com";
        $name = "Anne Able";
        $password = password_hash('testing', PASSWORD_DEFAULT);
        $upvoted = ['asdf1234', '431324asdfasdf', '1234'];

        $user = new \App\Domain\User($email, $name, $password, $upvoted);

        $this->assertTrue($user->upvoted("asdf1234"));
    }

    public function testGetUpvoted()
    {
        $email = "anne@example.com";
        $name = "Anne Able";
        $password = password_hash('testing', PASSWORD_DEFAULT);
        $upvoted = ['asdf1234', '431324asdfasdf', '1234'];

        $user = new \App\Domain\User($email, $name, $password, $upvoted);

        $this->assertEquals($upvoted, $user->getUpvoted());
    }

    public function testGetHash()
    {
        $email = "anne@example.com";
        $name = "Anne Able";
        $password = password_hash('testing', PASSWORD_DEFAULT);
        $upvoted = ['asdf1234', '431324asdfasdf', '1234'];

        $user = new \App\Domain\User($email, $name, $password, $upvoted);

        $this->assertEquals($password, $user->hash());
    }
}
