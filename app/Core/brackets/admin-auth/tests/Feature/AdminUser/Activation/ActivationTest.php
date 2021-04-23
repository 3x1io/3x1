<?php

namespace Brackets\AdminAuth\Tests\Feature\AdminUser\Activation;

use Brackets\AdminAuth\Tests\BracketsTestCase;
use Brackets\AdminAuth\Tests\Models\TestBracketsUserModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivationTest extends BracketsTestCase
{
    use DatabaseMigrations;

    protected $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->token = '123456aabbcc';
    }

    protected function createTestUser(
        bool $activated = true,
        bool $forbidden = false,
        bool $used = false,
        Carbon $activationCreatedAt = null
    ): TestBracketsUserModel {
        // TODO maybe we can Mock sending an email to speed up a test?
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

        //create also activation
        $this->app['db']->connection()->table('admin_activations')->insert([
            'email' => $user->email,
            'token' => $this->token,
            'used' => $used,
            'created_at' => $activationCreatedAt ?? Carbon::now(),
        ]);

        $this->assertDatabaseHas('admin_activations', [
            'email' => 'john@example.com',
            'token' => $this->token,
            'used' => $used,
        ]);

        return $user;
    }

    /** @test */
    public function activate_user_if_token_is_ok(): void
    {
        $user = $this->createTestUser(false);

        $response = $this->get(route('brackets/admin-auth::admin/activation/activate', ['token' => $this->token]));
        $response->assertStatus(302);

        $userNew = TestBracketsUserModel::where('email', 'john@example.com')->first();

        $this->assertEquals(true, $userNew->activated);

        $this->assertDatabaseHas('admin_activations', [
            'email' => 'john@example.com',
            'token' => $this->token,
            'used' => true,
        ]);
    }

    /** @test */
    public function do_not_activate_user_if_token_does_not_exists(): void
    {
        $user = $this->createTestUser(false);

        $response = $this->get(route(
            'brackets/admin-auth::admin/activation/activate',
            ['token' => $this->token . '11']
        ));
        $response->assertStatus(302);

        $userNew = TestBracketsUserModel::where('email', 'john@example.com')->first();
        $this->assertEquals(0, $userNew->activated);

        $this->assertDatabaseHas('admin_activations', [
            'email' => 'john@example.com',
            'token' => $this->token,
            'used' => false,
        ]);
    }

    /** @test */
    public function do_not_activate_user_if_token_used(): void
    {
        $user = $this->createTestUser(false, false, true);

        $response = $this->get(route('brackets/admin-auth::admin/activation/activate', ['token' => $this->token]));
        $response->assertStatus(302);

        $userNew = TestBracketsUserModel::where('email', 'john@example.com')->first();
        $this->assertEquals(0, $userNew->activated);

        $this->assertDatabaseHas('admin_activations', [
            'email' => 'john@example.com',
            'token' => $this->token,
            'used' => true,
        ]);
    }

    /** @test */
    public function do_not_activate_user_if_token_expired(): void
    {
        $user = $this->createTestUser(false, false, false, Carbon::now()->subDays(10));

        $response = $this->get(route('brackets/admin-auth::admin/activation/activate', ['token' => $this->token]));
        $response->assertStatus(302);

        $userNew = TestBracketsUserModel::where('email', 'john@example.com')->first();
        $this->assertEquals(0, $userNew->activated);

        $this->assertDatabaseHas('admin_activations', [
            'email' => 'john@example.com',
            'token' => $this->token,
            'used' => false,
        ]);
    }
}
