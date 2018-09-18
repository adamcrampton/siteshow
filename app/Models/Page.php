<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	public function __construct()
    {
        
    }

	// Fetch all records from pages table, bound by limit.
    public function getPages($fetchLimit = null)
    {
        $pages = Page::where('status', 1);

        // Apply limit only if passed in.
        if ($fetchLimit) {
            $pages->take($fetchLimit);
        }

        return $pages->get();
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
            // Do not attempt the select if 'saved' doesn't exist - this would indicate it threw an exception on processing.
            if (array_key_exists('saved', $values)) {
                $rowsUpdated += Page::where('id', $id)->update(['image_path' => $values['saved']]);    
            }
    	}

    	return $rowsUpdated;
    }

    // After a record is inserted or updated, we need to ensure the other records have their ranks adjusted - so we don't have duplicate rank values.
    public function updatePageRanks($PageId, $PageRank)
    {
        // We only count rows that have an active status. Inactive records have a zero rank and shouldn't be included.
        $activePages = $this->getPages();

        // Determine if the rank passed in is the bottom of the list. If so, nothing needs to be done.
        if ($PageRank > $activePages->count()) {
            return false;
        }

        // This is not just being inserted as the last record, so we'll bump other record ranks.
        $pagesToUpdate = Page::where([
            ['status', 1],
            ['rank', '>=', $PageRank]
        ])->get();

        $pagesToUpdate->each(function($item, $key) {
            // Set a bumped rank value;
            $newRank = $item->rank + 1;

            Page::where('id', $item->id)
                ->update(['rank' => $newRank]);
        });

        return $pagesToUpdate->count();
    }
}
