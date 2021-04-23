<?php

namespace Brackets\AdminAuth\Tests\Feature\AdminUser\Activation;

use Brackets\AdminAuth\Tests\BracketsTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DisabledActivationFormTest extends BracketsTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('admin-auth.self_activation_form_enabled', false);
    }

    /** @test */
    public function can_not_see_activation_form_if_disabled(): void
    {
        $response = $this->get(url('/admin/activation'));
        $response->assertStatus(404);
    }
}
