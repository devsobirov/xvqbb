<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchTableSeeder extends Seeder
{
    public static array $branches = [
        [
            'name' => "Urganch shahar",
            'prefix' => 'urganch_sh'
        ],
        [
            'name' => "Urganch tuman",
            'prefix' => 'urganch_t'
        ],
        [
            'name' => "Bog'ot tuman",
            'prefix' => 'bogot'
        ],
        [
            'name' => "Gurlan tuman",
            'prefix' => 'gurlan'
        ],
        [
            'name' => "Qo'shko'pir tuman",
            'prefix' => 'kushkupir'
        ],
        [
            'name' => "Xazarasp tuman",
            'prefix' => 'xazarasp'
        ],
        [
            'name' => "Xiva shahar",
            'prefix' => 'xiva_sh'
        ],
        [
            'name' => "Xiva tuman",
            'prefix' => 'xiva_t'
        ],
        [
            'name' => "Xonqa tuman",
            'prefix' => 'xonqa'
        ],
        [
            'name' => "Shovot tuman",
            'prefix' => 'shovot'
        ],
        [
            'name' => "Yangiariq tuman",
            'prefix' => 'yangiariq'
        ],
        [
            'name' => "Yangibozor tuman",
            'prefix' => 'yangibozor'
        ],
        [
            'name' => "Tuproqqal’a tuman",
            'prefix' => 'tuoroqqala'
        ],
    ];

    public function run(): void
    {
        if (DB::table('branches')->count() < 1) {
            DB::table('branches')->insert(self::$branches);
        }
    }
}
