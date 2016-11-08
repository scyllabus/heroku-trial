<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestItemOption extends Model
{
	public $timestamps = false;
	protected $fillable = ['content','iscorrect'];

    public function scopeAnswers($query)
    {
    	return	$query->where('iscorrect',true);
    }
}
