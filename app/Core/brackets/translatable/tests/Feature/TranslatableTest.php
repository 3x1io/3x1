<?php

namespace Brackets\Translatable\Test\Feature;

use Brackets\Translatable\Test\TestCase;
use Brackets\Translatable\Translatable;

class TranslatableTest extends TestCase
{
    /** @test */
    public function package_can_define_used_locales()
    {
        $translatable = app(Translatable::class);
        $this->assertEquals(collect(['en', 'de', 'fr']), $translatable->getLocales());
    }
}
