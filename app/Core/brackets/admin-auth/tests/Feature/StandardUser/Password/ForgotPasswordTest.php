<?php

namespace Brackets\AdminAuth\Tests\Feature\StandardUser\Password;

use Brackets\AdminAuth\Notifications\ResetPassword;
use Brackets\AdminAuth\Tests\Models\TestStandardUserModel;
use Brackets\AdminAuth\Tests\StandardTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordTest extends StandardTestCase
{
    use DatabaseMigrations;

    protected function createTestUser(): TestStandardUserModel
    {
        $user = TestStandardUserModel::create([
            'email' => 'john@example.com',
            'password' => bcrypt('testpass123'),
        ]);

        $this->assertDatabaseHas('test_standard_user_models', [
            'email' => 'john@example.com',
        ]);

        return $user;
    }

    /** @test */
    public function can_see_forgot_password_form(): void
    {
        $response = $this->get(url('/admin/password-reset'));
        $response->assertStatus(200);
    }

    /** @test */
    public function send_forgot_password_email_after_form_filled(): void
    {
        Notification::fake();

        $user = $this->createTestUser();

        $response = $this->post(url('/admin/password-reset/send'), ['email' => 'john@example.com']);
        $response->assertStatus(302);

        Notification::assertSentTo(
            $user,
            ResetPassword::class
        );
    }

    /** @test */
    public function do_not_send_password_email_if_email_not_found(): void
    {
        Notification::fake();

        $user = $this->createTestUser();

        $response = $this->post(url('/admin/password-reset/send'), ['email' => 'john1@example.com']);
        $response->assertStatus(302);

        Notification::assertNotSentTo(
            $user,
            ResetPassword::class
        );
    }
}
