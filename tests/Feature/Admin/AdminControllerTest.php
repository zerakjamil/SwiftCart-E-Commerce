<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\V1\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    private function createSuperAdmin()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('superadmin');
        return $admin;
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        $admin = $this->createSuperAdmin();

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_cannot_login_with_incorrect_credentials()
    {
        $this->createSuperAdmin();

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    public function test_admin_is_locked_out_after_too_many_attempts()
    {
        $admin = $this->createSuperAdmin();

        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('admin.login'), [
                'email' => $admin->email,
                'password' => 'wrong_password',
            ]);
        }

        $response = $this->post(route('admin.login'), [
            'email' => $admin->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(429);
    }

    public function test_admin_can_logout()
    {
        $admin = $this->createSuperAdmin();
        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    public function test_admin_can_create_new_admin()
    {
        $admin = $this->createSuperAdmin();
        $this->actingAs($admin, 'admin');

        $newAdminData = [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('admin.store'), $newAdminData);

        $response->assertRedirect(route('admin.index'));
        $this->assertDatabaseHas('admins', ['email' => 'newadmin@example.com']);
    }

    public function test_non_admin_cannot_create_new_admin()
    {
        $response = $this->post(route('admin.store'), [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseMissing('admins', ['email' => 'newadmin@example.com']);
    }

    public function test_admin_can_update_own_profile()
    {
        $admin = $this->createSuperAdmin();
        $this->actingAs($admin, 'admin');

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'old_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->put(route('admin.update', $admin), $updatedData);

        $response->assertRedirect(route('admin.index'));
        $this->assertDatabaseHas('admins', ['email' => 'updated@example.com']);
    }

    public function test_admin_cannot_update_profile_with_incorrect_old_password()
    {
        $admin = $this->createSuperAdmin();
        $this->actingAs($admin, 'admin');

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'old_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->put(route('admin.update', $admin), $updatedData);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('admins', ['email' => 'updated@example.com']);
    }

    public function test_admin_can_delete_another_admin()
    {
        $admin = $this->createSuperAdmin();
        $this->actingAs($admin, 'admin');

        $adminToDelete = Admin::factory()->create();
        $adminToDelete->assignRole('superadmin');

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->delete(route('admin.destroy', $adminToDelete));

        $response->assertRedirect(route('admin.index'));
        $this->assertDatabaseMissing('admins', ['id' => $adminToDelete->id]);
    }

    public function test_non_admin_cannot_delete_admin()
    {
        $adminToDelete = $this->createSuperAdmin();

        $response = $this->delete(route('admin.destroy', $adminToDelete));

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseHas('admins', ['id' => $adminToDelete->id]);
    }
}
