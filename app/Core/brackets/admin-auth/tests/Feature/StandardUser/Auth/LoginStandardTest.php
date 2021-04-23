<?php

namespace Brackets\AdminAuth\Tests\Feature\StandardUser\Auth;

use Brackets\AdminAuth\Tests\Models\TestStandardUserModel;
use Brackets\AdminAuth\Tests\StandardTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

class LoginStandardTest extends StandardTestCase
{
    use DatabaseMigrations;

    protected function createTestUser(): TestStandardUserModel
    {
        $user = TestStandardUserModel::create([
            'email' => 'john@example.com',
            'password' => bcrypt('testpass123')
        ]);

        $this->assertDatabaseHas('test_standard_user_models', [
            'email' => 'john@example.com',
        ]);

        return $user;
    }

    /** @test */
    public function login_page_is_accessible(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_log_in(): void
    {
        $user = $this->createTestUser();

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);

        $this->assertNotEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function user_with_wrong_credentials_cannot_log_in(): void
    {
        $user = $this->createTestUser();

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'incorrect password']);
        $response->assertStatus(302);

        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function already_auth_user_is_redirected_from_login(): void
    {
        $user = $this->createTestUser();

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);
        $response->assertRedirect('/admin');

        $this->assertNotEmpty(Auth::guard($this->adminAuthGuard)->user());

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);
        $response->assertRedirect($this->app['config']->get('admin-auth.login_redirect'));
    }
}
