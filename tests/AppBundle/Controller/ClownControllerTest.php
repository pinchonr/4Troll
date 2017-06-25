<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClownControllerTest extends WebTestCase
{
    /**
    *
    * Test getting home page
    *
    */
    public function testGetHomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome on the 4Troll website!', $crawler->filter('h1')->text());
    }

    /**
    *
    * Test getting newGag page
    *
    */
    public function testGetnewGagPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/newGag');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Upload a new Gag', $crawler->filter('h1')->text());
    }

    /**
    *
    * Test getting gegDetail page assuming at most one gag is posted
    *
    */
    public function testGetGagDetailPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Gag/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Detail of the gag', $crawler->filter('h1')->text());
    }

    /**
    *
    * Test clicking on the "See comments" link send to the Detail of the gag.
    *
    */
    public function testGagDetailLink()
    {
        $client = static::createClient();
        //get the home page
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome on the 4Troll website!', $crawler->filter('#container h1')->text());
        //click the detailGag link
        $link= $crawler->filter('a:contains("See comments")')->link();
        $crawler= $client->click($link);
        $this->assertContains('Detail of the gag', $crawler->filter('h1')->text());
    }
}
