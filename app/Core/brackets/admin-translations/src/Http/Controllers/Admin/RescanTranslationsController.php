<?php

namespace Brackets\AdminTranslations\Http\Controllers\Admin;

use Brackets\AdminTranslations\Http\Requests\Admin\Translation\RescanTranslations;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

class RescanTranslationsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @param RescanTranslations $request
     * @return array|Response
     */
    public function rescan(RescanTranslations $request)
    {
        Artisan::call('admin-translations:scan-and-save');

        if ($request->ajax()) {
            return [];
        }

        return redirect('admin/translation');
    }
}
