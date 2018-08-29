<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add default config.
        DB::table('configs')->insert([
            'config_name' => 'global',
        	'global_delay' => 30,
        	'fetch_limit' => 50,
        	'page_list_limit' => 50,
            'overwrite_files' => 1,
            'default_save_path' => 'storage/',
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
