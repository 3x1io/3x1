<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LanguagesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Language\BulkDestroyLanguage;
use App\Http\Requests\Admin\Language\DestroyLanguage;
use App\Http\Requests\Admin\Language\IndexLanguage;
use App\Http\Requests\Admin\Language\StoreLanguage;
use App\Http\Requests\Admin\Language\UpdateLanguage;
use App\Models\Language;
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

class LanguagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLanguage $request
     * @return array|Factory|View
     */
    public function index(IndexLanguage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Language::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['arabic', 'id', 'iso', 'name'],

            // set columns to searchIn
            ['arabic', 'id', 'iso', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.language.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.language.create');

        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLanguage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLanguage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Language
        $language = Language::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/languages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/languages');
    }

    /**
     * Display the specified resource.
     *
     * @param Language $language
     * @throws AuthorizationException
     * @return void
     */
    public function show(Language $language)
    {
        $this->authorize('admin.language.show', $language);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Language $language
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Language $language)
    {
        $this->authorize('admin.language.edit', $language);


        return view('admin.language.edit', [
            'language' => $language,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLanguage $request
     * @param Language $language
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLanguage $request, Language $language)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Language
        $language->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/languages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/languages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLanguage $request
     * @param Language $language
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLanguage $request, Language $language)
    {
        $language->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLanguage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLanguage $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Language::whereIn('id', $bulkChunk)->delete();

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
        return Excel::download(app(LanguagesExport::class), 'languages.xlsx');
    }
}
