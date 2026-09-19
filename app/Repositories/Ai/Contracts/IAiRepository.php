<?php

namespace App\Repositories\Ai\Contracts;

interface IAiRepository
{
    public function chat(string $message, array $history = [],string $type = 'NORMAL',array $restaurant = []): array;
}
