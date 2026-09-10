<?php

namespace App\Services\Sms;

use App\Contracts\SmsServiceInterface;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

final class EskizSmsService implements SmsServiceInterface
{
    private function getToken(): string
    {
        return Cache::remember(
            'eskiz_sms_token',
            now()->addMinutes(50),
            function (): string {
                try {
                    $baseUrl = rtrim(config('services.eskiz.base_url', 'https://notify.eskiz.uz'), '/');
                    $response = Http::asForm()->timeout(10)->post(
                        "{$baseUrl}/api/auth/login",
                        [
                            'email' => config('services.eskiz.email'),
                            'password' => config('services.eskiz.password'),
                        ]
                    );

                    if ($response->successful() && $response->json('data.token')) {
                        return $response->json('data.token');
                    }

                    Log::error('Eskiz Token Error: ' . $response->body());
                } catch (Throwable $e) {
                    Log::error('Eskiz Token Exception: ' . $e->getMessage());
                }

                if ($fallbackToken = config('services.eskiz.token')) {
                    return $fallbackToken;
                }

                throw new RuntimeException('Eskiz token olishda xatolik');
            }
        );
    }

    public function send(string $phone, string $message, ?User $user = null): bool
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 9) {
            $cleanPhone = '998' . $cleanPhone;
        }

        $baseUrl = rtrim(config('services.eskiz.base_url', 'https://notify.eskiz.uz'), '/');

        try {
            $token = $this->getToken();

            $response = Http::withToken($token)
                ->asForm()
                ->timeout(10)
                ->post("{$baseUrl}/api/message/sms/send", [
                    'mobile_phone' => $cleanPhone,
                    'message'      => $message,
                    'from'         => config('services.eskiz.from', '4546'),
                ]);

            if (! $response->successful() || $response->json('status') === 'error') {
                Log::error("Eskiz SMS Xatoligi ({$cleanPhone}): " . $response->body());
                SmsLog::create([
                    'user_id' => $user?->id,
                    'phone' => $phone,
                    'message' => $message,
                    'status' => 'xato',
                ]);

                return false;
            }

            Log::info("Eskiz SMS Yuborildi ({$cleanPhone}): " . $response->body());
            SmsLog::create([
                'user_id' => $user?->id,
                'phone' => $phone,
                'message' => $message,
                'status' => 'yuborildi',
            ]);

            return true;
        } catch (Throwable $e) {
            Log::error("Eskiz SMS Exception ({$cleanPhone}): " . $e->getMessage());
            SmsLog::create([
                'user_id' => $user?->id,
                'phone' => $phone,
                'message' => $message,
                'status' => 'xato',
            ]);

            return false;
        }
    }
}
