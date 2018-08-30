<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add default config.
        DB::table('options')->insert([
            [
                'option_name' => 'global_delay',
            	'option_value' => 30,
            ],
            [
                'option_name' => 'global_fetch_limit',
            	'option_value' => 50,
            ],
            [
                'option_name' => 'global_page_list_limit',
            	'option_value' => 50,
            ],
            [
                'option_name' => 'global_overwrite_files',
            	'option_value' => 1,
            ], 
            [
                'option_name' => 'global_fetch_window_width',
            	'option_value' => '1920',
            ],
            [
                'option_name' => 'global_fetch_window_height',
            	'option_value' => '1080',
            ],
            [
                'option_name' => 'dismiss_dialogues',
            	'option_value' => 1,
            ],
            [
                'option_name' => 'wait_until_network_idle',
            	'option_value' => 1,
            ],
            [
                'option_name' => 'global_fetch_delay',
            	'option_value' => 0,
            ],
            [
                'option_name' => 'default_save_path',
            	'option_value' => 'storage/',
            ]
        ]);
    }
}
