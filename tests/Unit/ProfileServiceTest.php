<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileDeleteRequest;
use App\Http\Requests\ProfileUploadAvatarRequest;

class ProfileServiceTest extends TestCase
{
    public function test_edit_returns_array()
    {
        $request = $this->createMock(Request::class);
        $service = new ProfileService();
        $result = $service->edit($request);
        $this->assertIsArray($result);
    }

    public function test_update_returns_bool()
    {
        $request = $this->createMock(ProfileUpdateRequest::class);
        $service = new ProfileService();
        $result = $service->update($request);
        $this->assertIsBool($result);
    }

    public function test_destroy_returns_bool()
    {
        $request = $this->createMock(ProfileDeleteRequest::class);
        $service = new ProfileService();
        $result = $service->destroy($request);
        $this->assertIsBool($result);
    }

    public function test_upload_avatar_returns_bool()
    {
        $request = $this->createMock(ProfileUploadAvatarRequest::class);
        $service = new ProfileService();
        $result = $service->uploadAvatar($request);
        $this->assertIsBool($result);
    }
}
