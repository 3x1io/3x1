<?php

namespace Brackets\Translatable\Test\Feature;

use Brackets\Translatable\Test\TestCase;

class TranslatableRequestTestTest extends TestCase
{
    /** @test */
    public function request_can_have_translatable_columns()
    {
        $this->assertEquals([
            'published_at' => ['required', 'datetime'],
            'title.en' => ['required', 'string'],
            'title.de' => ['required', 'string'],
            'title.fr' => ['required', 'string'],
            'body.en' => ['nullable', 'text'],
            'body.de' => ['nullable', 'text'],
            'body.fr' => ['nullable', 'text'],
        ], $this->testRequest->rules());
    }

    /** @test */
    public function request_can_override_required_locales()
    {
        $this->assertEquals([
            'published_at' => ['required', 'datetime'],
            'title.en' => ['required', 'string'],
            'title.de' => ['required', 'string'],
            'title.fr' => ['string', 'nullable'],
            'body.en' => ['nullable', 'text'],
            'body.de' => ['nullable', 'text'],
            'body.fr' => ['nullable', 'text'],
        ], $this->testRequestWithRequiredLocales->rules());
    }
}
