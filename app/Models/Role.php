<?php

namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{
    public $guard_name = 'admin';

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
        return url('/admin/roles/'.$this->getKey());
    }
}
