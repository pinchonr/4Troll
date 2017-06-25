<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    private $BASE_URL='http://localhost';
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
    * Testing register successfull
    */
    public function testPOSTRegisterSuccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register!')->form();
        $crawler = $client->submit(
                $form,
                array('appbundle_user[surname]' => 'testeur2',
                      'appbundle_user[name]' => 'testeur2',
                      'appbundle_user[username]' => 'testeur2',
                      'appbundle_user[password][first]' => 'testeur2',
                      'appbundle_user[password][second]' => 'testeur2',
                      'appbundle_user[email]' => 'testeur2@test.fr',
                )
        );
        $this->assertFalse($client->getResponse()->isRedirect($this->BASE_URL.'/register'));
        $this->assertTrue($client->getResponse()->isRedirect('/login'));
    }

    /**
    * Testing register fail (password too short)
    */
    public function testPOSTRegisterFail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register!')->form();
        $crawler = $client->submit(
                $form,
                array('appbundle_user[surname]' => 'testeur3',
                      'appbundle_user[name]' => 'testeur3',
                      'appbundle_user[username]' => 'testeur3',
                      'appbundle_user[password][first]' => 'test',
                      'appbundle_user[password][second]' => 'test',
                      'appbundle_user[email]' => 'testeur3@test.fr',
                )
        );
        $this->assertContains('Register', $crawler->filter('h1')->text());
        $this->assertContains('Your password must be at least 6 characters long.', $crawler->filter('form')->text());

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
        $form = $crawler->selectButton('Login')->form();
        $crawler = $client->submit(
                $form,
                array('_username' => 'testeur',
                      '_password' => 'testeur'
                )
        );
        $this->assertFalse($client->getResponse()->isRedirect($this->BASE_URL.'/login'));
        $this->assertTrue($client->getResponse()->isRedirect($this->BASE_URL.'/'));
    }

    /**
    * Testing login fail
    */
    public function testPOSTLoginFail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Login')->form();
        $crawler = $client->submit(
                $form,
                array('_username' => 'testeur',
                      '_password' => 'testeur1'
                )
        );
        $this->assertFalse($client->getResponse()->isRedirect($this->BASE_URL.'/'));
        $this->assertTrue($client->getResponse()->isRedirect($this->BASE_URL.'/login'));
        $crawler = $client->followRedirect();
        $this->assertContains('Invalid credentials.',$crawler->filter('form #error')->text());
    }

    /**
    * Testing you hit the updateProfile page when the route is /editProfile
    */
    public function testGETUpdateProfile()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/editProfile');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('User Profile', $crawler->filter('h1')->text());
    }


    
}
