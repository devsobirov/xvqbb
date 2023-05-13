<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('users')->count() < 1) {
            $users = [
                [
                    'name' => 'Administrator',
                    'email' => 'admin@mail.com',
                    'password' => Hash::make('secret'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => null,
                    'role' => 1
                ],
                [
                    'name' => 'Sobirov Otabek',
                    'email' => 'devsobirov@gmail.com',
                    'password' => Hash::make('secret'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => null,
                    'role' => 1
                ]
            ];

            DB::table('users')->insert($users);
        }
    }
}
