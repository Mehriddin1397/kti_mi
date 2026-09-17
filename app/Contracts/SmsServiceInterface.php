<?php

namespace App\Contracts;

use App\Models\User;

interface SmsServiceInterface
{
    /**
     * Send an SMS message and log the attempt.
     *
     * $logMessage overrides what gets written to sms_logs (e.g. to keep a
     * one-time password out of permanent storage) while the real $message
     * is still what's delivered to the phone.
     */
    public function send(string $phone, string $message, ?User $user = null, ?string $logMessage = null): bool;
}
