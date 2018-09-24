<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
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

    // A simple bumping of ranks after a new page has been inserted.
    public function updatePageRanksAfterInsert($pageRank)
    {
        // We only count rows that have an active status. Inactive records have a zero rank and shouldn't be included.
        $activePages = $this->getPages();

        // If doing an insert, and the rank passed in is the bottom of the list, nothing needs to be done.
        if ($pageRank > Page::max('rank')) {
            return false;
        }

        // Perform the correct query to update existing records.
        $pagesToUpdate = Page::where([
            ['status', '=', 1],
            ['rank', '>=', $pageRank]
        ])->get();


        // Do the update.
        $pagesToUpdate->each(function($item, $key) {
            // Set a bumped rank value;
            $newRank = $item->rank + 1;

            Page::where('id', $item->id)
                ->update(['rank' => $newRank]);
        });

        // Return the count (not used but useful for debugging).
        return $pagesToUpdate->count();
    }

    // If any records were made inactive, we need to ensure the ranking is adjusted to be consecutive.
    public function reindexPageRanks()
    {
        // Set up update array.
        $reindexArray = [];

        // Get all active pages and add rank as key, id as value.
        $activePages = $this->getPages();

        foreach ($activePages as $item => $itemValues) {
            $reindexArray[$itemValues->rank] = $itemValues->id;
        }

        // Reindex the array keys (starting at 1).
        $reindexArray = array_values($reindexArray);

        // Flip the array then bump the values by one (there is no zero rank).
        $reindexArray = array_flip($reindexArray);

        foreach ($reindexArray as $pageId => $rank) {
            $reindexArray[$pageId] = $reindexArray[$pageId] + 1;
        }

        // Update the pages table with correct ranking.
        foreach ($reindexArray as $pageId => $rank) {
            Page::where('id', $pageId)
                ->update(['rank' => $rank]);
        }
    }
}
