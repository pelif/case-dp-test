<?php

namespace App\Services\Contracts;

use App\Http\Requests\NewPasswordRequest;

interface NewPasswordServiceInterface
{
    public function store(NewPasswordRequest $request): bool;
}
