<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BranchTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
