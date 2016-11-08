<?php

namespace App;

use App\Classroom;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $fillable = ['title','description','user_id','accomplished'];

    //Relationships...
    public function classrooms()
    {
    	return $this->hasMany(Classroom::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    //Accessors and Mutators...
    public function setTitleAttribute($value)
    {
    	$this->attributes['title']=trim($value);
    }

    public function setDescriptionAttribute($value)
    {
    	$this->attributes['description']=trim($value);
    }

    //Scopes
    public function scopeAccomplished($query)
    {
        return  $query->where('accomplished',  '=',   true);
    }
}
