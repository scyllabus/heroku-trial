<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

	protected $fillable = ['lesson_id','accomplished'];

	public function lesson()
	{
		return $this->belongsTo(Lesson::class);
	}

	public function sections()
	{
		return $this->hasMany(ActivitySection::class);
	}
}
