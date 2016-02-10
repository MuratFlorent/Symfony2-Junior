<?php

namespace s2\todoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testFiche()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fiche');
    }

}
