<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class Medium extends Model
{
use HasTranslations;
    protected $fillable = [
        'collection_name',
        'conversions_disk',
        'custom_properties',
        'disk',
        'file_name',
        'generated_conversions',
        'manipulations',
        'mime_type',
        'model_id',
        'model_type',
        'name',
        'order_column',
        'responsive_images',
        'size',
        'uuid',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];
    // these attributes are translatable
    public $translatable = [
        'custom_properties',
        'generated_conversions',
        'manipulations',
        'responsive_images',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/media/'.$this->getKey());
    }
}
