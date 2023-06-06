<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchTableSeeder extends Seeder
{
    public static array $branches = [
        [
            'name' => "Bog'ot tumani",
            'prefix' => 'bogot'
        ],
        [
            'name' => "Gurlan tumani",
            'prefix' => 'gurlan'
        ],
        [
            'name' => "Qo'shko'pir tumani",
            'prefix' => 'kushkupir'
        ],
        [
            'name' => "Shovot tumani",
            'prefix' => 'shovot'
        ],
        [
            'name' => "Urganch shahri",
            'prefix' => 'urganch_sh'
        ],
        [
            'name' => "Urganch tumani",
            'prefix' => 'urganch_t'
        ],
        [
            'name' => "Xazorasp tumani",
            'prefix' => 'xazorasp'
        ],
        [
            'name' => "Xiva tumani",
            'prefix' => 'xiva'
        ],
        [
            'name' => "Xonqa tumani",
            'prefix' => 'xonqa'
        ],
        [
            'name' => "Yangiariq tumani",
            'prefix' => 'yangiariq'
        ],
        [
            'name' => "Yangibozor tumani",
            'prefix' => 'yangibozor'
        ],
    ];

    public function run(): void
    {
        if (DB::table('branches')->count() < 1) {
            DB::table('branches')->insert(self::$branches);
        }
    }
}
