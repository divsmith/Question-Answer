<?php

/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 3:36 PM
 */
class MemoryUserPluginTest extends \PHPUnit_Framework_TestCase
{
    private $user1;
    private $user2;
    private $user3;
    private $plugin;

    public function setUp()
    {
        $this->user1 = new \App\Domain\User("anne@example.com", "Anne Example", password_hash('user1 password', PASSWORD_DEFAULT), ['1', '4', '7']);
        $this->user2 = new \App\Domain\User("bill@example.com", "Bill Example", password_hash('user2 password', PASSWORD_DEFAULT), ['3', '7', '9']);
        $this->user3 = new \App\Domain\User("jack@example.com", "Jack Example", password_hash('user3 password', PASSWORD_DEFAULT));

        $this->plugin = new \App\Storage\User\MemoryUserPlugin();

        $this->plugin->store($this->user1);
        $this->plugin->store($this->user2);
        $this->plugin->store($this->user3);
    }

    public function tearDown()
    {
        $this->plugin->deleteAll();
    }

    public function testStore()
    {
        $this->assertTrue($this->plugin->store(new \App\Domain\User('test@test.com', 'Testing User', password_hash('test', PASSWORD_DEFAULT))));
    }

    public function testGetAll()
    {
        $this->assertEquals([$this->user1, $this->user2, $this->user3], $this->plugin->getAll());
    }

    public function testGetAllNone()
    {
        $this->plugin->deleteAll();
        $this->assertNull($this->plugin->getAll());
    }

    public function testGetByEmail()
    {
        $this->assertEquals($this->user1, $this->plugin->getByEmail($this->user1->email()));
    }

    public function testGetByEmailDoesNotExist()
    {
        $this->assertNull($this->plugin->getByEmail('doesnotexist@test.com'));
    }

    public function testDelete()
    {
        $this->assertTrue($this->plugin->delete($this->user1->email()));
        $this->assertNull($this->plugin->getByEmail($this->user1->email()));
        $this->assertEquals([$this->user2, $this->user3], $this->plugin->getAll());
    }

    public function testUpdate()
    {
        $this->user3->upvote('test1234');
        $this->assertTrue($this->plugin->store($this->user3));

        $user = $this->plugin->getByEmail($this->user3->email());
        $this->assertTrue($user->upvoted('test1234'));
    }

    public function testDeleteDoesNotExist()
    {
        $this->assertNull($this->plugin->delete('doesnotexist@test.com'));
    }
}