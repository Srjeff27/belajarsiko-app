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

        $mentors = [
            [
                'name' => 'Mentor Satu',
                'email' => 'mentor1@gmail.com',
            ],
            [
                'name' => 'Mentor Dua',
                'email' => 'mentor2@gmail.com',
            ],
        ];

        foreach ($mentors as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'role' => 'mentor',
                ]
            );

            $user->assignRole($role);
        }
    }
}
