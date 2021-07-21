<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SettingsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\BulkDestroySetting;
use App\Http\Requests\Admin\Setting\DestroySetting;
use App\Http\Requests\Admin\Setting\IndexSetting;
use App\Http\Requests\Admin\Setting\StoreSetting;
use App\Http\Requests\Admin\Setting\UpdateSetting;
use App\Models\Setting;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSetting $request
     * @return array|Factory|View
     */
    public function index(IndexSetting $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Setting::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['group', 'id', 'key'],

            // set columns to searchIn
            ['group', 'id', 'key', 'value']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.setting.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.setting.create');

        return view('admin.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSetting $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSetting $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Setting
        $setting = Setting::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/settings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/settings');
    }

    /**
     * Display the specified resource.
     *
     * @param Setting $setting
     * @throws AuthorizationException
     * @return void
     */
    public function show(Setting $setting)
    {
        $this->authorize('admin.setting.show', $setting);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Setting $setting
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Setting $setting)
    {
        $this->authorize('admin.setting.edit', $setting);


        return view('admin.setting.edit', [
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSetting $request
     * @param Setting $setting
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSetting $request, Setting $setting)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Setting
        $setting->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/settings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySetting $request
     * @param Setting $setting
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySetting $request, Setting $setting)
    {
        $setting->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySetting $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySetting $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Setting::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    /**
     * Export entities
     *
     * @return BinaryFileResponse|null
     */
    public function export(): ?BinaryFileResponse
    {
        return Excel::download(app(SettingsExport::class), 'settings.xlsx');
    }
}
