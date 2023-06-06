<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    public static array $departmentList = [
        ['name' => 'Direktorat', 'prefix' => 'direktor'],
        ['name' => 'Kadrlar bo\'limi', 'prefix' => 'kadr_b'],
        ['name' => 'Buxgalteriya', 'prefix' => 'buxgalteriya'],
    ];

    public function run(): void
    {
        if (DB::table('departments')->count() < 1) {
            DB::table('departments')->insert(self::$departmentList);
        }
    }
}
