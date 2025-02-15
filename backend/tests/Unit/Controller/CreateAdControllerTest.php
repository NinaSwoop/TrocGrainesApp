<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Application\CreateAdService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

class CreateAdControllerTest extends TestCase {

    public function testCreateAd() : void
    {
        //Arrange
        $createAdService = new CreateAdService();
        $request = new Request();
        $serializer = new Serializer();

        //Act

        //Assert
    }
}