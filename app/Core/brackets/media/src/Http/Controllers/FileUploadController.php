<?php

namespace Brackets\Media\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FileUploadController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $this->authorize('admin.upload');

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('', ['disk' => 'uploads']);

            $cmd = config('3x1.cwebp_path') . ' -q 70 ' . storage_path('uploads/' . $path) . ' -o ' . storage_path('uploads/' . $path . '.webp');
            exec($cmd, $output, $exitCode);

            return response()->json(['path' => $path . '.webp'], 200);
        }

        return response()->json(trans('brackets/media::media.file.not_provided'), 422);
    }
}
