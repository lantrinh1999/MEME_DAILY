<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        $users[] = [
            'name' => "LINH",
            'fisrt_name' => "LINH",
            'last_name' => "LINH",
            'username' => 'linhlatin',
            'email' => 'linhtd.contact@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678@'), // password
            'remember_token' => Str::random(10),
            'is_super' => TRUE,
        ];

        if (DB::table('users')->count() <= 0) {
            try {
                DB::transaction(function () use ($users){
                    DB::table('users')->insert($users);
                });
            } catch (\Exception $e){

            }
        }
    }
}
