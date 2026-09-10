<?php

namespace Tests\Unit;

use App\Models\SmsLog;
use App\Models\User;
use App\Services\Sms\EskizSmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EskizSmsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_eskiz_sms_sends_successfully(): void
    {
        Http::fake([
            '*/api/auth/login' => Http::response(['data' => ['token' => 'mocked-test-token']], 200),
            '*/api/message/sms/send' => Http::response(['status' => 'waiting', 'message' => 'Waiting for SMS provider'], 200),
        ]);

        config([
            'services.eskiz.email' => 'test@eskiz.uz',
            'services.eskiz.password' => 'secret',
            'services.eskiz.from' => '4546',
            'services.eskiz.base_url' => 'https://notify.eskiz.uz',
        ]);

        $service = new EskizSmsService();
        $user = User::factory()->create(['phone' => '+998901234567']);

        $result = $service->send($user->phone, 'Test SMS matni', $user);

        $this->assertTrue($result);
        $this->assertDatabaseHas('sms_logs', [
            'user_id' => $user->id,
            'phone' => '+998901234567',
            'message' => 'Test SMS matni',
            'status' => 'yuborildi',
        ]);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/api/message/sms/send')
                && $request['mobile_phone'] === '998901234567'
                && $request['message'] === 'Test SMS matni'
                && $request['from'] === '4546';
        });
    }

    public function test_eskiz_sms_handles_api_failure_gracefully(): void
    {
        Http::fake([
            '*/api/auth/login' => Http::response(['data' => ['token' => 'mocked-test-token']], 200),
            '*/api/message/sms/send' => Http::response(['status' => 'error', 'message' => 'Insufficient funds'], 400),
        ]);

        config([
            'services.eskiz.email' => 'test@eskiz.uz',
            'services.eskiz.password' => 'secret',
            'services.eskiz.from' => '4546',
            'services.eskiz.base_url' => 'https://notify.eskiz.uz',
        ]);

        $service = new EskizSmsService();
        $user = User::factory()->create(['phone' => '+998901234567']);

        $result = $service->send($user->phone, 'Test SMS matni', $user);

        $this->assertFalse($result);
        $this->assertDatabaseHas('sms_logs', [
            'user_id' => $user->id,
            'phone' => '+998901234567',
            'message' => 'Test SMS matni',
            'status' => 'xato',
        ]);
    }
}
