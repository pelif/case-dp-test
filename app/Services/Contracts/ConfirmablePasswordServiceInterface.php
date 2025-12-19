<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface ConfirmablePasswordServiceInterface
{
    public function store(Request $request): void;
}
