<?php

class MemorySessionRepositoryPluginTest extends \PHPUnit_Framework_TestCase
{
    public function testHas()
    {
        $plugin = new \App\Storage\Session\MemorySessionPlugin(['foo' => 'bar']);
        $this->assertTrue($plugin->has('foo'));
    }

    public function testHasNot()
    {
        $plugin = new \App\Storage\Session\MemorySessionPlugin(['foo' => 'bar']);
        $this->assertFalse($plugin->has('bar'));
    }

    public function testGet()
    {
        $plugin = new \App\Storage\Session\MemorySessionPlugin(['foo' => 'bar']);
        $this->assertEquals('bar', $plugin->get('foo'));
    }

    public function testGetDoesNotExist()
    {
        $plugin = new \App\Storage\Session\MemorySessionPlugin(['foo' => 'bar']);
        $this->assertNull($plugin->get('asdf'));
    }

    public function testPut()
    {
        $plugin = new \App\Storage\Session\MemorySessionPlugin(['foo' => 'bar']);
        $this->assertTrue($plugin->put('this', 'test'));

        $this->assertEquals('test', $plugin->get('this'));
    }
}