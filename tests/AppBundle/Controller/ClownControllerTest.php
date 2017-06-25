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
    public function testGetIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome on the 4Troll website!', $crawler->filter('h1')->text());
    }

    /**
    *
    * Test clicking on the "Voir les commentaires" link send to the Detail of the gag.
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
        $link= $crawler->filter('a:contains("Voir les commentaires")')->link();
        $crawler= $client->click($link);
        $this->assertContains('Detail of the gag', $crawler->filter('h1')->text());
    }
}
