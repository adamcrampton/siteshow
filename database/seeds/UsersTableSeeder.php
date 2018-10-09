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
            [
            	'first_name' => env('SEEDER_USER_FIRST_NAME'),
                'last_name' => env('SEEDER_USER_LAST_NAME'),
                'name' => env('SEEDER_USER_DISPLAY_NAME'),
                'email' => env('SEEDER_USER_EMAIL'),
                'password' => Hash::make((env('SEEDER_USER_PASSWORD'))),
                'user_permissions_fk' => 1,
                'status' => 1,
            	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Test',
                'last_name' => 'User 1',
                'name' => 'Test User 1',
                'email' => 'test1@siteshow.test',
                'password' => Hash::make('test1'),
                'user_permissions_fk' => 3,
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Test',
                'last_name' => 'User 2',
                'name' => 'Test User 2',
                'email' => 'test2@siteshow.test',
                'password' => Hash::make('test2'),
                'user_permissions_fk' => 3,
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Test',
                'last_name' => 'User 3',
                'name' => 'Test User 3',
                'email' => 'test3@siteshow.test',
                'password' => Hash::make('test3'),
                'user_permissions_fk' => 3,
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Test',
                'last_name' => 'User 4',
                'name' => 'Test User 4',
                'email' => 'test4@siteshow.test',
                'password' => Hash::make('test4'),
                'user_permissions_fk' => 3,
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
