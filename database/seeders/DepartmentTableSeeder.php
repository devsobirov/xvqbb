<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    public static $departmentList = [
        ['name' => 'Direktor'],
        ['name' => 'Kadrlar bo\'limi'],
        ['name' => 'Buxgalter'],
    ];

    public function run(): void
    {
        if (DB::table('departments')->count() < 1) {
            DB::table('departments')->insert(self::$departmentList);
        }
    }
}
