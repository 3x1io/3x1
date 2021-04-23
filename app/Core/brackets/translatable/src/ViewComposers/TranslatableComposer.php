<?php

namespace Brackets\Translatable\ViewComposers;

use Brackets\Translatable\Facades\Translatable;
use Illuminate\Contracts\View\View;

class TranslatableComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('locales', Translatable::getLocales());
    }
}
