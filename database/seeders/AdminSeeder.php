<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'super admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'avatar' => 'default_avatar.jpg',
            'password' => Hash::make('12345678'), 
            
        ])->assignRole('super admin');
    }
}
