<?php

namespace App\Exports;

use App\Models\UserNotification;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserNotificationsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return UserNotification::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.user-notification.columns.id'),
            trans('admin.user-notification.columns.sender_id'),
            trans('admin.user-notification.columns.title'),
            trans('admin.user-notification.columns.message'),
            trans('admin.user-notification.columns.icon'),
            trans('admin.user-notification.columns.url'),
            trans('admin.user-notification.columns.type'),
            trans('admin.user-notification.columns.user_id'),
        ];
    }

    /**
     * @param UserNotification $userNotification
     * @return array
     *
     */
    public function map($userNotification): array
    {
        return [
            $userNotification->id,
            $userNotification->sender_id,
            $userNotification->title,
            $userNotification->message,
            $userNotification->icon,
            $userNotification->url,
            $userNotification->type,
            $userNotification->user_id,
        ];
    }
}
