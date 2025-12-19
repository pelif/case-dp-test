<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\RegisteredUserService;

class RegisteredUserServiceTest extends TestCase
{
    public function test_store_register_successful()
    {
        $service = new RegisteredUserService();
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];
        $result = $service->store($data);
        $this->assertIsBool($result);
    }
}
