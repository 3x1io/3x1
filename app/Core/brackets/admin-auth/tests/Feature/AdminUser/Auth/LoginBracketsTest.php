<?php

namespace Brackets\AdminAuth\Tests\Feature\AdminUser\Auth;

use Brackets\AdminAuth\Tests\BracketsTestCase;
use Brackets\AdminAuth\Tests\Models\TestBracketsUserModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

class LoginBracketsTest extends BracketsTestCase
{
    use DatabaseMigrations;

    protected function createTestUser(bool $activated = true, bool $forbidden = false): TestBracketsUserModel
    {
        $user = TestBracketsUserModel::create([
            'email' => 'john@example.com',
            'password' => bcrypt('testpass123'),
            'activated' => $activated,
            'forbidden' => $forbidden,
        ]);

        $this->assertDatabaseHas('test_brackets_user_models', [
            'email' => 'john@example.com',
            'activated' => $activated,
            'forbidden' => $forbidden,
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
        $this->assertNull($user->last_login_at);

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);

        $this->assertNotEmpty(Auth::guard($this->adminAuthGuard)->user());
        $this->assertNotNull(Auth::guard($this->adminAuthGuard)->user()->last_login_at);
    }

    /** @test */
    public function user_with_wrong_credentials_cannot_log_in(): void
    {
        $user = $this->createTestUser();

        $response = $this->json('post', '/admin/login', ['email' => 'john@example.com', 'password' => 'testpass1231']);
        $response->assertStatus(422);

        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function not_activated_user_cannot_log_in(): void
    {
        $user = $this->createTestUser(false);

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);

        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function not_activated_user_can_log_in_if_activation_disabled(): void
    {
        $user = $this->createTestUser(false);

        $this->app['config']->set('admin-auth.activation_enabled', false);

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);

        $this->assertNotEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function forbidden_user_cannot_log_in(): void
    {
        $user = $this->createTestUser(true, true);

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);

        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function deleted_user_cannot_log_in(): void
    {
        $time = Carbon::now();
        //Delted at is not fillable, therefore we need to unguard to force fill
        TestBracketsUserModel::unguard();
        $user = TestBracketsUserModel::create([
            'email' => 'john@example.com',
            'password' => bcrypt('testpass123'),
            'activated' => true,
            'forbidden' => false,
            'deleted_at' => $time,
        ]);
        TestBracketsUserModel::reguard();

        $this->assertDatabaseHas('test_brackets_user_models', [
            'email' => 'john@example.com',
            'activated' => true,
            'forbidden' => false,
            'deleted_at' => $time,
        ]);

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
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
