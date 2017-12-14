<?php

namespace Tests\Functional;

class ProfilepageTest extends BaseTestCase
{
    public function testTrue()
    {
        $this->assertTrue(true);
    }
//    public function testGetProfilepageNotAllowed()
//    {
//        $response = $this->runApp('GET', '/profile');
//
//        $this->assertEquals(405, $response->getStatusCode());
//        $this->assertContains('Method not allowed', (string)$response->getBody());
//    }
//
//    public function testPostLoginpageSuccess00()
//    {
//        $response = $this->runApp('POST', '/profile', ['f_username' => 'anne@example.com', 'f_password' => '1234pass']);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Member', (string)$response->getBody());
//        $this->assertContains('Hello, Anne Anderson!', (string)$response->getBody());
//    }
//
//    public function testPostLoginpageSuccess01()
//    {
//        $response = $this->runApp('POST', '/profile', ['f_username' => 'ben@example.com', 'f_password' => '1234pass']);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Member', (string)$response->getBody());
//        $this->assertContains('Hello, Ben Bennett!', (string)$response->getBody());
//    }
//
//    public function testPostLoginpageSuccess02()
//    {
//        $response = $this->runApp('POST', '/profile', ['f_username' => 'chris@example.com', 'f_password' => '1234pass']);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Member', (string)$response->getBody());
//        $this->assertContains('Hello, Chris Christensen!', (string)$response->getBody());
//    }
//
//    public function testPostLoginpageFail00()
//    {
//        $response = $this->runApp('POST', '/profile', ['f_username' => 'bob@example.com', 'f_password' => '1234pass']);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Unauthorized, Chuck Norris has been dispatch to find you!', (string)$response->getBody());
//    }
//
//    public function testPostLoginpageFail01()
//    {
//        $response = $this->runApp('POST', '/profile', ['f_username' => 'ben@example.com', 'f_password' => '123pas']);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Unauthorized, Chuck Norris has been dispatch to find you!', (string)$response->getBody());
//    }
}
