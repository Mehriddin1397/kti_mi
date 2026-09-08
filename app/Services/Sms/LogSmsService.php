<?php

namespace App\Services\Sms;

use App\Contracts\SmsServiceInterface;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Mock SMS driver: writes to sms_logs and the app log instead of calling a
 * real provider. Swap the SmsServiceInterface binding in AppServiceProvider
 * for a real driver (Eskiz.uz, Play Mobile, ...) when one is connected.
 */
class LogSmsService implements SmsServiceInterface
{
    public function send(string $phone, string $message, ?User $user = null): bool
    {
        Log::info("[SMS -> {$phone}] {$message}");

        SmsLog::create([
            'user_id' => $user?->id,
            'phone' => $phone,
            'message' => $message,
            'status' => 'yuborildi',
        ]);

        return true;
    }
}
