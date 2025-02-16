<?php

declare(strict_types=1);

namespace App\Tests\Application;

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