<?php

namespace Tests\Unit;

use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use PHPUnit\Framework\TestCase;
use App\Services\AuthSessionService;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthSessionServiceTest extends TestCase
{
    public function test_store_login_successful()
    {
        // Mock LoginRequest and dependencies
        $request = $this->createMock(AuthLoginRequest::class);
        // Configure the mock as needed
        $service = new AuthSessionService();
        // Simule o comportamento esperado do método store
        $this->expectNotToPerformAssertions();
        $service->store($request);
    }

    public function test_destroy_logout_successful()
    {
        $request = $this->createMock(Request::class);
        $service = new AuthSessionService();
        $result = $service->destroy($request);
        $this->assertIsBool($result);
    }
}
