<?php

namespace App\Http\Controllers\Admin;

use App\Events\PushNotification;
use App\Exports\UserNotificationsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserNotification\BulkDestroyUserNotification;
use App\Http\Requests\Admin\UserNotification\DestroyUserNotification;
use App\Http\Requests\Admin\UserNotification\IndexUserNotification;
use App\Http\Requests\Admin\UserNotification\StoreUserNotification;
use App\Http\Requests\Admin\UserNotification\UpdateUserNotification;
use App\Models\UserHasNotification;
use App\Models\UserNotification;
use Brackets\AdminAuth\Models\AdminUser;
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

class UserNotificationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUserNotification $request
     * @return array|Factory|View
     */
    public function index(IndexUserNotification $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(UserNotification::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'sender_id', 'title', 'icon', 'url', 'type', 'user_id'],

            // set columns to searchIn
            ['id', 'title', 'message', 'icon', 'url', 'type']
        );

        foreach ($data as $item){
            if($item->user_id){
                $item->user_id = AdminUser::find($item->user_id);
            }

            $item->sender_id = AdminUser::find($item->sender_id);
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.user-notification.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.user-notification.create');

        return view('admin.user-notification.create', [
            'users' => AdminUser::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserNotification $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUserNotification $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the UserNotification
        $userNotification = UserNotification::create($sanitized);

        if(sizeof($userNotification->getMedia('image'))){
            $userNotification->image = $userNotification->getMedia('image')[0]->getUrl();
        }
        else {
            $userNotification->image = url('logo.svg');
        }

        if($userNotification->type === 'all'){
            $getUser = AdminUser::all();

            foreach ($getUser as $user){
                $addNotification = new UserHasNotification();
                $addNotification->user_id = $user->id;
                $addNotification->notification_id = $userNotification->id;
                $addNotification->save();
            }
        }
        else {
            $getUser = AdminUser::find($userNotification->user_id);
            if($getUser){
                $addNotification = new UserHasNotification();
                $addNotification->user_id = $getUser->id;
                $addNotification->notification_id = $userNotification->id;
                $addNotification->save();
            }
        }


        event(new PushNotification(
            $userNotification->title,
            $userNotification->message,
            $userNotification->icon,
            $userNotification->image,
            $userNotification->url,
            $userNotification->type,
            $userNotification->user_id
        ));

        if ($request->ajax()) {
            return ['redirect' => url('admin/user-notifications'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/user-notifications');
    }

    /**
     * Display the specified resource.
     *
     * @param UserHasNotification $userNotification
     * @return void
     */
    public function show(UserHasNotification $userNotification)
    {

        if($userNotification){
            $userNotification->read = 1;
            $userNotification->save();
        }

        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUserNotification $request
     * @param UserNotification $userNotification
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyUserNotification $request, UserNotification $userNotification)
    {
        UserHasNotification::where('notification_id', $userNotification->id)->delete();
        $userNotification->delete();


        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUserNotification $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyUserNotification $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    UserNotification::whereIn('id', $bulkChunk)->delete();
                    UserHasNotification::whereIn('notification_id', $bulkChunk)->delete();

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
        return Excel::download(app(UserNotificationsExport::class), 'userNotifications.xlsx');
    }
}
