<?php

namespace App\Repositories\Ai\Factories;

use App\Repositories\Ai\Api\BluesmindsApiRepository;
use App\Repositories\Ai\Api\GrogApiRepository;
use App\Repositories\Ai\Api\OpenAiApiRepository;
use App\Repositories\Ai\Api\OpenRouterApiRepository;
use App\Repositories\Ai\Contracts\IAiRepository;

class AiRepositoryFactory
{
    public static function make(string $provider = null): IAiRepository
    {
        $provider = $provider ?? config('ai.default');
        return match ($provider) {
            'openAi' => app(OpenAiApiRepository::class),
            'openRouter' => app(OpenRouterApiRepository::class),
            'grog' => app(GrogApiRepository::class),
            'bluesminds' => app(BluesmindsApiRepository::class),
        };
    }
}
