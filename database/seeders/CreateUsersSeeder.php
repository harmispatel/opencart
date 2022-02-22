<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
               'password'=> bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            Users::create($value);
        }
    }
}
