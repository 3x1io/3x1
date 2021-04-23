<?php

namespace Brackets\AdminListing\Tests;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test_models';
    protected $guarded = [];
    public $timestamps = false;
}
