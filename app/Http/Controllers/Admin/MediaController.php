<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MediaExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medium\BulkDestroyMedium;
use App\Http\Requests\Admin\Medium\DestroyMedium;
use App\Http\Requests\Admin\Medium\IndexMedium;
use App\Http\Requests\Admin\Medium\StoreMedium;
use App\Http\Requests\Admin\Medium\UpdateMedium;
use App\Models\Medium;
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

class MediaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMedium $request
     * @return array|Factory|View
     */
    public function index(IndexMedium $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Medium::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['collection_name', 'conversions_disk', 'custom_properties', 'disk', 'file_name', 'generated_conversions', 'id', 'manipulations', 'mime_type', 'model_id', 'model_type', 'name', 'order_column', 'responsive_images', 'size', 'uuid'],

            // set columns to searchIn
            ['collection_name', 'conversions_disk', 'custom_properties', 'disk', 'file_name', 'generated_conversions', 'id', 'manipulations', 'mime_type', 'model_type', 'name', 'responsive_images', 'uuid']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.medium.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.medium.create');

        return view('admin.medium.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMedium $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMedium $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Medium
        $medium = Medium::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/media'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/media');
    }

    /**
     * Display the specified resource.
     *
     * @param Medium $medium
     * @throws AuthorizationException
     * @return void
     */
    public function show(Medium $medium)
    {
        $this->authorize('admin.medium.show', $medium);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Medium $medium
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Medium $medium)
    {
        $this->authorize('admin.medium.edit', $medium);


        return view('admin.medium.edit', [
            'medium' => $medium,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMedium $request
     * @param Medium $medium
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMedium $request, Medium $medium)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Medium
        $medium->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/media'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/media');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMedium $request
     * @param Medium $medium
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMedium $request, Medium $medium)
    {
        $medium->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMedium $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMedium $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Medium::whereIn('id', $bulkChunk)->delete();

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
        return Excel::download(app(MediaExport::class), 'media.xlsx');
    }
}
