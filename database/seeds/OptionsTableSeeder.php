<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
                'option_nice_name' => 'Email Results',
                'option_name' => 'global_email_results',
                'option_value' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Notifications Email Address',
                'option_name' => 'global_email',
                'option_value' => 'admin@site.com',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Delay',
                'option_name' => 'global_delay',
            	'option_value' => 30,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Fetch Limit',
                'option_name' => 'global_fetch_limit',
            	'option_value' => 50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Page List Limit',
                'option_name' => 'global_page_list_limit',
            	'option_value' => 50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],    
            [
                'option_nice_name' => 'Overwrite Files',
                'option_name' => 'global_overwrite_files',
            	'option_value' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ], 
            [
                'option_nice_name' => 'Fetch Window Width',
                'option_name' => 'global_fetch_window_width',
            	'option_value' => '1920',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Fetch Window Height',
                'option_name' => 'global_fetch_window_height',
            	'option_value' => '1080',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Dimiss Dialogues',
                'option_name' => 'dismiss_dialogues',
            	'option_value' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Wait Until Network Idle',
                'option_name' => 'wait_until_network_idle',
            	'option_value' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Fetch Delay',
                'option_name' => 'global_fetch_delay',
            	'option_value' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Fetch Timeout',
                'option_name' => 'global_fetch_timeout',
                'option_value' => 100000,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'User Agent',
                'option_name' => 'user_agent',
                'option_value' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'option_nice_name' => 'Save Path',
                'option_name' => 'default_save_path',
            	'option_value' => 'storage/',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
