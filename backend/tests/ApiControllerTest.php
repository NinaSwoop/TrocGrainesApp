<?php

declare(strict_types=1);

namespace App\Tests;

use App\Controller\ApiController;
use PHPUnit\Framework\TestCase;

class ApiControllerTest extends TestCase
{
    public function testReturnJsonMessage(): void
    {
        var_dump(ini_get("xdebug.mode"));
        die();

        // Arrange
        $apiController = new ApiController();

        // Act
        $json = $apiController->test();
        $message = $json->getContent();

        // Assert
        $this->assertJsonStringEqualsJsonString(json_encode(['message' => 'Hello from backend']), $message, 'The message is correct');
    }
}
