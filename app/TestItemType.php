<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestItemType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
}
