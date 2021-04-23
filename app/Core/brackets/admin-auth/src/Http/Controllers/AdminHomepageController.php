<?php

namespace Brackets\AdminAuth\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AdminHomepageController extends Controller
{
    /**
     * Display default admin home page
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.homepage.index');
    }

    public function updatePageVisibility()
    {
        Cache::put('page_visibility', request('state'));
        return 'ok';
    }
}
