<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add default config.
        DB::table('pages')->insert([
            [
                'name' => 'BBC News',
            	'url' => 'https://www.bbc.com/news/world',
            	'status' => 1,
            	'duration' => 30,
                'image_path' => '',
                'rank' => 1,
            	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Business Insider',
                'url' => 'https://www.businessinsider.com',
                'status' => 1,
                'duration' => 30,
                'image_path' => '',
                'rank' => 2,
                'duration' => 20,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'SBS World News',
                'url' => 'https://www.sbs.com.au/news/topic/world',
                'status' => 1,
                'duration' => 30,
                'image_path' => '',
                'rank' => 3,
                'duration' => 30,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
