<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = 'admin123';
        $admin->is_admin = true;
        $admin->save();

        $user = new User();
        $user->name = 'Frans';
        $user->email = 'frans@gmail.com';
        $user->password = 'frans123';
        $user->is_admin = false;
        $user->save();
    }
}