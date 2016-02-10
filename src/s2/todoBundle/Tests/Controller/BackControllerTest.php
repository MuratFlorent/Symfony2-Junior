<?php

namespace s2\todoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/home');
    }

    public function testFiche()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fiche');
    }

    public function testForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/form');
    }

}
