<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivitySection extends Model
{
    use \Rutorika\Sortable\SortableTrait;
	use \Rutorika\Sortable\BelongsToSortedManyTrait;

	protected $fillable = ['instruction','actvity_id','test_item_type_id'];
	protected static $sortableField = 'order';
    
    public function items()
    {
    	return $this->belongsToSortedMany(TestItem::class, 'order','activity_section_test_item');
    }
    
    public function type()
    {
    	return $this->belongsTo(TestItemType::class,'test_item_type_id','id');
    }

    public function activity(){
        return $this->belongsTo(Activity::class);
    }
}
