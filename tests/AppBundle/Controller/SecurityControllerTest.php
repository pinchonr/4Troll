<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    /**
    * Testing you hit the register page when the route is /register
    */
    public function testGETRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Register', $crawler->filter('h1')->text());
    }

    /**
    * Testing you hit the login page when the route is /login
    */
    public function testGETLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Login', $crawler->filter('h1')->text());
    }

    /**
    * Testing login successfull
    */
    public function testPOSTLoginSuccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $crawler = $client->submit(
                $form,
                array('_username' => 'toto',
                      '_password' => 'toto'
                )
        );
        $this->assertFalse($client->getResponse()->isRedirect('http://localhost/login'));
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/'));
    }

    /**
    * Testing login fail
    */
    public function testPOSTLoginFail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $crawler = $client->submit(
                $form,
                array('_username' => 'toto',
                      '_password' => 'titi'
                )
        );
        $this->assertFalse($client->getResponse()->isRedirect('http://localhost/'));
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    
}
