<?php

namespace App\Repositories\Ai\Api;

use App\Repositories\Ai\Contracts\IAiRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use Throwable;

class OpenRouterApiRepository implements IAiRepository
{
    public function chat(string $message, array $history = [],string $type = 'NORMAL',array $restaurant = []): array
    {
        try {
            $prompt = $this->resolvePrompt($message,$type, $restaurant);

            $history = $this->prepareHistory($history, $type);

            $response = $this->sendRequest(
                $this->buildMessages($prompt, $message, $history)
            );
            return $this->parseResponse($response);

        } catch (Throwable $exception) {
            report($exception);

            return [
                'error' => true,
                'message' => 'در حال حاضر امکان پاسخ‌گویی وجود ندارد.',
            ];
        }
    }
    private function resolvePrompt(string $message,string $type, array $restaurant): string
    {
        return match ($type) {
            'NORMAL' => $this->systemPrompt($message),
            'WITH_MENU' => $this->restaurantWelcomeWithMenu($restaurant),
            'WITHOUT_MENU' => $this->restaurantWelcomeWithOutMenu($restaurant),
            default => $this->systemPrompt($message),
        };
    }
    private function buildMessages(string $prompt, string $message, array $history): array {
        return array_merge(
            [[ 'role' => 'system', 'content' => $prompt ]],
            $history,
            [[ 'role' => 'user', 'content' => $message ]]
        );
    }
    private function sendRequest(array $messages)
    {
        return Http::withOptions([
            'proxy' => [
                'http'  => config('ai.proxy'),
                'https' => config('ai.proxy'),
            ],
        ])->withHeaders([
            'Authorization' => 'Bearer '.config('ai.openRouter.key'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->acceptJson()
            ->timeout(60)
            ->post(config('ai.openRouter.url'), [
                'model' => config('ai.openRouter.model'),
                'messages' => $messages,
                'temperature' => 0.2,
                'max_tokens' => 300,
            ]);
    }
    private function parseResponse($response): array
    {
        $result = $response->json();

        if ($response->failed()) {
            Log::error('OpenRouter request failed', [
                'status' => $response->status(),
                'error' => data_get($result, 'error'),
            ]);

            return [
                'error' => true,
                'message' => $this->errorMessage($response->status()),
            ];
        }

        $choice = data_get($result, 'choices.0');
        $content = data_get($choice, 'message.content');

        if (!is_array($choice) || !is_string($content) || trim($content) === '') {
            Log::error('AI response content is empty', [
                'status' => $response->status(),
                'has_choice' => is_array($choice),
                'content_type' => get_debug_type($content),
                'finish_reason' => data_get($choice, 'finish_reason'),
            ]);
            return [
                'error' => true,
                'message' => 'پاسخ معتبری از سرویس دریافت نشد.',
            ];
        }

        return $choice;
    }
    private function prepareHistory(array $history, string $type): array
    {
        if ($type !== 'NORMAL') {
            return [];
        }
        return array_slice($history, -4);
    }
    private function systemPrompt(string $userMessage): string
    {
        static $cache = [];

        $sectionsPath = resource_path('prompts/sections');

        if (! is_dir($sectionsPath)) {
            throw new \RuntimeException(
                'Viseh prompt sections directory does not exist.'
            );
        }

        $sections = $this->selectedPrompt($userMessage);

        $contents = [];

        foreach ($sections as $section) {
            if (isset($cache[$section])) {
                $contents[] = $cache[$section];
                continue;
            }

            $path = $sectionsPath . '/' . $section;

            if (! is_readable($path)) {
                throw new \RuntimeException(
                    "Viseh prompt section is not readable: {$section}"
                );
            }

            $content = file_get_contents($path);

            if ($content === false) {
                throw new \RuntimeException(
                    "Unable to read Viseh prompt section: {$section}"
                );
            }

            $cache[$section] = trim($content);

            $contents[] = $cache[$section];
        }

        $videoUrl = asset(
            'assets/whatsapp/videos/viseh-about-video.mp4'
        );

        $settingAboutVideo = Setting::where('key', 'aboutVideo')->first();
        $settingEmail = Setting::where('key', 'email')->first()->value ?? null;
        $settingPhone = Setting::where('key', 'phone')->first()->value ?? null;

        $aboutVideo = $settingAboutVideo?->aboutVideo()->first();

        if ($aboutVideo?->path) {
            $videoUrl = asset('storage/' . $aboutVideo->path);
        }

        $prompt = implode("\n\n", $contents);

        return strtr($prompt, [
            '{{VISEH_TUTORIAL_VIDEO_DESCRIPTION}}' => 'ویدئو رسمی ویسه',
            '{{VISEH_TUTORIAL_VIDEO_ASSET}}' => $videoUrl,
            '{{VISEH_TUTORIAL_VIDEO_URL}}' => $videoUrl,
            '{{SUPPORT_PHONE}}' => $settingPhone,
            '{{SUPPORT_EMAIL}}' => $settingEmail,
        ]);
    }
    private function selectedPrompt(string $message): array
    {
        $message = mb_strtolower(trim($message));
        $rules = [
            '06_identity_mission.md' => [
                'صفحه',
                'لینک',
                'آدرس سایت',
                'نقشه صفحات',
            ],

            '07_identity_mission.md' => [
                'خانه',
                'کشف',
                'نزدیک من',
                'نزدیک شما',
                'پیدا کنم',
                'پیدا کردن',
            ],

            '08_identity_mission.md' => [
                'تولد',
                'جلسه',
                'کودک',
                'حیوان',
                'پت',
                'فضای باز',
                'موسیقی',
                'دی جی',
                'پارکینگ',
                'وای فای',
                'بیلیارد',
                'پلی استیشن',
                'قلیان',
                'رزرو میز',
            ],

            '09_identity_mission.md' => [
                'جستجو',
                'جست‌وجو',
                'فیلتر',
                'استان',
                'شهر',
                'فاصله',
                'بازه قیمت',
                'اعمال فیلتر',
            ],

            '10_identity_mission.md' => [
                'منو',
                'منوی دیجیتال',
                'غذا',
                'غذاها',
                'قیمت غذا',
                'آیتم',
            ],

            '11_identity_mission.md' => [
                'qr',
                'کیو آر',
                'کیوآر',
                'مسیریابی',
                'آدرس رستوران',
                'اطلاعات رستوران',
                'مشاهده و دانلود qr',
            ],

            '12_identity_mission.md' => [
                'ورود',
                'ثبت نام',
                'ثبت‌نام',
                'حساب',
                'پروفایل',
                'تنظیمات',
                'رمز',
                'کد تایید',
                'کد تأیید',
            ],

            '13_identity_mission.md' => [
                'لایو',
                'پخش زنده',
                'دوربین',
                'نصب',
                'اپلیکیشن',
                'برنامه',
            ],

            '14_identity_mission.md' => [
                'نظر',
                'نظرسنجی',
                'نشان',
                'گواهی',
                'طلایی',
                'نقره‌ای',
                'برنزی',
            ],

            '15_identity_mission.md' => [
                'قرعه',
                'قرعه‌کشی',
                'برنده',
                'جایزه',
            ],

            '16_identity_mission.md' => [
                'ثبت رستوران',
                'ثبت کافه',
                'ثبت مجموعه',
                'مجموعه ثبت',
                'هزینه ثبت',
            ],

            '17_identity_mission.md' => [
                'مدیر مجموعه',
                'مدیریت مجموعه',
                'داشبورد',
                'پنل مدیریت',
                'مدیریت منو',
                'مدیریت دوربین',
            ],

            '18_identity_mission.md' => [
                'سفارش',
                'پرداخت',
                'کیف پول',
                'رهگیری',
                'بازپرداخت',
                'api',
                'کمیسیون',
                'تعرفه',
                'حذف حساب',
            ],

            '20_identity_mission.md' => [
                'پشتیبانی',
                'مشکل',
                'کار نمی',
                'نمیاد',
                'نمی‌شود',
                'نمیشه',
            ],

            '21_identity_mission.md' => [
                'ویدئو',
                'ویدیو',
                'فیلم',
                'آموزش',
                'چطور',
                'چگونه',
                'نحوه',
            ],
        ];
        $sections = [
            '01_identity_mission.md',
            '02_identity_mission.md',
            '03_identity_mission.md',
            '04_identity_mission.md',
            '05_identity_mission.md',
            '19_identity_mission.md',
            '23_identity_mission.md',
        ];
        foreach ($rules as $file => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    $sections[] = $file;
                    break;
                }
            }
        }

        return array_values(array_unique($sections));
    }
    private function errorMessage(int $status): string
    {
        return match ($status) {
            402 => 'اعتبار سرویس هوش مصنوعی کافی نیست یا حجم پرامپت بیش از حد مجاز است.',
            429 => 'تعداد درخواست‌ها بیش از حد مجاز است. کمی بعد دوباره تلاش کنید.',
            default => 'در حال حاضر امکان پاسخ‌گویی وجود ندارد.',
        };
    }
    private function restaurantWelcomeWithMenu(array $restaurant): string
    {
        $path = resource_path("prompts/restaurant-welcome-with-menu.md");

        if (!is_readable($path)) {
            throw new \RuntimeException("Prompt file is not readable: {$path}");
        }

        $content = file_get_contents($path);


        if ($content === false) {
            throw new \RuntimeException('Unable to read Viseh system prompt file.');
        }
        $settingPhone = Setting::where('key','phone')->first();
        if ($settingPhone?->value) {
            $supportPhone = $settingPhone?->value;
        } else {
            $supportPhone = null;
        }

        return $prompt = strtr($content, [
            '{{RESTAURANT_NAME}}' => $restaurant['name'] ?? '',
            '{{STATE}}' => ($restaurant['province_name'] ??'') .' - '. ($restaurant['city_name'] ?? ''),
            '{{SITE_URL}}' => config('app.url'),
            '{{SUPPORT_PHONE}}' => $supportPhone,
        ]);

    }
    private function restaurantWelcomeWithOutMenu(array $restaurant): string
    {
        $path = resource_path("prompts/restaurant-welcome-without-menu.md");

        if (!is_readable($path)) {
            throw new \RuntimeException("Prompt file is not readable: {$path}");
        }

        $content = file_get_contents($path);


        if ($content === false) {
            throw new \RuntimeException('Unable to read Viseh system prompt file.');
        }
        $settingPhone = Setting::where('key','phone')->first();
        if ($settingPhone?->value) {
            $supportPhone = $settingPhone?->value;
        } else {
            $supportPhone = null;
        }

        return $prompt = strtr($content, [
            '{{RESTAURANT_NAME}}' => $restaurant['name'] ?? '',
            '{{STATE}}' => ($restaurant['province_name'] ??'') .' - '. ($restaurant['city_name'] ?? ''),
            '{{SITE_URL}}' => config('app.url'),
            '{{SUPPORT_PHONE}}' => $supportPhone,
        ]);

    }
}
