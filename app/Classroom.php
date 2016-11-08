<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name','description','course_id'];

    public function instructor()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function course()
    {
    	return $this->belongsTo(Course::class);
    }

    public function students(){
    	return $this->belongsToMany(User::class,'classroom_student')
            ->withPivot('isaccepted')
            ->withTimestamps();
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('update_at')->take(5);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description']=trim($value);
    }    

    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }    
    
}