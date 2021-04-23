<?php

namespace Brackets\AdminAuth\Tests\Feature\StandardUser\Auth;

use Brackets\AdminAuth\Tests\Models\TestStandardUserModel;
use Brackets\AdminAuth\Tests\StandardTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

class LogoutTest extends StandardTestCase
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
    public function auth_user_can_logout(): void
    {
        $user = $this->createTestUser();

        $response = $this->post('/admin/login', ['email' => 'john@example.com', 'password' => 'testpass123']);
        $response->assertStatus(302);

        $this->assertNotEmpty(Auth::guard($this->adminAuthGuard)->user());

        $response = $this->get('/admin/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());
    }

    /** @test */
    public function not_auth_user_cannot_logout(): void
    {
        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());

        $response = $this->get('/admin/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $this->assertEmpty(Auth::guard($this->adminAuthGuard)->user());
    }
}
