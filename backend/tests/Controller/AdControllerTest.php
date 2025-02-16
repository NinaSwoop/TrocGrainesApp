<?php

declare(strict_types=1);

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdControllerTest extends WebTestCase
{
    public function testAdController(): void
    {

        $client = static::createClient();
        $client->request('GET', '/api/ads');

        $this->assertResponseIsSuccessful('Response is not successful');

    }
}