<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	public function __construct()
    {
        
    }

	// Fetch all records from pages table, bound by limit.
    public function getPages($fetchLimit)
    {
        return Page::where('status', 1)->take($fetchLimit)->get();
    }

    // Pass back id and url in a tidy Collection for prcocessing.
    public function getPageData($pageCollection)
    {
    	$pageData = $pageCollection->map(function($page) {
    		return $page->only(['id', 'url', 'image_path']);
    	});

    	return $pageData;
    }

    public function processUpdates($pageDataArray)
    {
    	// Keep counters to easily return important values.
    	$rowsUpdated = 0;
    	
    	foreach ($pageDataArray as $id => $values) {
    		// Update all rows, increment count if the values have changed, indicating a new file was created.
			$rowsUpdated += Page::where('id', $id)->update(['image_path' => $values['saved']]);
    	}

    	return $rowsUpdated;
    }
}
