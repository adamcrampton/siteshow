<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Set up default admin user.
        DB::table('users')->insert([
        	'first_name' => env('SEEDER_USER_FIRST_NAME'),
            'last_name' => env('SEEDER_USER_LAST_NAME'),
            'name' => env('SEEDER_USER_DISPLAY_NAME'),
            'email' => env('SEEDER_USER_EMAIL'),
            'password' => Hash::make((env('SEEDER_USER_PASSWORD'))),
            'user_permissions_fk' => 1,
            'status' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
