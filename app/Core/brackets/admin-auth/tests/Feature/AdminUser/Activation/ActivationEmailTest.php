<?php

namespace Brackets\AdminAuth\Tests\Feature\AdminUser\Activation;

use Brackets\AdminAuth\Notifications\ActivationNotification;
use Brackets\AdminAuth\Tests\BracketsTestCase;
use Brackets\AdminAuth\Tests\Models\TestBracketsUserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;

class ActivationEmailTest extends BracketsTestCase
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
    public function can_see_activation_form(): void
    {
        $response = $this->get(url('/admin/activation'));
        $response->assertStatus(200);
    }

    /** @test */
    public function send_activation_email_after_user_created(): void
    {
        Notification::fake();

        $user = $this->createTestUser(false);

        Notification::assertSentTo(
            $user,
            ActivationNotification::class
        );
    }

    /** @test */
    public function send_activation_email_after_user_not_activated_and_form_filled(): void
    {
        Notification::fake();

        $user = $this->createTestUser(false);

        $response = $this->post(url('/admin/activation/send'), ['email' => 'john@example.com']);
        $response->assertStatus(302);

        Notification::assertSentTo(
            $user,
            ActivationNotification::class
        );
    }

    /** @test */
    public function do_not_send_activation_email_if_email_not_found(): void
    {
        Notification::fake();

        $response = $this->post(url('/admin/activation/send'), ['email' => 'user@example.com']);
        $response->assertStatus(302);

        $user = new TestBracketsUserModel([
            'email' => 'user@example.com',
            'password' => bcrypt('testpass123'),
            'activated' => false,
            'forbidden' => false,
        ]);

        Notification::assertNotSentTo(
            $user,
            ActivationNotification::class
        );
    }

    /** @test */
    public function do_not_send_activation_email_if_user_already_activated(): void
    {
        Notification::fake();

        $user = $this->createTestUser(true);

        $response = $this->post(url('/admin/activation/send'), ['email' => 'john@example.com']);
        $response->assertStatus(302);

        Notification::assertNotSentTo(
            $user,
            ActivationNotification::class
        );
    }
}
