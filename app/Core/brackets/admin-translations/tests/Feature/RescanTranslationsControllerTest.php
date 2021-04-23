<?php

namespace Brackets\AdminTranslations\Test\Feature;

use Brackets\AdminTranslations\Test\TestCase;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

class RescanTranslationsControllerTest extends TestCase
{

    /** @test */
    public function rescan_fills_up_translations_table()
    {
        $this->authorizedToRescan();

        $this->get('/admin/translations')
            ->assertStatus(200)
            ->assertDontSee('good.key1')
            ;

        $this->post('/admin/translations/rescan');

        $this->get('/admin/translations')
            ->assertStatus(200)
            ->assertSee('good.key1')
        ;
    }

    protected function authorizedToRescan()
    {
        $this->authorizedTo(['index', 'rescan']);
    }

    private function authorizedTo($actions)
    {
        $this->actingAs(new User, 'admin');
        Gate::define('admin', function () {
            return true;
        });
        collect((array) $actions)->each(function ($action) {
            Gate::define('admin.translation.'.$action, function () {
                return true;
            });
        });
    }
}
