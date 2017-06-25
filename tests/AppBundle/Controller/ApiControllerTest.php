<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    /**
    *
    * Test getting all gags
    *
    */
    public function testGetAllGags()
    {
        $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'testeur',
        'PHP_AUTH_PW'   => 'testeur',
        ));
        $client->request('GET', '/api/gags');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('"id":1', $client->getResponse()->getContent());
    }

    /**
    *
    * Test getting one gag (assuming one gag is posted)
    *
    */
    public function testGetOneGag()
    {
        $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'testeur',
        'PHP_AUTH_PW'   => 'testeur',
        ));
        $client->request('GET', '/api/gags');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('"id":1', $client->getResponse()->getContent());
    }

    /**
    *
    * Test getting all comments
    *
    */
    public function testGetAllComments()
    {
        $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'testeur',
        'PHP_AUTH_PW'   => 'testeur',
        ));
        $client->request('GET', '/api/gags/1/comments');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
    }

    /**
    *
    * Test getting one comment (assuming one comment is posted for given gag is posted)
    *
    */
    public function testGetOneComment()
    {
        $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'testeur',
        'PHP_AUTH_PW'   => 'testeur',
        ));
        $client->request('GET', '/api/gags/1/comments/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('{"id":1', $client->getResponse()->getContent());
    }
}
