<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

if (!function_exists('generateFileName')) {
    function generateFileName($image)
    {
        $type = $image->getClientOriginalExtension();
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour;
        $minute = Carbon::now()->minute;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '.' . $type;
    }
}

if (!function_exists('generateFileNameCustom')) {
    function generateFileNameCustom($image)
    {
        $type = $image;
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour;
        $minute = Carbon::now()->minute;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '.' . $type;
    }
}

if (!function_exists('convertDate')) {
    function convertDate($date)
    {
        if ($date == NULL) {
            return NULL;
        } else {
            $pattern = '/[\/\s]/';
            $shamsiDateSplit = preg_split($pattern, $date);
            $arrayShamsiDateSplit = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);
            $gergorianDate = implode('-', $arrayShamsiDateSplit) . ' ' . '00:00:00';
            return $gergorianDate;
        }
    }
}

if (!function_exists('convertDateTime')) {
    function convertDateTime($datetime)
    {
        if ($datetime === null || trim($datetime) === '') {
            return null;
        }
        [$date, $time] = array_pad(explode(' ', $datetime, 2), 2, '00:00:00');
        $date = str_replace('/', '-', $date);
        [$year, $month, $day] = explode('-', $date);
        $gregorian = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(
            (int)$year,
            (int)$month,
            (int)$day
        );
        if (substr_count($time, ':') === 1) $time .= ':00';
        return implode('-', $gregorian) . ' ' . $time;
    }
}

if (!function_exists('digit_to_persian')) {
    /**
     * @param $value
     *
     * @return string
     */
    function digit_to_persian($value)
    {
        return strtr($value, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
    }
}

if (!function_exists('hashid')) {
    function hashid($id, $connection = 'main')
    {
        return \Vinkla\Hashids\Facades\Hashids::connection($connection)->encode($id);
    }
}

if (!function_exists('unhashid')) {
    function unhashid($id, $connection = 'main')
    {
        return isset(\Vinkla\Hashids\Facades\Hashids::connection($connection)->decode($id)[0]) ? \Vinkla\Hashids\Facades\Hashids::connection($connection)->decode($id)[0] : 404;
    }
}

if (!function_exists('whatsapp_share')) {
    function whatsapp_share($value)
    {
        return 'https://wa.me/?text=' . $value;
    }
}

if (!function_exists('telegram_share')) {
    function telegram_share($value)
    {
        return 'https://telegram.me/share/url?url=' . $value;
    }
}

if (!function_exists('twitter_share')) {

    function twitter_share($value)
    {
        return 'https://twitter.com/share?url=' . $value;
    }
}

if (!function_exists('instagram_share')) {

    function instagram_share($value)
    {
        return 'https://instagram.com/share?url=' . $value;
    }
}

if (!function_exists('isPersianName')) {
    function isPersianName($name)
    {
        return preg_match('/[\x{0600}-\x{06FF}\x{0750}-\x{077F}]/u', $name);
    }
}

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $units = ['', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه'];
        $tens = ['', 'ده', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود'];
        $hundreds = ['', 'صد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد'];
        $thousands = ['', 'هزار', 'میلیون', 'میلیارد'];

        if ($number == 0) {
            return 'صفر';
        }

        $words = '';
        $group = 0;

        while ($number > 0) {
            $chunk = $number % 1000;
            $number = intval($number / 1000);

            if ($chunk > 0) {
                $chunkWords = '';

                if ($chunk >= 100) {
                    $chunkWords .= $hundreds[intval($chunk / 100)] . ' ';
                    $chunk %= 100;
                }

                if ($chunk >= 10 && $chunk < 20) {
                    $teens = [
                        10 => 'ده',
                        11 => 'یازده',
                        12 => 'دوازده',
                        13 => 'سیزده',
                        14 => 'چهارده',
                        15 => 'پانزده',
                        16 => 'شانزده',
                        17 => 'هفده',
                        18 => 'هجده',
                        19 => 'نوزده',
                    ];
                    $chunkWords .= $teens[$chunk];
                } else {
                    if ($chunk >= 20) {
                        $chunkWords .= $tens[intval($chunk / 10)] . ' ';
                        $chunk %= 10;
                    }

                    if ($chunk > 0) {
                        $chunkWords .= $units[$chunk] . ' ';
                    }
                }

                $words = $chunkWords . $thousands[$group] . ' ' . $words;
            }

            $group++;
        }

        return trim($words);
    }
}

if (!function_exists('generateUniqueSlug')) {
    /**
     *
     * @param string $modelClass
     * @param string $value
     * @param string $field
     * @return string
     */
    function generateUniqueSlug(string $modelClass, string $value, string $field = 'slug', $ignoreId = null): string
    {
        $slug = preg_replace('/\s+/', '-', trim($value));
        $originalSlug = $slug;
        $counter = 2;

        while ($modelClass::where($field, $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

if (!function_exists('generateAssetImageUrl')) {
    function generateAssetImageUrl(?string $value): ?string
    {
        if (!isset($value)) return null;
        return asset('storage/' . $value);
    }
}

if (!function_exists('generateMaskBankCard')) {
    function generateMaskBankCard(string $value): ?string
    {
        if (!$value) return null;
        $cardNumber = preg_replace('/\D/', '', $value);
        $masked = '**** **** **** ' . substr($cardNumber, -4);
        return $masked;
    }
}

if (!function_exists('detectBankName')) {
    function detectBankName(string $cardNumber): ?string
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        $bin = substr($cardNumber, 0, 6);

        $banks = [
            '603799' => 'بانک ملی',
            '589210' => 'بانک سپه',
            '627648' => 'بانک توسعه صادرات',
            '627961' => 'بانک صنعت و معدن',
            '603770' => 'بانک کشاورزی',
            '628023' => 'بانک مسکن',
            '627760' => 'پست بانک',
            '502908' => 'بانک توسعه تعاون',
            '627412' => 'بانک اقتصاد نوین',
            '622106' => 'بانک پارسیان',
            '502229' => 'بانک پاسارگاد',
            '627488' => 'بانک کارآفرین',
            '621986' => 'بانک سامان',
            '639346' => 'بانک سینا',
            '639607' => 'بانک سرمایه',
            '502806' => 'بانک شهر',
            '502938' => 'بانک دی',
            '603769' => 'بانک صادرات',
            '610433' => 'بانک ملت',
            '627353' => 'بانک تجارت',
            '589463' => 'بانک رفاه',
            '627381' => 'بانک انصار',
            '639370' => 'بانک مهر ایران',
            '628157' => 'مؤسسه اعتباری توسعه',
        ];

        return $banks[$bin] ?? null;
    }
}

if (!function_exists('generatePriceDecimalFormat')) {
    function generatePriceDecimalFormat(?string $amount): ?string
    {
        if (!isset($amount)) return null;
        $formatted = fmod($amount, 1) == 0
            ? number_format($amount, 0)
            : number_format($amount, 5);
        return $formatted;
    }
}

if (!function_exists('checkIssetField')) {
    function checkIssetField(?string $value): ?string
    {
        if (!isset($value)) return null;
        return $value;
    }
}

if (!function_exists('generateLocationUrl')) {
    function generateLocationUrl(?string $lat, ?string $lng): ?string
    {
        if (!isset($lat) || !isset($lng)) return null;
        $url = 'https://www.google.com/maps/search/?api=1&query=' . $lat . ',' . $lng;
        return $url;
    }
}

if (!function_exists('normalize')) {
    function normalize($data)
    {
        if ($data instanceof \Illuminate\Support\Collection) {
            $data = $data->toArray();
        }

        if (is_array($data)) {
            array_walk_recursive($data, function (&$item) {
                if ($item instanceof \DateTime) {
                    $item = $item->format('c');
                }
            });

            ksort($data);
        }

        return $data;
    }
}

if (!function_exists('get24HorseSeenCountByRestaurantId')) {
    function get24HorseSeenCountByRestaurantId(int $id): int
    {
        if (!$id) return 0;
        $count = 0;
        $filePath = storage_path('logs/restaurant.log');
        if (File::exists($filePath)) {
            $handle = fopen($filePath, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $line = trim($line);
                    if (empty($line)) continue;
                    $logData = json_decode($line);

                    if (json_last_error() !== JSON_ERROR_NONE) continue;
                    if (!isset($logData->context) || !isset($logData->context->id) || !isset($logData->context->show_at)) continue;

                    $currentLog = $logData->context;
                    $showAt = \Carbon\Carbon::parse($currentLog->show_at);
                    if ($currentLog->id == $id && $showAt->greaterThanOrEqualTo(now()->subHours(24))) {
                        $count++;
                    }
                }
                fclose($handle);
            }
        }
        return number_format($count);
    }
}

if (!function_exists('formatDistance')) {
    function formatDistance($distanceInKm)
    {
        if ($distanceInKm === null) {
            return null;
        }
        if ($distanceInKm < 1) {
            return round($distanceInKm * 1000) . ' m';
        }
        $kilometers = floor($distanceInKm * 10) / 10;
        return rtrim(rtrim(number_format($kilometers, 1, '.', ''), '0'), '.') . ' km';
    }
}

if (!function_exists('generateFile')) {
    function generateFile($file)
    {
        if (!isset($file)) return null;
        $tempFile = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tempFile, Http::get($file)->body());
        $file = new UploadedFile(
            $tempFile,
            basename(parse_url($file, PHP_URL_PATH)),
            mime_content_type($tempFile),
            null,
            true
        );
        return $file;
    }
}

if (!function_exists('normalizePhone')) {
    function normalizePhone(mixed $phone): ?string
    {
        if ($phone === null || trim((string)$phone) === '') {
            return null;
        }

        $phone = strtr((string)$phone, [
            '۰' => '0', '۱' => '1', '۲' => '2',
            '۳' => '3', '۴' => '4', '۵' => '5',
            '۶' => '6', '۷' => '7', '۸' => '8',
            '۹' => '9',

            '٠' => '0', '١' => '1', '٢' => '2',
            '٣' => '3', '٤' => '4', '٥' => '5',
            '٦' => '6', '٧' => '7', '٨' => '8',
            '٩' => '9',
        ]);

        $hasPlus = str_starts_with(
            trim($phone),
            '+'
        );

        $digits = preg_replace(
            '/\D+/',
            '',
            $phone
        );

        if (!$digits) {
            return null;
        }

        // +98 یا 0098
        if (str_starts_with($digits, '0098')) {
            return '0' . substr($digits, 4);
        }

        if (str_starts_with($digits, '98')) {
            return '0' . substr($digits, 2);
        }

        // موبایل بدون صفر
        if (
            strlen($digits) === 10 &&
            str_starts_with($digits, '9')
        ) {
            return '0' . $digits;
        }

        // شماره خارجی
        if ($hasPlus) {
            return $digits;
        }

        return $digits;
    }
}

if (!function_exists('checkCloseTimer')) {
    function checkCloseTimer($startTime, $endTime)
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);
        $now = now();

        if ($end->lessThan($start)) {
            if ($now->between($start, Carbon::parse('23:59:59')) || $now->between(Carbon::parse('00:00:00'), $end)) {
                return false;
            }
            return true;
        }
        return !$now->between($start, $end);
    }
}
