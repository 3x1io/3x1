<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BlocksExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Block\BulkDestroyBlock;
use App\Http\Requests\Admin\Block\DestroyBlock;
use App\Http\Requests\Admin\Block\IndexBlock;
use App\Http\Requests\Admin\Block\StoreBlock;
use App\Http\Requests\Admin\Block\UpdateBlock;
use App\Models\Block;
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

class BlocksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBlock $request
     * @return array|Factory|View
     */
    public function index(IndexBlock $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Block::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'key'],

            // set columns to searchIn
            ['id', 'key', 'html']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.block.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.block.create');

        return view('admin.block.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBlock $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBlock $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Block
        $block = Block::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/blocks'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/blocks');
    }

    /**
     * Display the specified resource.
     *
     * @param Block $block
     * @throws AuthorizationException
     * @return void
     */
    public function show(Block $block)
    {
        $this->authorize('admin.block.show', $block);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Block $block
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Block $block)
    {
        $this->authorize('admin.block.edit', $block);


        return view('admin.block.edit', [
            'block' => $block,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBlock $request
     * @param Block $block
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBlock $request, Block $block)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Block
        $block->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/blocks'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/blocks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBlock $request
     * @param Block $block
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBlock $request, Block $block)
    {
        $block->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBlock $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBlock $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Block::whereIn('id', $bulkChunk)->delete();

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
        return Excel::download(app(BlocksExport::class), 'blocks.xlsx');
    }
}
