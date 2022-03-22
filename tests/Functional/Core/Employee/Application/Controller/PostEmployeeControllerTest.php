<?php

declare(strict_types = 1);

namespace App\Tests\Functional\Core\Employee\Application\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class PostEmployeeControllerTest extends ApiTestCase
{
    public function testCreateEmployeeController_Success(): void
    {
        $response = static::createClient()->request(
            'POST',
            'http://localhost/api/employee/',
            [
                'headers' => [
                    'Content-Type: application/json',
                ],
                'body' => json_encode([
                    'name' => 'Test employee',
                ]),
            ],
        );

        $this->assertResponseIsSuccessful();
    }
}
