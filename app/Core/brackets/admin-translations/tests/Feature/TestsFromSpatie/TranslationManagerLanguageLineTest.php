<?php

namespace Brackets\AdminTranslations\Test\Feature\TestsFromSpatie;

use Brackets\AdminTranslations\Test\TestCase;
use Brackets\AdminTranslations\TranslationLoaders\Db;

class TranslationManagerLanguageLineTest extends TestCase
{
    /** @test */
    public function it_will_not_use_database_translations_if_the_provider_is_not_configured()
    {
        $this->app['config']->set('admin-translations.translation_loaders', []);

        $this->assertEquals('group.key', trans('group.key'));
    }

    /** @test */
    public function it_will_merge_translation_from_all_providers()
    {
        $this->app['config']->set('admin-translations.translation_loaders', [
            Db::class,
            DummyLoader::class,
        ]);

        $this->createTranslation('*', 'db', 'key', ['en' => 'db']);

        $this->assertEquals('db', trans('db.key'));
        $this->assertEquals('this is dummy', trans('dummy.dummy'));
    }
}
