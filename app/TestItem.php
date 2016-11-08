<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestItem extends Model
{
    public function options()
    {
    	return $this->hasMany(TestItemOption::class);
    }
    
    public function type()
    {
    	return $this->belongsTo(TestItemType::class, 'test_item_type_id','id');
    }
    
}
