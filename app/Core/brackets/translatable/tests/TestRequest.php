<?php

namespace Brackets\Translatable\Test;

use Brackets\Translatable\TranslatableFormRequest;

class TestRequest extends TranslatableFormRequest
{
    // define all the regular rules
    public function untranslatableRules()
    {
        return [
            'published_at' => ['required', 'datetime'],
        ];
    }

    // define all the rules for translatable columns
    public function translatableRules($locale)
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['nullable', 'text'],
        ];
    }
}
