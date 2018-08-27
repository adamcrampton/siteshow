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

    public function getPageUrls($pageCollection)
    {
    	return $pageCollection->pluck('url');
    }
}
