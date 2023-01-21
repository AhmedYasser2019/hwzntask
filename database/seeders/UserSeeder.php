<?php

namespace Database\Seeders;

use App\Repositories\Contracts\IUser;
use App\Repositories\SQL\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IUser $user)
    {
        $user->store([
            'name' => 'user',
            'last_name' => 'last name',
            'email' => 'user@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456')
        ]);
    }
}
