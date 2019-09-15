<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testInit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/init');

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
    public function testGetEntry()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/entry?id=1234');
        $response = $client->getResponse()->getContent();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertRegexp('/response/', $response);
    }
    public function testWrongEntry()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/entry');

        $response = $client->getResponse()->getContent();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegexp('/error/', $response);
    }

    public function testDeleteEntry()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/api/entry?id=33');

        $response = $client->getResponse()->getContent();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegexp('/Removed/', $response);
    }
}
