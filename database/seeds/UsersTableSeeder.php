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
        	'name' => 'administrator',
            'email' => 'administrator@email.com',
            'password' => bcrypt('password'),
            'user_permissions_fk' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
