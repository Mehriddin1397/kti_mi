<?php

namespace App\Contracts;

use App\Models\User;

interface SmsServiceInterface
{
    /**
     * Send an SMS message and log the attempt.
     */
    public function send(string $phone, string $message, ?User $user = null): bool;
}
