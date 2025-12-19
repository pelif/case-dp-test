<?php

namespace App\Services\Contracts;

interface RegisteredUserServiceInterface
{
    public function store(array $data): bool;
}
