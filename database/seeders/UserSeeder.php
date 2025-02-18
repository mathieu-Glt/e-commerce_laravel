<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Alexandre RAVICHANDRAN',
                'email' => 'alex.rav@hotmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Corentin WAUCOMPT',
                'email' => 'corentin.wcpt@gmx.com',
                'password' => Hash::make('password'),
                'role' => 'user'
            ],
            [
                'name' => 'Mathieu GILLET',
                'email' => 'mathieu.gillet@hotmail.fr',
                'password' => Hash::make('Password@123'),
                'role' => 'admin'
            ],
            [
                'name' => 'Pierre CARLIER',
                'email' => 'pierre.carlier@gmail.com',
                'password' => Hash::make('Password@123'),
                'role' => 'user'
            ],
            [
                'name' => 'Thomas MONET',
                'email' => 'thomas.monet@gmail.fr',
                'password' => Hash::make('Password@123'),
                'role' => 'super-admin'
            ]
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, [
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]));
        }
    }
}