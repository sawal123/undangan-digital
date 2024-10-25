<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = Role::create(['name' => 'Owner']);
        $reseller = Role::create(['name' => 'Reseller']);
        $user = Role::create(['name' => 'User']);

        $userOwner = User::create([
            'name'=> 'Sawal',
            'avatar'=> 'images/default-avatar.png',
            'phone'=> '0812626562',
            'google_id'=> 'NULL',
            'is_active'=> false,
            'email'=>'sawal@owner.com',
            'password'=>bcrypt('sawal123')
        ]);

        $userUser = User::create([
            'name'=> 'Lin',
            'avatar'=> 'images/default-avatar.png',
            'phone'=> '0812626562',
            'google_id'=> 'NULL',
            'is_active'=> false,
            'email'=>'lin@user.com',
            'password'=>bcrypt('sawal123')
        ]);
        $userOwner->assignRole($owner);
        $userUser->assignRole($user);
    }
}
