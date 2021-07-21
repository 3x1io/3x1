<?php

namespace App\Models;

use Brackets\AdminAuth\Models\AdminUser;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserNotification extends Model implements HasMedia
{

    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;


    protected $fillable = [
        'sender_id',
        'title',
        'message',
        'icon',
        'url',
        'type',
        'user_id',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/user-notifications/' . $this->getKey());
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('image')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }

    public function userId(){
        $this->belongsTo(AdminUser::class, 'user_id', 'id');
    }

    public function senderId(){
        $this->belongsTo(AdminUser::class, 'sender_id', 'id');
    }
}

