<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'mentor']);

        User::create([
            'name' => 'Mentor',
            'email' => 'mentor@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole($role);
    }
}