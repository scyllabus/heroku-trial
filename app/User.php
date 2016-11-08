<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','contact','email', 'password', 'account_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Date attributes...
     */
    protected $dates = ['delete_at','update_at'];

    /**
     * Accessors & Mutators
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name']=trim(strtolower($value));
    }

    public function getFirstNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name']=trim(strtolower($value));
    }

    public function getLastNameAttribute($value)
    {
        return ucwords($value);
    }


    //FUNCTIONS...
    /**
     * Account type admin check...
     */
    public function isAdmin()
    {
        return $this->account_type == 'admin';
    }

    /**
     * Account type instructor check...
     */
    public function isInstructor()
    {
        return $this->account_type == 'instructor';
    }

    /**
     * Account type instructor check...
     */
    public function isStudent()
    {
        return $this->account_type == 'student';
    }

    public function getFullName()
    {
        return title_case($this->last_name.', '.$this->first_name);
    }

    /**
     * Relationships...
     */
    public function classrooms()
    {
        if ($this->isInstructor()) {
            return $this->hasMany(Classroom::class);
        } else if ($this->isStudent()){
            return $this->belongsToMany(Classroom::class,'classroom_student')
                ->withPivot('isaccepted')
                ->withTimeStamps();
        }
    }

    public function courses()
    {
        if ($this->isInstructor()) {
            return $this->hasMany(Course::class);
        } 
    }
}
