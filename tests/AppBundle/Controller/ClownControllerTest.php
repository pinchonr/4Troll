<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClownControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome on the 4Troll website!', $crawler->filter('h1')->text());
    }

    public function testNewGag()
    {
    }


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
