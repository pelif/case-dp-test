<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

trait UploadAvatar
{
    public function upload($file, $userId)
    {
        return $file->store($userId, 'public');
    }
}
