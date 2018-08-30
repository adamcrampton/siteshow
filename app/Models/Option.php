<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name',
        'option_value'
    ];

    public function getGlobalConfig()
    {
    	$allConfig = Option::all();

    	dd($allConfig->flatten());
    }
}
