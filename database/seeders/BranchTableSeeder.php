<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchTableSeeder extends Seeder
{
    public static $branches = [
        ['name' => "Bog'ot tumani"],
        ['name' => "Gurlan tumani"],
        ['name' => "Qo'shko'pir tumani"],
        ['name' => "Shovot tumani"],
        ['name' => "Urganch shahri"],
        ['name' => "Urganch tumani"],
        ['name' => "Xazorasp tumani"],
        ['name' => "Xiva tumani"],
        ['name' => "Xonqa tumani"],
        ['name' => "Yangiariq tumani"],
        ['name' => "Yangibozor tumani"],
    ];

    public function run(): void
    {
        if (DB::table('branches')->count() < 1) {
            DB::table('branches')->insert(self::$branches);
        }
    }
}
