<?php

namespace App\Services;

use App\Repositories\Ai\Factories\AiRepositoryFactory;

class AiService
{
    protected $repo;
    public function __construct(?string $aiType)
    {
        $this->repo = AiRepositoryFactory::make(isset($aiType) ? $aiType:null);
    }

    public function chat(string $message, array $history = [],string $type = 'NORMAL',array $restaurant = []): array
    {
        return $this->repo->chat($message, $history,$type,$restaurant);
    }
}
