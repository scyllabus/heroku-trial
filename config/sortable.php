<?php

return [
    'entities' => [
        //'articles' => '\App\Article',for simple sorting (entityName => entityModel) or
        // 'articles' => ['entity' => '\Article', 'relation' => 'tags'] for many to many or many to many polymorphic relation sorting...
        'lesson' => '\App\Lesson',
        'activitysection' => '\App\ActivitySection',
        'activitysectionItems' => [
	        'entity' => '\App\ActivitySection',
	        'relation' => 'items' // relation name (method name which returns $this->belongsToSortedMany)
	    ],
    ],
];