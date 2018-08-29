<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	private $globalConfig;
	private $fetchLimit;

	public function __construct()
    {
        
    }

	// Fetch all records from pages table, bound by limit.
    public function getPages($fetchLimit)
    {
    	return Page::all()->take($fetchLimit);
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
    	// Keep an update counter to return.
    	$updateCount = 0;

    	// Check if any items had a change in filename. If so, update the pages table.
    	foreach ($pageDataArray as $id => $values) {
    		if ($values['original'] !== $values['saved']) {
    			$results = Page::where('id', $id)->update(['image_path' => $values['saved']]);

    			if ($results) {
    				$updateCount++;
    			}
    		}
    	}
    	return $updateCount;
    }
}
