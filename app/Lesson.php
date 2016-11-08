<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
	use \Rutorika\Sortable\SortableTrait;

	protected $fillable = ['title','description'];

	protected static $sortableField = 'order';

	public function activity()
	{
		return $this->hasOne(Activity::class);
	}

	public function isAccomplished()
	{
		return ($this->accomplished == 0 || $this->accomplished = true);
	}

	public function course(){
		return $this->belongsTo(Course::class);
	}
}
