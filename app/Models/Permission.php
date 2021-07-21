<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable = [
        'guard_name',
        'name',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/permissions/'.$this->getKey());
    }
}
