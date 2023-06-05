<?php

namespace Database\Seeders;

use App\Models\User;
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
                    'department_id' => 1,
                    'role' => \Role::ADMIN,
                    'telegram_chat_id' => ''
                ],
                [
                    'name' => 'Sobirov Otabek',
                    'email' => 'devsobirov@gmail.com',
                    'password' => Hash::make('secret'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => DB::table('departments')->select('id')->inRandomOrder()->limit(1)->get()->first()->id,
                    'role' => \Role::ADMIN,
                    'telegram_chat_id' => ''
                ]
            ];

            DB::table('users')->insert($users);

            foreach (DB::table('branches')->get() as $branch) {
                User::create([
                   'name' => $branch->name,
                   'email' => 'filial_'.$branch->id.'@mail.com',
                   'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => $branch->id,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ]);
            }

            foreach (DB::table('departments')->get() as $department) {
                User::create([
                    'name' => $department->name,
                    'email' => 'department_'.$department->id.'@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => $department->id,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ]);
            }
        }
    }
}
