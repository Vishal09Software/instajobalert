
<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OtpService
{
    // Generate a 6-digit OTP
    public function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    // Store OTP in cache with expiration and rate limit (max 5 per 10 min)
    public function storeOtp(string $email, string $otp, int $minutes = 10): bool
    {
        $rateKey = "otp_rate_{$email}";
        $count = Cache::get($rateKey, 0);

        if ($count >= 5) return false; // Rate limit exceeded

        Cache::put($rateKey, $count + 1, now()->addMinutes($minutes));
        Cache::put("otp_{$email}", $otp, now()->addMinutes($minutes));
        return true;
    }

    // Verify OTP for given email
    public function verifyOtp(string $email, string $otp): bool
    {
        $key = "otp_{$email}";
        if (($stored = Cache::get($key)) && $stored === $otp) {
            Cache::forget($key);
            return true;
        }
        return false;
    }

    // Generate and store password reset token
    public function generateResetToken(string $email, int $minutes = 60): string
    {
        $token = Str::random(60);
        Cache::put("reset_token_{$email}", $token, now()->addMinutes($minutes));
        return $token;
    }

    // Verify password reset token
    public function verifyResetToken(string $email, string $token): bool
    {
        $key = "reset_token_{$email}";
        if (($stored = Cache::get($key)) && $stored === $token) {
            Cache::forget($key);
            return true;
        }
        return false;
    }
}