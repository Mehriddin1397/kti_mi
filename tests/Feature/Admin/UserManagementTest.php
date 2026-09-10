<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_create_a_user_with_a_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Roles::ADMIN);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'full_name' => 'Nodira Karimova',
            'phone' => '+998911112233',
            'role' => Roles::MASUL_XODIM,
            'password' => 'staff12345',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $user = User::where('phone', '+998911112233')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole(Roles::MASUL_XODIM));
        $this->assertTrue($user->is_active);
        $this->assertSame('staff12345', $user->initial_password);
    }

    public function test_non_admin_cannot_access_admin_panel(): void
    {
        $applicant = User::factory()->create();
        $applicant->assignRole(Roles::IZLANUVCHI);

        $this->actingAs($applicant)->get('/admin/users')->assertForbidden();
    }

    public function test_deactivating_a_user_prevents_login(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Roles::ADMIN);

        $user = User::factory()->create();
        $user->assignRole(Roles::IZLANUVCHI);

        $this->actingAs($admin)->delete("/admin/users/{$user->id}");

        $this->assertFalse($user->refresh()->is_active);

        // The "guest" middleware on /login would otherwise redirect away
        // an already-authenticated admin before the controller ever runs.
        $this->app['auth']->guard('web')->logout();

        $this->post('/login', [
            'phone' => $user->phone,
            'password' => 'password',
        ]);

        $this->assertGuest();
    }
}
