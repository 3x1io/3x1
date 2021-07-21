<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AreasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Area\BulkDestroyArea;
use App\Http\Requests\Admin\Area\DestroyArea;
use App\Http\Requests\Admin\Area\IndexArea;
use App\Http\Requests\Admin\Area\StoreArea;
use App\Http\Requests\Admin\Area\UpdateArea;
use App\Models\Area;
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

class AreasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexArea $request
     * @return array|Factory|View
     */
    public function index(IndexArea $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Area::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['city_id', 'id', 'lang', 'lat', 'name'],

            // set columns to searchIn
            ['id', 'lang', 'lat', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.area.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.area.create');

        return view('admin.area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArea $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreArea $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Area
        $area = Area::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/areas'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/areas');
    }

    /**
     * Display the specified resource.
     *
     * @param Area $area
     * @throws AuthorizationException
     * @return void
     */
    public function show(Area $area)
    {
        $this->authorize('admin.area.show', $area);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Area $area
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Area $area)
    {
        $this->authorize('admin.area.edit', $area);


        return view('admin.area.edit', [
            'area' => $area,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArea $request
     * @param Area $area
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateArea $request, Area $area)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Area
        $area->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/areas'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/areas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyArea $request
     * @param Area $area
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyArea $request, Area $area)
    {
        $area->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyArea $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyArea $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Area::whereIn('id', $bulkChunk)->delete();

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
        return Excel::download(app(AreasExport::class), 'areas.xlsx');
    }
}
