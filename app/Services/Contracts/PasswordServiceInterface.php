<?php

namespace App\Services\Contracts;

interface PasswordServiceInterface
{
    public function update(array $data): bool;
}
