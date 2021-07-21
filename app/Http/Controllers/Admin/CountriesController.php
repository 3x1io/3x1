<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CountriesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\BulkDestroyCountry;
use App\Http\Requests\Admin\Country\DestroyCountry;
use App\Http\Requests\Admin\Country\IndexCountry;
use App\Http\Requests\Admin\Country\StoreCountry;
use App\Http\Requests\Admin\Country\UpdateCountry;
use App\Models\Country;
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

class CountriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCountry $request
     * @return array|Factory|View
     */
    public function index(IndexCountry $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Country::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'code', 'phone', 'lat', 'lang'],

            // set columns to searchIn
            ['id', 'name', 'code', 'phone', 'lat', 'lang']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.country.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.country.create');

        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCountry $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCountry $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Country
        $country = Country::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/countries'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/countries');
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @throws AuthorizationException
     * @return void
     */
    public function show(Country $country)
    {
        $this->authorize('admin.country.show', $country);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country $country
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Country $country)
    {
        $this->authorize('admin.country.edit', $country);


        return view('admin.country.edit', [
            'country' => $country,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCountry $request
     * @param Country $country
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCountry $request, Country $country)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Country
        $country->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/countries'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/countries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCountry $request
     * @param Country $country
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCountry $request, Country $country)
    {
        $country->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCountry $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCountry $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Country::whereIn('id', $bulkChunk)->delete();

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
        return Excel::download(app(CountriesExport::class), 'countries.xlsx');
    }
}
